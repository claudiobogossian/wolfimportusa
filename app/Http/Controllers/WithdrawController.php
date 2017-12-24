<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Balance;
use App\Withdraw;
use Illuminate\Support\Facades\DB;

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
            
            $matchThese = ['userid' => $user->id];
            $balances=Balance::where($matchThese)->get();
            $balance=0;
            
            if(!$balances->isEmpty())
            {
                $balance=$balances->first()->value;
            }
            
            $matchThese2 = ['userid' => $user->id];
            
            $withdraws = DB::table('withdraw')
            ->join('requests', 'withdraw.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->select('withdraw.id','withdraw.value', 'requeststatus.name', 'withdraw.date')
            ->get();
            
            return view('pages.withdraw', 
                ['balance' => $balance,
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
                
                
                $withdraw->save();
            }
            catch(\Exception $e)
            {
                DB::rollback();
            }
            
            
            DB::commit();
            
            return redirect()->action('WithdrawController@showWithdrawForm');
        }
        
    }
}
