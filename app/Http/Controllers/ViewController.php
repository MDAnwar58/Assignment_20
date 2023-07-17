<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    function home()
    {
        return view('pages.home.index');
    }
    function loginPage()
    {
        return view('auth.login');
    }
    function registerPage()
    {
        return view('auth.register');
    }
    function forgetPage()
    {
        return view('auth.forget-password');
    }
    function verifyOTPPage()
    {
        return view('auth.otp-verify');
    }
    function resetPassword()
    {
        return view('auth.reset-password');
    }
}
