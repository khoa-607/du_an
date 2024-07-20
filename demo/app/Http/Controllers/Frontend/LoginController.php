<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('account.form');
        }
        
        return view('frontend.login.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me') ? true : false;
        
        if (Auth::attempt($credentials, $remember)) {
            if (Auth::user()->level == 0) {
                return redirect()->route('account.form')->with('success', 'Login successful!');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors('You are not authorized to access this page.');
            }
        } else {
            return redirect()->back()->withErrors('Email or password is incorrect.');
        }
    }
}
