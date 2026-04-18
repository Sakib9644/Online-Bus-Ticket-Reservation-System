<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Counter;
use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $counters = Counter::latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($counters)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $btn = '<div style="display:flex; gap:8px;">
                                <a href="'.route('admin.counter.details', $row->id).'" class="btn-outline-admin" style="padding:8px 12px; font-size:12px; color:#3b82f6;"><i class="fas fa-eye"></i></a>
                                <a onclick="return confirm(\'Delete this counter?\')" href="'.route('admin.counter.delete', $row->id).'" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.Counter.counter-list');
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