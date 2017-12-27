<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use Illuminate\Support\Facades\DB;
use App\Plan;
use App\Investiment;

class ReinvestmentController extends Controller
{
    public function showReinvestmentForm(Request $request)
    {
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            
            $user = $request->session()->get('loggeduser');
            
            $matchThese = ['userid' => $user->id];
                         $balances=Balance::where($matchThese)->get();
             $balance=0;
             
             if(!$balances->isEmpty())
             {
                $balance=$balances->first()->value;
             } 
             
             $plans = Plan::query()->get();
            
            return view('pages.reinvestment',
                [ 'balance' => $balance, 
                    'plans' => $plans
                ]);
        }
    }
    
    public function createReinvestmentRequest(Request $request)
    {
        
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            $investimentValue = $request->input('investimentValue');
            
            $planid = $request->input('plan');
            
            if($planid==null)
            {
                $planid = 1;
            }            
            
            $user = $request->session()->get('loggeduser');
            
            DB::beginTransaction();
            
            try {
                
                $newRequest = new \App\Request();
                $newRequest->date= date('Y\-m\-d\ h:i:s');
                $newRequest->requesttypeid=2;
                $newRequest->requeststatusid=1;
                $newRequest->approved=false;
                
                $newRequest->save();
                
                $investiment = new Investiment();
                
                $investiment->requestid=$newRequest->id;
                $investiment->userid=$user->id;
                $investiment->value = $investimentValue;
                $investiment->planid = $planid;
                $investiment->enabled = false;
                
                $investiment->save();
            }
            catch(\Exception $e)
            {
                DB::rollback();
            }
            
            DB::commit();
            
            return redirect()->action('InvestimentController@showInvestimentForm');
        }
        
    }
}
