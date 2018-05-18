<?php

namespace App\Http\Controllers;

use App\BankData;
use App\Investiment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Logging\Log;

class BankDataController extends Controller
{
    public function showBankDataForm(Request $request)
    {
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            
            $user = $request->session()->get('loggeduser');
            
            $matchThese = ['userid' => $user->id];
            $bankdatalist=BankData::where($matchThese)->get();
            $bankdata=null;
            if(!$bankdatalist->isEmpty())
            {
                $bankdata=$bankdatalist->first();
            }
       
            return view('pages.bankdata',
                [ 'bankdata' => $bankdata,
                  'userdata' => $user
                ]);
        }
    }
    
    public function updateBankData(Request $request)
    {
        
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.signin');
        } else
        {
            $fullname = $request->input('fullname');
            $document = $request->input('document');
            $bankid = $request->input('bankcode');
            $agency = $request->input('agency');
            $account = $request->input('account');
            $type = $request->input('type');
                                  
            $user = $request->session()->get('loggeduser');
            
            DB::beginTransaction();
            
            try {
                
                $matchThese = ['userid' => $user->id];
                
                $bankdatalist=BankData::where($matchThese)->get();
                
                $bankdata=null;
                
                if(!$bankdatalist->isEmpty())
                {
                    $bankdata=$bankdatalist->first();
                }
                else
                {
                    $bankdata = new BankData();
                }
                
                $bankdata->fullname=$fullname;
                $bankdata->document=$document;
                $bankdata->bankid=$bankid;
                $bankdata->agency=$agency;
                $bankdata->userid=$user->id;
                $bankdata->account=$account;
                $bankdata->type=$type;
                $bankdata->enabled=true;
                
                $bankdata->save();
                
            }
            catch(\Exception $e)
            {
                DB::rollback();
                \Illuminate\Support\Facades\Log::error($e->getMessage());
                \Illuminate\Support\Facades\Log::error($e->getSql());
            }
            
            DB::commit();
            
            return redirect()->action('BankDataController@showBankDataForm');
        }
        
    }
}
