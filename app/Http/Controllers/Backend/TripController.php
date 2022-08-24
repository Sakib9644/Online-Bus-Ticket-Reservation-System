<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Trip;
use App\Models\Bus;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function list()
    {
        $trips = Trip::with('bus')->latest()->paginate(5);
        return view('admin.pages.Trip.trip-list', compact('trips'));
    }

    public function create()
    {
        $locations = Location::all();
        $buses = Bus::all();
        return view('admin.pages.Trip.trip-create', compact('locations', 'buses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'location_from' => 'required',
            'location_to' => 'required',
            'bus_id' => 'required',
            'date' => 'required|date',
            'time' => 'required',
            'bus_fare' => 'required|numeric',
        ]);

        Trip::create([
            'location_from' => $request->location_from,
            'location_to' => $request->location_to,
            'bus_id' => $request->bus_id,
            'date' => $request->date,
            'time' => $request->time,
            'fare' => $request->bus_fare,
        ]);
        return redirect()->route('admin.trip')->with('message', 'Trip created successfully!');
    }

    public function edit($id)
    {
        $trip = Trip::find($id);
        $locations = Location::all();
        $buses = Bus::all();
        if ($trip) {
            return view('admin.pages.Trip.trip-edit', compact('trip', 'locations', 'buses'));
        }
    }

    public function update(Request $request, $id)
    {
        $trip = Trip::find($id);
        if ($trip) {
            $trip->update([
                'location_from' => $request->location_from,
                'location_to' => $request->location_to,
                'bus_id' => $request->bus_id,
                'date' => $request->date,
                'time' => $request->time,
                'fare' => $request->bus_fare,
            ]);
            return redirect()->route('admin.trip')->with('success', 'Trip Updated!');
        }
    }

    public function delete($id)
    {
        Trip::find($id)->delete();
        return redirect()->route('admin.trip')->with('msg', 'Trip Deleted.');
    }
}