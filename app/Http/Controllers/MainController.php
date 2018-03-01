<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Balance;

class MainController extends Controller
{

    public function index(Request $request)
    {
        if (! $request->session()->has('loggeduser')) {
            return view('pages.signin');
        } else {
            
            $loggeduser = $request->session()->get('loggeduser');
            
            $currentDate = date('Y\-m\-d');
            
            $investiments = DB::table('investiment')->join('requests', 'investiment.requestid', '=', 'requests.id')
                ->select('investiment.id', 'investiment.value', 'investiment.userid', 'investiment.investimentpercent', 'investiment.durationindays', 'requests.reviewdate', 'requests.id as requestid')
                ->whereDate('investiment.duedate', '>=', $currentDate)
                ->where('requests.approved', true)
                ->where('userid', $loggeduser->id)
                ->get();
            
            $activeInvestimentsValue = 0;
            $activeDailyIncome = 0;
            $accumulatedIncome = 0;
            if (! empty($investiments)) {
                foreach ($investiments as $investiment) {
                    $activeInvestimentsValue = $activeInvestimentsValue + $investiment->value;
                    
                    $numberofmonths = $investiment->durationindays/30;
                    $totalperiodpercent = ($investiment->investimentpercent*$numberofmonths);
                    $totalearning = $investiment->value * ( $totalperiodpercent / 100);
                    $dailyearning = $totalearning / $investiment->durationindays;
                    
                    $activeDailyIncome = $activeDailyIncome + $dailyearning;
                }
            }
            
            $balances = Balance::where('userid', '=', $loggeduser->id)->get();
            if (! empty($balances)) {
                foreach ($balances as $balance) {
                    $accumulatedIncome = $accumulatedIncome + $balance->value;
                }
            }
        }
        return view('index', [
            'activeInvestimentsValue' => $activeInvestimentsValue,
            'activeDailyIncome' => number_format((float)$activeDailyIncome, 2, ',', ''),
            'accumulatedIncome' => number_format((float)$accumulatedIncome, 2, ',', '')
        
        ]);
    }
}
    
    
