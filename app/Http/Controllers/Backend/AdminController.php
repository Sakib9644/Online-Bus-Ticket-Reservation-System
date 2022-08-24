<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bus;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard(){

        $count['booking']=Booking::all()->count();
        $count['bus']=Bus::all()->count();
        $count['user']=User::all()->count();

        return view('admin.pages.Dashboard.admin-dashboard',compact('count'));
    }
}