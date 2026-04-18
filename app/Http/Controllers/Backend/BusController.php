<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\User;
use Illuminate\Http\Request;

class BusController extends Controller
{
  public function list(Request $request)
  {
    if ($request->ajax()) {
        $buses = Bus::latest()->get();
        return \Yajra\DataTables\Facades\DataTables::of($buses)
            ->addIndexColumn()
            ->addColumn('bus_info', function($row){
                return '<div>
                            <div style="font-weight:700; color:#1e293b; font-size:15px;">'.$row->bus_name.'</div>
                            <div style="font-size:12px; color:var(--muted); margin-top:2px;">Added on '.$row->created_at->format('d M Y').'</div>
                        </div>';
            })
            ->addColumn('type', function($row){
                return '<span class="badge-info">'.strtoupper($row->bus_type).'</span>';
            })
            ->addColumn('actions', function($row){
                $btn = '<div style="display:flex; gap:8px;">
                            <a href="'.route('admin.bus.details', $row->id).'" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#3b82f6;"><i class="fas fa-eye"></i></a>
                            <a href="'.route('admin.bus.edit', $row->id).'" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#8b5cf6;"><i class="fas fa-edit"></i></a>
                            <a onclick="return confirm(\'Archive this vehicle?\')" href="'.route('admin.bus.delete', $row->id).'" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                        </div>';
                return $btn;
            })
            ->rawColumns(['bus_info', 'type', 'actions'])
            ->make(true);
    }
    return view('admin.pages.Bus.bus-list');
  }

  public function create()
  {
      return view('admin.pages.Bus.bus-create');
  }

  public function store(Request $request)
  {
      $filename = "";
      if($request->hasFile('bus_image')){
        $file = $request->file('bus_image');
        $filename = date('Ymdhms').'.'.$file->getclientOriginalExtension();
        $file->storeAs('/uploads',$filename);
      }

      $request->validate([
        'bus_name'=>'required',
        'coach_no'=>'required',
        'bus_type'=>'required',
      ]);

      // dd('ok');
      // dd($request->all());

      Bus::create ([
          'bus_name'=>$request->bus_name,
          'coach_no'=>$request->coach_no,
          'bus_type'=>$request->bus_type,
          'image'=>$filename
      ]);
      return redirect()->route('admin.bus')->with('success','Bus created successfully!');
    }

  public function busEdit($id)
    {
        $bus = Bus::find($id);
        if ($bus) {
            return view('admin.pages.Bus.edit',compact('bus'));
        }
    }

    public function busUpdate(Request $request,$id){
        $bus = Bus::find($id);
        $filename = '';
      if($request->hasFile('bus_image')){
        $file = $request->file('bus_image');
        $filename = date('Ymdhms').'.'.$file->getclientOriginalExtension();
        $file->storeAs('/uploads',$filename);
      }
        if ($bus) {
            $bus->update([
                'bus_name'=>$request->bus_name,
                'coach_no'=>$request->coach_no,
                'bus_type'=>$request->bus_type,
                'image'=>$filename
            ]);
            return redirect()->route('admin.bus')->with('message','Bus Updated successfully!');
        }
    }

  public function busDetails($bus_id)
  {
    $bus=Bus::find($bus_id);
    return view ('admin.pages.Bus.bus-details',compact('bus'));
  }

  public function busDelete($bus_id)
  {
    Bus::find($bus_id)->delete();
    return redirect()->route('admin.bus')->with('msg','Bus Deleted.');
  }

}