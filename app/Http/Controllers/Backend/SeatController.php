<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\Bus;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    public function list(){
      $seats=Seat::latest()->paginate(5);
         return view('admin.pages.Seat.seat-list',compact('seats'));
      }

      public function create(){
         $buses=Bus::all();
         return view('admin.pages.Seat.seat-create', compact('buses'));
      }

      public function store(Request $request){

         $request->validate([
            'name'=>'required',
            'bus_id'=>'required',
        ]);

      Seat::create([
         //field name for DB || field name for form

         'name'=>$request->name,
         'bus_id'=>$request->bus_id,
      ]);
      return redirect()->route('admin.seat')->with('message','Seat created successfully!');
}

public function seatEdit($id){
   // dd($id);
   $seat = Seat::find($id);
   // dd($product);
   $seats = Seat::all();
   $buses=Bus::all();
   if ($seat) {
       return view('admin.pages.Seat.seat-edit',compact('seat','buses'));
   }
}

public function seatUpdate(Request $request,$id){
   // dd($request->all());
   // dd($id);
   $seat = Seat::find($id);
   // dd($seat);
   if ($seat) {
       $seat->update([
         'name'=>$request->name,
         'bus_id'=>$request->bus_id,
       ]);

       return redirect()->route('admin.seat')->with('success','Seat Updated!');
   }
}
public function seatDelete($id){

Seat::find($id)->delete();

return redirect()->route('admin.seat')->with('msg','Seat Deleted.');
}
}