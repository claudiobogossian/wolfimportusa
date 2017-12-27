<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investiment;
use Illuminate\Support\Facades\DB;

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
/*             $balances=Balance::where($matchThese)->get();
            $balance=0;
            
            if(!$balances->isEmpty())
            {
                $balance=$balances->first()->value;
            } */
            
            $matchThese2 = ['userid' => $user->id];
            
            $investiments = DB::table('investiment')
            ->join('requests', 'investiment.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->join('plan', 'plan.id', '=', 'investiment.planid')
            ->select('requests.id','investiment.value', 'requeststatus.name', 'requests.date', 'plan.name as planname')
            ->get();
            
            return view('pages.investiment',
                [/* 'balance' => $balance, */
                    'investiments' => $investiments
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
            
            $planid = $request->input('planid');
            
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
