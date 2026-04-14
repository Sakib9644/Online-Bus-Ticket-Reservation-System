<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BusRoute;
class BusRouteController extends Controller

{
   public function list()
   {
      $busroutes=BusRoute::all();
      return view('admin.pages.BusRoute.busroute-list',compact('busroutes'));
   }
   
   public function create()
   {

      return view('admin.pages.BusRoute.busroute-create');
   }

   public function store(Request $request)
   {
         $request->validate([
            'bus_type'=>'required',
            'location_from'=>'required',
            'location_to'=>'required',
            'bus_route_time'=>'required',
            'bus_route_date'=>'required|date',
            'bus_departure_from'=>'required',
            'bus_departure_to'=>'required',
            'bus_fare'=>'required|numeric',
        ]);
               //  dd($request);
         BusRoute::create ([
                  // field name for DB || field name for form
                  'bus_type'=>$request->bus_type,
                  'location_from'=>$request->location_from,
                  'location_to'=>$request->location_to,
                  'bus_route_time'=>$request->bus_route_time,
                  'bus_route_date'=>$request->bus_route_date,
                  'bus_departure_from'=>$request->bus_departure_from,
                  'bus_departure_to'=>$request->bus_departure_to,
                  'bus_fare'=>$request->bus_fare,
      ]);
      return redirect()->back()->with('msg','Bus route created successfully!');
   }
   public function bus_route_Details($busroute_id)
   {
      $busroute=BusRoute::find($busroute_id);
      return view ('admin.pages.BusRoute.bus-route-details',compact('busroute'));
   }

   public function bus_route_Delete($busroute_id)
   {
      BusRoute::find($busroute_id)->delete();
      return redirect()->back()->with('success','Bus Route Deleted.');
   }
}