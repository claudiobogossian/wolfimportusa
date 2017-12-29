<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investiment;

class MainController extends Controller
{

    public function index(Request $request)
    {
        if (! $request->session()->has('loggeduser')) {
            return view('pages.signin');
        } else {
            
            return view('index');
        }
    }
    
    
}
