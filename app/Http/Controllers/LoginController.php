<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        if (! $request->session()->has('users')) {
            
            $login = $request->input('username');
            $password = md5($request->input('password'));
            
            $matchThese = ['email' => $login, 'password' => $password];
            
            $user=User::where($matchThese)->get();

             if($user)
             {
                 
                 $request->session()->put('user', $user);
                 
                 return view('index');
                 
             }
             else
             {
                 return view('pages.signin',['message' => 'Invalid e-mail or password']);
             }
        } else {
            return view('index');
        }
    }
}
