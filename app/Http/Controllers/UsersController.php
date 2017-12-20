<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

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
        $firstName = $request->input('firsName');
        $lastName = $request->input('lastName');
        $document = $request->input('document');
        $password = md5($request->input('password'));
        
        $matchThese = ['email' => $email];
        
        $user=User::where($matchThese)->get();
                
        if($user)
        {
            return view('pages.signin', ['message' => 'E-mail already registered']);
        }
        $newUser = new User;
        $newUser->email = $email;
        $newUser->firstName = $firstName;
        $newUser->lastName = $lastName;
        $newUser->document = $document;
        $newUser->password = $password;
                
        $newUser->save();
    }
}
