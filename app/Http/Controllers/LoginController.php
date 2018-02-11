<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAnalysis;
use Illuminate\Support\Facades\Session;
use App\Currency;

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
                 if(!$user->isadmin)
                 {
                     $matchThese = ['userid' => $user->id];
                     
                     $userAnalysis = UserAnalysis::where($matchThese)->first();
                     
                     if(!$userAnalysis->enabled)
                     {
                         return view('pages.signin',['message' => 'User not evaluated yet.']);
                     }
                 }
                 
                 $request->session()->put('loggeduser', $user);
                 
                 $matchThese = ['id' => $user->currencyid];
                 
                 $currentCurrency = Currency::where($matchThese)->first();
                 
                 if($currentCurrency)
                 {
                     $request->session()->put('currentcurrency', $currentCurrency);
                 }                                     
                 
                 return redirect()->action('MainController@index');
                 
             }
             else
             {
                 return view('pages.signin',['message' => 'Invalid e-mail or password']);
             }
        } else {
            return redirect()->action('MainController@index');
        }
    }
    
    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->action('MainController@index');
    }
}
