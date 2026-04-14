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
        
        // Group logic: bundle seats bought for the exact same trip itinerary and payment status
        $groupedDetails = $rawDetails->groupBy(function($item) {
            return $item->bus_id . '|' . $item->date . '|' . $item->time . '|' . $item->status;
        });

        return view('frontend.pages.bookingdetails', compact('groupedDetails'));
    }

    public function viewinfo($id){
        $detail = Booking::find($id);
        return view('frontend.pages.viewinfo',compact('detail'));

    }


    }

    

  