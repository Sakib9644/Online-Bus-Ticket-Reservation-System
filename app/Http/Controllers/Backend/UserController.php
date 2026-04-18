<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', '!=', 'admin')->latest()->get();
            return \Yajra\DataTables\Facades\DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('actions', function($row){
                    $btn = '<div style="display:flex; gap:8px;">
                                <a onclick="return confirm(\'Permanently remove this passenger account?\')" href="'.route('passenger.delete', $row->id).'" class="btn-danger-admin" style="padding:8px 12px; font-size:12px;"><i class="fas fa-trash-alt"></i></a>
                            </div>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
        return view('admin.pages.User.user-list');
    }
    public function delete($id)
  {
    User::find($id)->delete();
    return redirect()->route('passenger')->with('msg','Deleted.');
  }
}