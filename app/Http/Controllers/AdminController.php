<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\UserAnalysis;
use App\Investiment;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\BankData;
use App\Balance;

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
            ->select('requests.id', 'users.email','investiment.value', 'requeststatus.name as requeststatusname', 'requeststatus.id as requeststatusid', 'requesttype.name as requesttypename',  'requesttype.id as requesttypeid','requests.date', 'requests.reviewdate', 'currency.prefix as currencyprefix', 'investiment.duedate', 'investiment.done', 'investiment.investimentpercent')
            ->orderBy('requests.date', 'desc')
            ->get();
            
            $usersrequest = DB::table('useranalysis')->join('requests', 'useranalysis.requestid', '=', 'requests.id')
            ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
            ->join('users', 'useranalysis.userid', '=', 'users.id')
            ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
            ->select('requests.id', 'users.email', 'requeststatus.name as requeststatusname', 'requeststatus.id as requeststatusid',  'requesttype.name as requesttypename','requesttype.id as requesttypeid','requests.date', 'useranalysis.investimentpercent', 'requests.reviewdate', 'users.id as userid')
            ->orderBy('requests.date')
            ->get();
            
            $bankDataList = DB::table('bankdata')->join('users', 'bankdata.userid','=', 'users.id')
            ->select('users.email as email', 'bankdata.fullname as fullname', 'bankdata.bankid as bankid','bankdata.document as document','bankdata.agency as agency','bankdata.account as account','bankdata.type as type')
            ->orderBy('users.email')
            ->get();
            
            $usersBalances = DB::table('balance')
            ->join('investiment','balance.investimentid','=','investiment.id')
            ->join('users','users.id','=','balance.userid')
            ->join('currency', 'users.currencyid', '=', 'currency.id')
            ->select('users.email as email','users.id as userid','currency.prefix as currencyprefix', DB::raw('SUM(balance.value) as value'))
            ->where('investiment.done','=', true)
            ->groupBy('users.email', 'userid', 'currency.prefix')
            ->get();
            
            $requeststatus = DB::table('requeststatus')->get();
            
            return view('pages.manage-requests', [
                'usersrequest' => $usersrequest,
                'investimentsrequest' => $investimentsrequest,
                'withdrawsrequest' => $withdrawsrequest,
                'requeststatus' => $requeststatus,
                'bankDataList' => $bankDataList,
                'usersBalances' => $usersBalances
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
                              
                $requestUser = null;
                if($requesttypeid==1)
                {
                    $users = DB::table('users')->join('useranalysis', 'useranalysis.userid', '=', 'users.id')
                    ->where('useranalysis.requestid', '=', $requestid)
                    ->select('users.id', 'users.email', 'users.firstName', 'users.lastName')
                    ->get();
                    
                    $requestUser = $users->first();
                    
                } else if($requesttypeid==3)
                {
                    $users = DB::table('users')->join('withdraw', 'withdraw.userid', '=', 'users.id')
                    ->where('withdraw.requestid', '=', $requestid)
                    ->select('users.id', 'users.email', 'users.firstName', 'users.lastName')
                    ->get();
                    
                    $requestUser = $users->first();
                } else if($requesttypeid==2)
                {
                    $users = DB::table('users')->join('investiment', 'investiment.userid', '=', 'users.id')
                    ->where('investiment.requestid', '=', $requestid)
                    ->select('users.id', 'users.email', 'users.firstName', 'users.lastName')
                    ->get();
                    
                    $requestUser = $users->first();
                }
                
                AdminController::sendEmailNotifications($requestUser->email,$requestUser->firstName." ".$requestUser->lastName, $requeststatusid, $requesttypeid);
                
            
            }
            catch(\Exception $e)
            {
                DB::rollback();
            }
           
            
            
            
            DB::commit();
                   
            return redirect()->action('AdminController@manageRequests');
        }
    }
    
    
    public function deleteUser(Request $request)
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
            
            $userid = $request->input('userid');
            
            $matchThese = ['id' => $userid];
            
            $user=User::where($matchThese)->get();
            
            if(!$user->isEmpty())
            {
                try
                {
                    DB::table('bankdata')->where('userid', '=', $userid)->delete();
                    DB::table('balance')->where('userid', '=', $userid)->delete();
                    DB::table('withdraw')->where('userid', '=', $userid)->delete();
                    DB::table('useranalysis')->where('userid', '=', $userid)->delete();
                    DB::table('investiment')->where('userid', '=', $userid)->delete();
                    DB::table('users')->where('id', '=', $userid)->delete();
                    
                }
                catch(\Exception $e)
                {
                    DB::rollback();
                }
                DB::commit();
            }

            
            return redirect()->action('AdminController@manageRequests');
        }
    }
    
    public function addFunds(Request $request)
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
            
            $userid = $request->input('userid');
            
            $matchThese = ['id' => $userid];

            $fundsValue = $request->input('fundsValue');
            
            if($fundsValue)
            {
                try
                {
                    
                    $investiments = DB::table('investiment')
                    ->select('investiment.id', 'investiment.requestid')
                    ->where('investiment.userid',$user->id)
                    ->where('investiment.done',true)
                    ->orderBy('investiment.date', 'desc')
                    ->get();
                    
                    if(!$investiments->isEmpty())
                    {

                        
                        $newBalance = new Balance();
                        $newBalance->userid = $userid;
                        $newBalance->date = date('Y\-m\-d\ h:i:s');
                        $newBalance->value = -$investimentValue;
                        $newBalance->requestid = $investiments->first().requestid;
                        $newBalance->investimentid = $investiments->first().id;
                        
                        $newBalance->save();
                        
                        
                    }
                    
                    
                }
                catch(\Exception $e)
                {
                    DB::rollback();
                }
                DB::commit();
            }
            
            
            return redirect()->action('AdminController@manageRequests');
        }
    }
    
    private function sendEmailNotifications($email, $fullname, $requeststatusid, $requesttypeid)
    {
        if($requeststatusid==2)
        {
            if($requesttypeid==1)
            {
                Mail::send('email.useraproved', ['email' => $email, 'fullname' => $fullname], function ($message) use ($email)
                {
                    $message->from('wolfimportsusa@wolfimportsusa.com', 'Wolf Imports USA');
                    $message->to($email);
                    $message->subject('Wolf Imports USA - Registro Aprovado.');
                });
            } else if($requesttypeid==2)
            {
                Mail::send('email.investmentaproved', ['email' => $email, 'fullname' => $fullname], function ($message) use ($email)
                {
                    $message->from('wolfimportsusa@wolfimportsusa.com', 'Wolf Imports USA');
                    $message->to($email);
                    $message->subject('Wolf Imports USA - Investimento Aprovado.');
                });
            }
            else if($requesttypeid==3) 
            {
                Mail::send('email.withdrawaproved', ['email' => $email, 'fullname' => $fullname], function ($message) use ($email)
                {
                    $message->from('wolfimportsusa@wolfimportsusa.com', 'Wolf Imports USA');
                    $message->to($email);
                    $message->subject('Wolf Imports USA - Saque Aprovado.');
                });
            }
            
        }
       
    }   
}
