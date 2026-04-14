<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserPaymentController extends Controller
{
    public function userpayment($id){
        $bookingIds = explode(',', $id);
        $bookings = Booking::whereIn('id', $bookingIds)->get();
        
        if ($bookings->isEmpty()) {
            return redirect()->back()->with('error', 'Bookings not found.');
        }

        // Check if any of these bookings are already completed
        $view = $bookings->where('status', 'complete')->count() === $bookings->count();

        // Calculate total bundled amount
        $totalAmount = $bookings->sum('amount');

        return view('frontend.pages.userpayment', compact('id', 'bookings', 'totalAmount', 'view'));
    }

    public function store(Request $request,$id){

       
       
        
       // dd($request->all());
        // dd($id);     
        Payment::create([
            'user_id'=>Auth::user()->id,
            'payment_mathod'=>$request->payment_mathod,
            'transaction_id'=>$request->transaction_id,
            'amount'=>$request->amount,
        ]);
        $Bookingg =  $booking = Booking::find($id);

        $Bookingg->status = 'complete';
        $Bookingg->save();
       
        
        return redirect()->route('view.info', ['id' => $id])->with('message', 'Payment Succefully!');
    }
}