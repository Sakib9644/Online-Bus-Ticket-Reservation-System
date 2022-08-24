<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\Trip;
use App\Models\Location;
use Illuminate\Http\Request;

class HomeController extends Controller
{
   public function home()
   {
       $buses=Bus::all();
       return view('frontend.pages.home',compact('buses'));
   }
   public function reserveForm(){
        $locations=Location::all();
       return view('frontend.pages.reserve-form', compact('locations'));
   }

   public function showTrip(Request $request)
   {
        $locations=Location::all();
        $trips = Trip::with('bus')
               ->where('location_from', $request->from)
               ->where('location_to', $request->to)
               ->where('date', $request->date)
               ->where('time', $request->time)
               ->get();
        return view('frontend.pages.show-trips',compact('trips','locations'));  
   }

   public function bookTrip($id)
   {
        $locations=Location::all();
        $trip = Trip::with('bus')->findOrFail($id);
        return view('frontend.pages.book-trips',compact('trip'));  
   }
}