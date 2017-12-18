<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
	public function index()
	{
	   if (!$request->session()->has('users')) {
		return view('sigin');    
	   }
		else
		{
			return view('index');    
		}

	}
}
