<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function registration()
    {
        if (Auth::check()) {
            return redirect()->route('frontend.home');
        }
        return view('frontend.pages.registration');
    }

    public function registrationPost(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_no' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:4',
        ]);

        User::create([
            'name' => $request->name,
            'phone' => $request->phone_no,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'user',
        ]);

        return redirect()->route('user.login')->with('message', 'Registration successful! Please sign in.');
    }

    public function login()
    {
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('frontend.home');
        }

        return view('frontend.pages.login');
    }

    public function doLogin(Request $request)
    {
        $userpost = $request->only('email', 'password');

        if (Auth::attempt($userpost)) {
            // If logging in user is an administrator, redirect straight to admin dashboard
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Welcome back, Administrator!');
            }

            return redirect()->route('frontend.home')->with('message', 'Signed in successfully!');
        }

        return redirect()->route('user.login')->withErrors('Invalid email address or password.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('frontend.home');
    }
    
    public function email()
    {
        return view('user.email');  
    }
}
