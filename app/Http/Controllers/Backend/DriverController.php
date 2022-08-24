<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function list(){
        $drivers=Driver::all();
      //   dd($drivers);
     return view('admin.pages.Driver.driver-list',compact('drivers'));
  }
  
  public function create(){
     return view('admin.pages.Driver.driver-create');
  }
  public function store(Request $request){

   $request->validate([
      'name'=>'required',
      'id'=>'required|numeric',
      'phone'=>'required|numeric|digits:11',
      'bus_name'=>'required',
      'bus_no'=>'required|numeric',
  ]);
   Driver::create ([
            // field name for DB || field name for form
            'driver_name'=>$request->name,
            'driver_id'=>$request->id,
            'driver_phone_number'=>$request->phone,
            'bus_name'=>$request->bus_name,
            'bus_no'=>$request->bus_no,
]);
return redirect()->back()->with('msg','Driver created successfully!');
}
public function driverDetails($driver_id){
   $driver=Driver::find($driver_id);
   return view ('admin.pages.Driver.driver-details',compact('driver'));
 }

public function driverDelete($driver_id){

Driver::find($driver_id)->delete();

return redirect()->back()->with('success','driver Deleted.');
}
}