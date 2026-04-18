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
            'bus_id'=>'required',
            'total_seats'=>'required_without:name|nullable|numeric|min:1|max:60',
            'name'=>'required_without:total_seats|nullable|string',
        ]);

        if ($request->total_seats) {
            // Bulk Generation Logic
            $rows = 'ABCDEFGHIJKLMN';
            $seatsPerRow = 4;
            $count = 0;
            
            for ($i = 0; $i < ceil($request->total_seats / $seatsPerRow); $i++) {
                $rowChar = $rows[$i];
                for ($j = 1; $j <= $seatsPerRow; $j++) {
                    if ($count >= $request->total_seats) break;
                    
                    Seat::create([
                        'name' => $rowChar . $j,
                        'bus_id' => $request->bus_id,
                    ]);
                    $count++;
                }
            }
            return redirect()->route('admin.seat')->with('message', $count . ' seats automatically generated for the selected bus.');
        }

        Seat::create([
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