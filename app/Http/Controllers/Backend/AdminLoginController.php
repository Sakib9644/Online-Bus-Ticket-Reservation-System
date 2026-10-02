<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function login()
    {
        // If already logged in as admin, redirect directly to dashboard
        if (Auth::check() && Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.adminlogin');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Check if user is an administrator
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('message', 'Welcome back, Administrator!');
            }

            // If a non-admin attempts login on the admin portal
            Auth::logout();
            return redirect()->route('admin.login')->withErrors([
                'email' => 'Access Denied: Your account does not have administrative privileges.'
            ]);
        }

        return redirect()->back()->withInput($request->only('email'))->withErrors([
            'email' => 'Invalid administrator credentials. Access declined.'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('message', 'Administrator session ended successfully.');
    }
}