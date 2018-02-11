<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investiment;
use Illuminate\Support\Facades\DB;
use App\UserAnalysis;
use App\Balance;
use App\Plan;

class InvestimentController extends Controller
{
    public function showInvestimentForm(Request $request)
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
            
            $matchThese2 = ['userid' => $user->id];
            
            $investiments = DB::table('investiment')
            ->join('requests', 'investiment.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->select('requests.id','investiment.value', 'requeststatus.name', 'requests.date', 'investiment.durationindays')
            ->where('investiment.userid',$user->id)
            ->get();
            
            $plans = Plan::query()->get();
            
            $doneInvestiments90days = DB::table('investiment')
            ->where('investiment.durationindays',90)
            ->where('investiment.userid',$user->id)
            ->where('investiment.done',true)->get();
            
            $hasDone90 = !$doneInvestiments90days->isEmpty();
            
            $doneInvestiments180days = DB::table('investiment')
            ->where('investiment.durationindays',180)
            ->where('investiment.userid',$user->id)
            ->where('investiment.done',true)->get();
            
            $hasDone180 = !$doneInvestiments180days->isEmpty();
            
            return view('pages.investiment',
                [ 'balance' => $balance, 
                  'investiments' => $investiments,
                  'plans' => $plans,
                  'hasDone90' =>  $hasDone90,
                  'hasDone180' =>   $hasDone180
                ]);
        }
    }
    
    public function createInvestimentRequest(Request $request)
    {
        
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            $investimentValue = $request->input('investimentValue');
            
            $durationindays = $request->input('durationindays');
            
            if($durationindays==null)
            {
                 $durationindays=90;
            }
                
            $user = $request->session()->get('loggeduser');
            
            $matchThese = ['userid' => $user->id];
            
            $userAnalysis = UserAnalysis::where($matchThese)->first();
            
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
                $investiment->enabled = false;
                $investiment->done = false;
                $investiment->investimentpercent=$userAnalysis->investimentpercent;
                $investiment->durationindays=$durationindays;
                
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
