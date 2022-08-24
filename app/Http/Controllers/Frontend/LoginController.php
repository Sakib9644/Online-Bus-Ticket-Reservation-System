<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function registration(){
        return view('frontend.pages.registration');
    }

    public function registrationPost(Request $request){
        // dd($request->all());
        User::create([
            'name'=>$request->name,
            'phone'=>$request->phone_no,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        return redirect()->route('user.login');
    }

    public function login(){
        return view('frontend.pages.login');
    }

    public function doLogin(Request $request){

        // dd($request->all());
        $userpost=$request->except('_token');

        // dd($userpost);
        if(Auth::attempt($userpost))
        {
            return redirect()->route('frontend.home');
        }

        else
        return redirect()->route('user.login');

    }

    public function logout(){
        Auth::logout();
        return redirect()->route('frontend.home');

    }
    
    public function email () {

        
        return view('user.email');  
    }



}
