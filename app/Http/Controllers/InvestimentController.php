<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Investiment;
use Illuminate\Support\Facades\DB;
use App\UserAnalysis;
use App\Balance;
use App\Plan;
use App\Properties;
use Illuminate\Support\Facades\Mail;

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
            
            $accumulatedIncome = Balance::calculateCurrentBalance($user);
            
            $userAnalysis=UserAnalysis::where($matchThese)->get();
                   
            $withdraws = DB::table('withdraw')
            ->join('requests', 'withdraw.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->select('withdraw.id','withdraw.value', 'requeststatus.name', 'withdraw.date')
            ->where('withdraw.userid','=',$user->id)
            ->get();
            
            $matchThese2 = ['userid' => $user->id];
            
            $investiments = DB::table('investiment')
            ->join('requests', 'investiment.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->select('requests.id','investiment.value', 'requeststatus.name', 'requests.date', 'investiment.durationindays', 'investiment.duedate', 'investiment.done')
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
            
            
            $currentcurrency=$request->session()->get('currentcurrency');
            
            if($currentcurrency->id==1)
            {
                $matchThese = ['name' => 'currency.reais.min.value'];
                
            } else if($currentcurrency->id==2)
            {
                $matchThese = ['name' => 'currency.dollar.min.value'];
                
            }
            else
            {
                $matchThese = [];
            }

            $minValueProperty = Properties::where($matchThese)->get()->first();
            
            
            $minValue =0;
            
            if($minValueProperty)
            {
                $minValue = $minValueProperty->value;
            }
             
            return view('pages.investiment',
                [ 'balance' => $accumulatedIncome, 
                  'investiments' => $investiments,
                  'plans' => $plans,
                  'hasDone90' =>  $hasDone90,
                  'hasDone180' =>   $hasDone180,
                    'userAnalysis' => $userAnalysis->first(),
                    'minValue' => $minValue
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
                
                $accumulatedIncome = Balance::calculateCurrentBalance($user);
                
                if(intval($investimentValue)
                    > intval($accumulatedIncome))
                {
                    #invalid value, bigger then balance
                    return redirect()->action('InvestimentController@showInvestimentForm');
                }
                
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
                
                $newBalance = new Balance();
                $newBalance->userid = $user->id;
                $newBalance->date = date('Y\-m\-d\ h:i:s');
                $newBalance->value = -$investimentValue;
                $newBalance->requestid = null;
                $newBalance->investimentid = null;
                
                $newBalance->save();
                
            }
            catch(\Exception $e)
            {
                DB::rollback();
            }
            
            InvestimentController::sendEmailNotifications($user->email,$user->firstName." ".$user->lastName);
            
            DB::commit();
            
            return redirect()->action('InvestimentController@showInvestimentForm');
        }
        
    }
    private function sendEmailNotifications($email, $fullname)
    {
        
        Mail::send('email.investmentrequested_admin', ['email' => $email, 'fullname' => $fullname], function ($message)
        {
            $message->from('wolfimportsusa@wolfimportsusa.com', 'Wolf Imports USA');
            $message->to('wolfimportsusa@wolfimportsusa.com');
            $message->subject('Wolf Imports USA - Nova solicitação de investimento.');
        });
        
    }   
}
