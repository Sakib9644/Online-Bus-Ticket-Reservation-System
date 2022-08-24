<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    public function list(){
        $bookings = Booking::with('seat')->get();
        return view('admin.pages.Booking.booking-list',compact('bookings'));
    }

    public function bookingStatus($id){
      $booking=Booking::find($id);
      $booking->update([
          'status'=>'complete'
      ]);
      return redirect()->back();
    }

    
        public function cancle($id){
            $cancle=Booking::find($id);
            $cancle->delete();
            return redirect()->back();
           
        }   
        public function bookingdelete($id)
    {
        $bookingdelete=Booking::find($id);
        $bookingdelete->delete();
        return redirect()->route('admin.booking.list')->with('msg', 'boooking Deleted.');
    }
        
        }


