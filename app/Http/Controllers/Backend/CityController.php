<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function list()
    {
        $cities = City::latest()->get();
        return view('admin.pages.City.list',compact('cities'));
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