<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function list(){
      $locations=Location::latest()->paginate(5);
      //   dd($locations);
        return view('admin.pages.Location.location-list',compact('locations'));
     }

     public function create(){

        return view('admin.pages.Location.location-create');
     }
     public function store(Request $request){
      $request->validate([
         'location_from'=>'required',
         'location_to'=>'required',
      ]);

   Location::create ([
               // field name for DB || field name for form
               'location_from'=>$request->location_from,
               'location_to'=>$request->location_to,
   ]);
   return redirect()->route('admin.location')->with('success','Location created successfully!');
}
public function locationEdit($id){
   // dd($id);
   $location = Location::find($id);
   // dd($location);
   $locations = Location::all();
   if ($location) {
       return view('admin.pages.Location.location-edit',compact('location'));
   }
}
public function locationUpdate(Request $request,$id){
   // dd($request->all());
   // dd($id);
   $location = Location::find($id);
   // dd($location);
   if ($location) {
       $location->update([
         'location_from'=>$request->location_from,
         'location_to'=>$request->location_to,
       ]);
       return redirect()->route('admin.location')->with('success','Location updated!');
   }
}

public function locationDelete($id){

Location::find($id)->delete();
return redirect()->route('admin.location')->with('msg','Location Deleted.');
}
}