<?php

namespace App\Http\Controllers\Frontend;
use App\Models\Booking;
use App\Services\BookingExpiryService;
use App\Http\Controllers\Controller;

class BookingDetailsController extends Controller
{
    public function bookingdetails(){
        app(BookingExpiryService::class)->releaseExpiredPending();

        $rawDetails = Booking::with('seat.bus')
            ->where('user_id', auth()->user()->id)
            ->where(function ($query) {
                $query->whereRaw('LOWER(status) = ?', ['pending'])
                    ->orWhereRaw('LOWER(status) = ?', ['complete']);
            })
            ->orderBy('id', 'DESC')
            ->get();

        // Group by booking reference so separate orders for the same trip stay separate.
        $groupedDetails = $rawDetails->groupBy(function($item) {
            if (!empty($item->ticket_no)) {
                return 'ticket:' . $item->ticket_no;
            }

            // Legacy fallback for old rows without ticket reference.
            return 'trip:' . $item->trip_id;
        });

        return view('frontend.pages.bookingdetails', compact('groupedDetails'));
    }

    public function viewinfo($id){
        app(BookingExpiryService::class)->releaseExpiredPending();

        $ids = explode(',', $id);
        if (count($ids) > 1) {
            $details = Booking::whereIn('id', $ids)->get();
            $detail = $details->first();
        } else {
            $detail = Booking::find($id);
            $details = null;
        }

        if (!$detail) {
            return redirect()->route('booking.details')->with('error', 'Booking not found or payment window expired.');
        }

        // Fetch Trip to get Origin/Destination (Fixes N/A bug)
        $trip = \App\Models\Trip::where('bus_id', $detail->bus_id)
                    ->where('date', $detail->date)
                    ->where('time', $detail->time)
                    ->first();

        return view('frontend.pages.viewinfo', compact('detail', 'details', 'trip'));
    }
}



