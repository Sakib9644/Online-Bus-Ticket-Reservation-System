<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function list(){
      $counters=Counter::all();
      //   dd($counters);
     return view('admin.pages.Counter.counter-list',compact('counters'));
  }
  
  public function create(){
     return view('admin.pages.Counter.counter-create');
  }

  public function store(Request $request){
   $request->validate([
      'counter_name'=>'required',
      'counter_no'=>'required|numeric',
      'counter_phone'=>'required|numeric|digits:11',
   ]);

Counter::create ([
            // field name for DB || field name for form
            'counter_name'=>$request->counter_name,
            'counter_no'=>$request->counter_no,
            'counter_phone'=>$request->counter_phone,
]);
return redirect()->back()->with('msg','Counter created successfully!');
}
public function counterDetails($counter_id){
   $counter=Counter::find($counter_id);
   return view ('admin.pages.Counter.counter-details',compact('counter'));
 }

public function counterDelete($counter_id){

Counter::find($counter_id)->delete();

return redirect()->back()->with('success','counter Deleted.');
}
}