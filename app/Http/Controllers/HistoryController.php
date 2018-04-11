<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{

    public function showHistory(Request $request)
    {
        if (! $request->session()->has('loggeduser')) {
            return view('pages.signin');
        } else {
            
            $user = $request->session()->get('loggeduser');
            
            $matchThese = [
                'userid' => $user->id
            ];
            
            $withdrawsrequest = DB::table('withdraw')->join('requests', 'withdraw.requestid', '=', 'requests.id')
                ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
                ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
                ->where('withdraw.userid',$user->id)
                ->select('requests.id', 'withdraw.value', 'requeststatus.name as requeststatusname', 'requesttype.name as requesttypename', 'requests.date')
                ->orderBy('requests.date')
            ->get();
            
            $investimentsrequest = DB::table('investiment')->join('requests', 'investiment.requestid', '=', 'requests.id')
                ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
                ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
                ->where('investiment.userid',$user->id)
                ->select('requests.id', 'investiment.value', 'requeststatus.name as requeststatusname', 'requesttype.name as requesttypename', 'requests.date')
                ->orderBy('requests.date')
            ->get();
            
            $usersrequest = DB::table('useranalysis')->join('requests', 'useranalysis.requestid', '=', 'requests.id')
                ->join('requeststatus', 'requests.requeststatusid', '=', 'requeststatus.id')
                ->join('requesttype', 'requests.requesttypeid', '=', 'requesttype.id')
                ->where('useranalysis.userid',$user->id)
                ->select('requests.id', 'requeststatus.name as requeststatusname', 'requesttype.name as requesttypename', 'requests.date')
                ->orderBy('requests.date')
                ->get();
          
            return view('pages.history', [
                'userrequest' => $usersrequest,
                'investimentsrequest' => $investimentsrequest,
                'withdrawsrequest' => $withdrawsrequest
            ]);
        }
    }
}
