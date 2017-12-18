<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{

    public function index(Request $request)
    {
        if (! $request->session()->has('users')) {
            return view('pages.signin');
        } else {
            return view('index');
        }
    }
    
    
}
