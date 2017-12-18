<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        if (! $request->session()->has('users')) {
            
            $login = $request->input('username');
            $password = $request->input('password');
            
            
            
        } else {
            return view('index');
        }
    }
}
