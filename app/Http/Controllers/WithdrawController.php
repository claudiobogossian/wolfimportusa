<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Withdraw;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WithdrawController extends Controller
{
    public function showWithdrawForm(Request $request)
    {
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            
            $user = $request->session()->get('loggeduser');
            
            //$matchThese = ['userid' => $user->id];
            //$balances=Balance::where($matchThese)->get();
            
            $accumulatedIncome = Balance::calculateCurrentBalance($user);
            
            $matchThese2 = ['userid' => $user->id];
            
            $withdraws = DB::table('withdraw')
            ->join('requests', 'withdraw.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->select('withdraw.id','withdraw.value', 'requeststatus.name', 'withdraw.date')
            ->where('withdraw.userid','=',$user->id)
            ->get();
            
            return view('pages.withdraw', 
                ['balance' => $accumulatedIncome,
                    'withdraws' => $withdraws
                ]);
        }
    }
    
    public function createWithdrawRequest(Request $request)
    {
        
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            $withdrawValue = $request->input('withdrawValue');
            
            $user = $request->session()->get('loggeduser');
            
            DB::beginTransaction();
            
            try {
                
                $accumulatedIncome = Balance::calculateCurrentBalance($user);
                
                if(intval($withdrawValue)
                    > intval($accumulatedIncome))
                {
                    #invalid value, bigger then balance
                    return redirect()->action('WithdrawController@showWithdrawForm');
                }
                               
                $newRequest = new \App\Request();
                $newRequest->date= date('Y\-m\-d\ h:i:s');
                $newRequest->requesttypeid=3;
                $newRequest->requeststatusid=1;
                $newRequest->approved=false;
                
                $newRequest->save();
                
                $withdraw = new Withdraw();

                $withdraw->date= date('Y\-m\-d\ h:i:s');
                $withdraw->requestid=$newRequest->id;
                $withdraw->userid=$user->id;
                $withdraw->value = $withdrawValue;
                $withdraw->investimentid=0;
                
                $withdraw->save();
                
                $newBalance = new Balance();
                $newBalance->userid = $user->id;
                $newBalance->date = date('Y\-m\-d\ h:i:s');
                $newBalance->value = -$withdrawValue;
                $newBalance->requestid = null;
                $newBalance->investimentid = null;
                
                $newBalance->save();
                
            }
            catch(\Exception $e)
            {
                DB::rollback();
            }
            
            WithdrawController::sendEmailNotifications($user->email,$user->firstName." ".$user->lastName);
            
            DB::commit();
            
            return redirect()->action('WithdrawController@showWithdrawForm');
        }
        
    }
    
    private function sendEmailNotifications($email, $fullname)
    {
        
        Mail::send('email.withdrawrequested_admin', ['email' => $email, 'fullname' => $fullname], function ($message)
        {
            $message->from('wolfimportsusa@wolfimportsusa.com', 'Wolf Imports USA');
            $message->to('wolfimportsusa@wolfimportsusa.com');
            $message->subject('Wolf Imports USA - Nova solicitação de saque.');
        });
   
    }  
}
