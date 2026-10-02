<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Payment;
use App\Services\BookingExpiryService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPaymentController extends Controller
{
    public function userpayment($id)
    {
        app(BookingExpiryService::class)->releaseExpiredPending();

        $bookingIds = explode(',', $id);
        $bookings = Booking::whereIn('id', $bookingIds)
            ->where('user_id', Auth::id())
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.details')->with('error', 'Booking not found or payment window expired.');
        }

        $pendingBookings = $bookings->filter(function ($booking) {
            return strtolower((string) $booking->status) === 'pending';
        });

        // Check if all seats in this bundle are completed
        $view = $bookings->every(function ($booking) {
            return strtolower((string) $booking->status) === 'complete';
        });

        $pendingExpiryAt = $pendingBookings->min('expires_at');
        $pendingExpiresAtIso = $pendingExpiryAt ? $pendingExpiryAt->toIso8601String() : null;
        $pendingExpiresAtHuman = $pendingExpiryAt ? $pendingExpiryAt->format('d M Y, h:i A') : null;

        // Calculate total bundled amount
        $totalAmount = $bookings->sum('amount');

        return view('frontend.pages.userpayment', compact('id', 'bookings', 'totalAmount', 'view', 'pendingExpiresAtIso', 'pendingExpiresAtHuman'));
    }

    public function store(Request $request, $id)
    {
        app(BookingExpiryService::class)->releaseExpiredPending();

        $bookingIds = explode(',', $id);
        $bookings = Booking::whereIn('id', $bookingIds)
            ->where('user_id', Auth::id())
            ->get();

        if ($bookings->isEmpty()) {
            return redirect()->route('booking.details')->with('error', 'Booking not found or already expired.');
        }

        $pendingBookings = $bookings->filter(fn($b) => strtolower((string)$b->status) === 'pending');

        if ($pendingBookings->isEmpty()) {
            return redirect()->route('view.info', ['id' => $id])->with('message', 'Booking is already paid or completed.');
        }

        $request->validate([
            'transaction_id' => 'required|string|min:4|max:50',
            'payment_method' => 'nullable|string',
            'sender_number' => 'nullable|string|max:20',
        ]);

        $totalAmount = $pendingBookings->sum('amount');
        $method = $request->payment_method ?: $request->payment_mathod ?: 'bKash/Nagad/Rocket';
        $sender = $request->sender_number ? ' (' . $request->sender_number . ')' : '';
        $ticketNo = $pendingBookings->first()->ticket_no ?: ('SB-' . date('y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6)));

        Payment::create([
            'user_id' => Auth::id(),
            'payment_mathod' => $method . $sender,
            'transaction_id' => $request->transaction_id,
            'amount' => $totalAmount,
        ]);

        \Illuminate\Support\Facades\DB::table('bookings')
            ->whereIn('id', $pendingBookings->pluck('id'))
            ->update([
                'status' => 'complete',
                'ticket_no' => $ticketNo,
                'expires_at' => null,
            ]);

        return redirect()->route('view.info', ['id' => $id])->with('message', 'Payment recorded successfully! Your booking is confirmed.');
    }
}
