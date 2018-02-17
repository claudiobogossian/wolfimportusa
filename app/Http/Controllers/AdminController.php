<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserAnalysis;
use App\Investiment;

class AdminController extends Controller
{
    public function manageRequests(Request $request)
    {
        if (! $request->session()->has('loggeduser')) 
        {
            return view('pages.register');
        } else {
            $user = $request->session()->get('loggeduser');
            
            if(!$user->isadmin)
            {
                return redirect()->action('MainController@index');
            }
            
            $withdrawsrequest = DB::table('withdraw')->join('requests', 'withdraw.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
            ->join('users', 'withdraw.userid', '=', 'users.id')
            ->join('currency', 'users.currencyid', '=', 'currency.id')
            ->select('requests.id', 'users.email', 'withdraw.value', 'requeststatus.name as requeststatusname', 'requeststatus.id as requeststatusid',  'requesttype.name as requesttypename','requesttype.id as requesttypeid', 'requests.date', 'requests.reviewdate', 'currency.prefix as currencyprefix')
            ->orderBy('requests.date')
            ->get();
            
            $investimentsrequest = DB::table('investiment')->join('requests', 'investiment.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
            ->join('users', 'investiment.userid', '=', 'users.id')
            ->join('currency', 'users.currencyid', '=', 'currency.id')
            ->select('requests.id', 'users.email','investiment.value', 'requeststatus.name as requeststatusname', 'requeststatus.id as requeststatusid', 'requesttype.name as requesttypename',  'requesttype.id as requesttypeid','requests.date', 'requests.reviewdate', 'currency.prefix as currencyprefix')
            ->orderBy('requests.date')
            ->get();
            
            $usersrequest = DB::table('useranalysis')->join('requests', 'useranalysis.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->join('users', 'useranalysis.userid', '=', 'users.id')
            ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
            ->select('requests.id', 'users.email', 'requeststatus.name as requeststatusname', 'requeststatus.id as requeststatusid',  'requesttype.name as requesttypename','requesttype.id as requesttypeid','requests.date', 'useranalysis.investimentpercent', 'requests.reviewdate')
            ->orderBy('requests.date')
            ->get();
            
            $requeststatus = DB::table('requeststatus')->get();
            
            return view('pages.manage-requests', [
                'usersrequest' => $usersrequest,
                'investimentsrequest' => $investimentsrequest,
                'withdrawsrequest' => $withdrawsrequest,
                'requeststatus' => $requeststatus
            ]);
        }
        
    }
    
    public function updateRequest(Request $request)
    {
        if (! $request->session()->has('loggeduser'))
        {
            return view('pages.register');
        } else {
            $user = $request->session()->get('loggeduser');
            
            if(!$user->isadmin)
            {
                return redirect()->action('MainController@index');
            }
            
            $requestid = $request->input('requestid');
            $requesttypeid = $request->input('requesttypeid');
            $requeststatusid = $request->input('requeststatusid');
          
            
            DB::beginTransaction();
            
            
            try {
               
                               
                if($requesttypeid==1)
                {
                    $investmentpercent = $request->input('investmentpercent');
                    
                    $matchThese = ['requestid' => $requestid];
                    
                    $userAnalysis = UserAnalysis::where($matchThese)->first();
                    
                    $userAnalysis->investimentpercent = $investmentpercent;
                    
                    if($requeststatusid==2)
                    {
                        $userAnalysis->enabled = true;
                    }
                    else
                    {
                        $userAnalysis->enabled = false;
                    }
                    
                    $userAnalysis->save();
                }
                
                
                
                $matchThese = ['id' => $requestid];
                
                $request = \App\Request::where($matchThese)->first();
                
                $request->requeststatusid=$requeststatusid;
               
                
                if($requeststatusid==2)
                {
                    $request->approved=true;
                    
                    
                    if($requesttypeid==2)
                    {
                        //Update investment due date
                        $matchThese = ['requestid' => $requestid];
                        $investment=Investiment::where($matchThese)->get();
                        
                        if($investment)
                        {
                            $currentDate = date('Y\-m\-d');
                            $durationindays = ($investment->first()->durationindays-1);
                            $dueDate=date('Y-m-d', strtotime($currentDate. ' + '.$durationindays.' days'));
                            Investiment::where($matchThese)->update(['duedate' => $dueDate]);
                        }
                        
                    }
                }
                else
                {
                    $request->approved=false;
                }
                
                $request->reviewdate=date('Y\-m\-d\ h:i:s');
                
                $request->save();
                              
            }
            catch(\Exception $e)
            {
                DB::rollback();
            }
            
            
            DB::commit();
                   
            return redirect()->action('AdminController@manageRequests');
        }
    }
}
