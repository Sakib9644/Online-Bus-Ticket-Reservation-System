<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $drivers = Driver::latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($drivers)
                ->addIndexColumn()
                ->addColumn('driver_info', function($row){
                    return '<div>
                                <div style="font-weight:700; color:#1e293b; font-size:15px;">'.$row->driver_name.'</div>
                                <div style="font-size:12px; color:var(--muted); margin-top:2px;">ID: '.$row->driver_id.' | '.$row->driver_phone_number.'</div>
                            </div>';
                })
                ->addColumn('vehicle', function($row){
                    return '<div>
                                <div style="font-weight:600; font-size:13px; color:#475569;">'.$row->bus_name.'</div>
                                <div style="font-size:11px; color:var(--muted); font-family:monospace;">'.$row->coach_no.'</div>
                            </div>';
                })
                ->addColumn('actions', function($row){
                    $btn = '<div style="display:flex; gap:8px;">
                                <a href="'.route('admin.driver.details', $row->id).'" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#3b82f6;"><i class="fas fa-eye"></i></a>
                                <a onclick="return confirm(\'Delete this driver record?\')" href="'.route('admin.driver.delete', $row->id).'" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['driver_info', 'vehicle', 'actions'])
                ->make(true);
        }
        return view('admin.pages.Driver.driver-list');
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