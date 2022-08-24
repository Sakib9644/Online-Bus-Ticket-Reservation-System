<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function list(){
        $users = User::all();
        return view('admin.pages.User.user-list',compact('users'));
    }
    public function delete($id)
  {
    User::find($id)->delete();
    return redirect()->route('passenger')->with('msg','Deleted.');
  }
}