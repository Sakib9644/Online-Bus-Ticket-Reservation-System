<?php

namespace App\Http\Controllers\Frontend;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookingDetailsController extends Controller
{
    public function bookingdetails(){
        $rawDetails = Booking::with('seat.bus')->where('user_id', auth()->user()->id)->orderBy('id', 'DESC')->get();
        
        // Group logic: bundle seats bought for the exact same trip itinerary
        $groupedDetails = $rawDetails->groupBy(function($item) {
            return $item->trip_id;
        });

        return view('frontend.pages.bookingdetails', compact('groupedDetails'));
    }

    public function viewinfo($id){
        $ids = explode(',', $id);
        if (count($ids) > 1) {
            $details = Booking::whereIn('id', $ids)->get();
            $detail = $details->first();
        } else {
            $detail = Booking::find($id);
            $details = null;
        }

        // Fetch Trip to get Origin/Destination (Fixes N/A bug)
        $trip = \App\Models\Trip::where('bus_id', $detail->bus_id)
                    ->where('date', $detail->date)
                    ->where('time', $detail->time)
                    ->first();

        return view('frontend.pages.viewinfo', compact('detail', 'details', 'trip'));
    }
}

    

  