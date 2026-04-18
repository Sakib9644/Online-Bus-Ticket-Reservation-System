<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $cities = City::latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($cities)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $btn = '<div style="display:flex; gap:8px;">
                                <a href="'.route('admin.city.edit', $row->id).'" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#8b5cf6;"><i class="fas fa-edit"></i></a>
                                <a onclick="return confirm(\'Delete this city/hub?\')" href="'.route('admin.city.delete', $row->id).'" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.City.list');
    }
     
    public function create()
    {
        return view('admin.pages.City.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
        ]);
   
        City::create ([
            'name'=>$request->name,
        ]);
        return redirect()->route('admin.city')->with('message','City created successfully!');
    }

    public function cityEdit($id)
    {
        $city = City::find($id);
        if ($city) {
            return view('admin.pages.City.edit',compact('city'));
        }
    }

    public function cityUpdate(Request $request,$id){
        $city = city::find($id);
        if ($city) {
            $city->update([
                'name'=>$request->name,
            ]);
            return redirect()->route('admin.city')->with('success','City Updated!');
        }
    }

    public function cityDelete($city_id)
    {
        City::find($city_id)->delete();
        return redirect()->route('admin.city')->with('msg','City Deleted.');
    }
}