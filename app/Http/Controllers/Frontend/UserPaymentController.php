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

        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$booking) {
            return redirect()->route('booking.details')->with('error', 'Booking not found or already expired.');
        }

        if (strtolower((string) $booking->status) !== 'pending') {
            return redirect()->route('view.info', ['id' => $id])->with('message', 'Booking is already paid or no longer pending.');
        }

        if ($booking->expires_at && $booking->expires_at->isPast()) {
            $booking->delete();
            return redirect()->route('booking.details')->with('error', 'Payment window expired. Please book again.');
        }

        Payment::create([
            'user_id' => Auth::id(),
            'payment_mathod' => $request->payment_mathod,
            'transaction_id' => $request->transaction_id,
            'amount' => $booking->amount,
        ]);

        $booking->status = 'complete';
        $booking->expires_at = null;
        $booking->save();


        return redirect()->route('view.info', ['id' => $id])->with('message', 'Payment Succefully!');
    }
}
