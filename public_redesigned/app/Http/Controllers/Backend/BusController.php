<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bus;
use App\Models\User;
use Illuminate\Http\Request;

class BusController extends Controller
{
  public function list()
  {
    $buses=Bus::latest()->paginate(5);
    return view('admin.pages.Bus.bus-list',compact('buses'));
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
        'bus_no'=>'required|numeric',
        'bus_type'=>'required',
      ]);

      // dd('ok');
      // dd($request->all());

      Bus::create ([
          'bus_name'=>$request->bus_name,
          'bus_no'=>$request->bus_no,
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
                'bus_no'=>$request->bus_no,
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