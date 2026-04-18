<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Location;
use App\Models\Trip;
use App\Models\Bus;
use App\Models\City;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $trips = Trip::with('bus')->latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($trips)
                ->addIndexColumn()
                ->addColumn('route_map', function($row){
                    return '<div style="display:flex; align-items:center; gap:10px;">
                                <div style="font-weight:700; color:#1e293b;">'.$row->location_from.'</div>
                                <i class="fas fa-long-arrow-alt-right" style="color:var(--accent); font-size:12px; opacity:0.6;"></i>
                                <div style="font-weight:700; color:#1e293b;">'.$row->location_to.'</div>
                            </div>';
                })
                ->addColumn('vehicle', function($row){
                    $bus_name = $row->bus->bus_name ?? 'N/A';
                    $coach_no = $row->bus->coach_no ?? '';
                    return '<div>
                                <div style="font-weight:600; font-size:13px; color:#475569;">'.$bus_name.'</div>
                                <div style="font-size:11px; color:var(--muted); font-family:monospace;">'.$coach_no.'</div>
                            </div>';
                })
                ->addColumn('schedule', function($row){
                    $date = \Carbon\Carbon::parse($row->date)->format('d M, Y');
                    return '<div>
                                <div style="font-weight:700; color:#0f172a; font-size:13px;">'.$date.'</div>
                                <div style="font-size:12px; color:var(--muted); margin-top:2px;">'.$row->time.'</div>
                            </div>';
                })
                ->addColumn('fare_display', function($row){
                    return '<div style="font-weight:800; color:var(--accent); font-size:15px;">৳'.number_format($row->fare).'</div>';
                })
                ->addColumn('actions', function($row){
                    $btn = '<div style="display:flex; gap:8px;">
                                <a href="'.route('admin.trip.edit',$row->id).'" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#8b5cf6;"><i class="fas fa-edit"></i></a>
                                <form action="'.route('admin.trip.delete',$row->id).'" method="POST" onsubmit="return confirm(\'Delete this trip?\')" style="display:inline;">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" class="btn-danger-admin" style="padding:8px 12px; font-size:12px; border:none; background:none; color:#ef4444;"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['route_map', 'vehicle', 'schedule', 'fare_display', 'actions'])
                ->make(true);
        }
        return view('admin.pages.Trip.trip-list');
    }

    public function create()
    {
        $cities = City::orderBy('name')->get();
        $buses = Bus::all();
        return view('admin.pages.Trip.trip-create', compact('cities', 'buses'));
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
        $cities = City::orderBy('name')->get();
        $buses = Bus::all();
        if ($trip) {
            return view('admin.pages.Trip.trip-edit', compact('trip', 'cities', 'buses'));
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
