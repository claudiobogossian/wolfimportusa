<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAnalysis;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function authenticate(Request $request)
    {
        if (! $request->session()->has('loggeduser')) {
            
            $login = $request->input('username');
            $password = md5($request->input('password'));
            
            $matchThese = ['email' => $login, 'password' => $password];
            
            $user=User::where($matchThese)->first();

            if($user)
             {
                 
                 $matchThese = ['userid' => $user->id];
                 
                 $userAnalysis = UserAnalysis::where($matchThese)->first();
                 
                 if(!$userAnalysis->enabled)
                 {
                     return view('pages.signin',['message' => 'User not evaluated yet.']);
                 }
                 
                 $request->session()->put('loggeduser', $user);
                 
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
    
    public function logout(Request $request)
    {
        $request->session()->flush();
    }
}