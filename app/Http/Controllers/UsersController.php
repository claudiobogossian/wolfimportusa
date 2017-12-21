<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function showRegisterForm(Request $request)
    {
        if (! $request->session()->has('users')) {
            return view('pages.register');
        } else {
            return view('index');
        }
        
    }
    public function register(Request $request)
    {
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $birthdate = $request->input('birthdate');
        $document = $request->input('document');
        $password = md5($request->input('password'));
        
        $matchThese = ['email' => $email];
        
        $user=User::where($matchThese)->get();
                
        $newUser = new User;
        $newUser->email = $email;
        $newUser->firstname = $firstName;
        $newUser->lastname = $lastName;
        $newUser->document = $document;
        $newUser->password = $password;
        
        $date = Carbon::createFromFormat('d/m/Y',$birthdate);
        
        $newUser->birthdate = $date;
        
        $newUser->registrydate = date('Y\-m\-d\ h:i:s');
        
        if(!$user->isEmpty())
        {
            $newUser->birthdate = $birthdate;
            return view('pages.register', 
                ['message' => 'E-mail already registered',
                'userdata' => $newUser]
              );
        }
        
        return view('index');


        
        $newUser->save();
    }
}
