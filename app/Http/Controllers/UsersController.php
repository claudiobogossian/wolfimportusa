<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Carbon\Carbon;
use App\UserAnalysis;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    public function showRegisterForm(Request $request)
    {
        if (! $request->session()->has('loggeduser')) {
            return view('pages.register');
        } else {
            $user = $request->session()->get('loggeduser');
            
            return view('pages.register', ['update' => true,
                'userdata' => $user
            ]);
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
        $newUser->isadmin = false;
        
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
        
        
        DB::beginTransaction();
        
        
        try {
            $newUser->save();
            
            $newRequest = new \App\Request();
            $newRequest->date= date('Y\-m\-d\ h:i:s');
            $newRequest->requesttypeid=1;
            $newRequest->requeststatusid=1;
            $newRequest->approved=false;
            
            $newRequest->save();
            
            $userAnalysis = new UserAnalysis();
            
            $userAnalysis->userid=$newUser->id;
            $userAnalysis->enabled=false;
            $userAnalysis->investimentpercent = 0;
            $userAnalysis->requestid=$newRequest->id;
            
            $userAnalysis->save();
        }
        catch(\Exception $e)
        {
            DB::rollback();
        }
        

        DB::commit();
        
      
        
        return redirect()->action('MainController@index');
    }
    
    public function update(Request $request)
    {
        $email = $request->input('email');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $birthdate = $request->input('birthdate');
        $document = $request->input('document');
        $password = md5($request->input('password'));
        
        $user = $request->session()->get('loggeduser');
        
        $user->email = $email;
        $user->firstname = $firstName;
        $user->lastname = $lastName;
        $user->document = $document;
        $user->password = $password;
        $user->isadmin = false;
        
        $date = Carbon::createFromFormat('d/m/Y',$birthdate);
        
        $user->birthdate = $date;
        
        $user->registrydate = date('Y\-m\-d\ h:i:s');
        
        DB::beginTransaction();
       
        try {
            $user->save();
        }
        catch(\Exception $e)
        {
            DB::rollback();
        }
        
        
        DB::commit();
    
        return view('pages.register',['update' => true,
            'userdata' => $user
        ]);
    }
}
