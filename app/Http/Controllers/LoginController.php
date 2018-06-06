<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\UserAnalysis;
use Illuminate\Support\Facades\Session;
use App\Currency;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

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
    
    public function showForgetPassword(Request $request)
    {
        if (! $request->session()->has('loggeduser')) {
            return view('pages.remember-password');
                        
        } else {
            return redirect()->action('MainController@index');
        }
    }
    
    public function forgetPassword(Request $request)
    {
        if (!$request->session()->has('loggeduser')) {
            
            $email = $request->input('email');
         
            $matchThese = ['email' => $email];
            
            $users=User::where($matchThese)->get();
           
            if($users->isEmpty())
            {
               
                return view('pages.remember-password',
                    ['message' => 'E-mail does not exists!',
                        'email' => $email]
                    );
            }
            else
            {
                $user=$users->first();
                
                $newpasswod = LoginController::getRandomPassword();
                
                $newpasswodMD5 = md5($newpasswod);
                
                $user->password = $newpasswodMD5;
                
                DB::beginTransaction();
                
                try {
                    $user->save();
                }
                catch(\Exception $e)
                {
                    DB::rollback();
                }
                                
                DB::commit();
                
                
                LoginController::sendEmailNotifications($user, $newpasswod);
                
                return view('pages.signin',['message' => 'New password sent to: '.$email]);
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
    
    private function sendEmailNotifications($user, $newpassword)
    {
        
        Mail::send('email.newpassword', ['user' => $user, 'newpassword'=> $newpassword], function ($message) use ($user)
        {
            $message->from('wolfimportsusa@wolfimportsusa.com', 'Wolf Imports USA');
            $message->to($user->email);
            $message->subject('Wolf Imports USA - Nova senha de acesso.');
        });
        
    }   
    
    private function getRandomPassword() {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }
}
