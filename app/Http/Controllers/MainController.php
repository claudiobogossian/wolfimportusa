<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Balance;

class MainController extends Controller
{

    public function index(Request $request)
    {
        $investmentsList = array();
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
            

            
           
            if (! empty($investiments)) {
                foreach ($investiments as $investiment) {
                    
                    $investmentMap = array();
                    
                    $activeInvestimentValue = 0;
                    $activeDailyIncome = 0;
                    $accumulatedIncome = 0;
                    
                    $activeInvestimentValue = $activeInvestimentValue + $investiment->value;
                    
                    $numberofmonths = $investiment->durationindays/30;
                    $totalperiodpercent = ($investiment->investimentpercent*$numberofmonths);
                    $totalearning = $investiment->value * ( $totalperiodpercent / 100);
                    $dailyearning = $totalearning / $investiment->durationindays;
                    
                    $activeDailyIncome = $activeDailyIncome + $dailyearning;
                    
                    
                    $balances = Balance::where('userid', '=', $loggeduser->id)->where('investimentid','=', $investiment->id)->get();
                    if (! empty($balances)) {
                        foreach ($balances as $balance) {
                            $accumulatedIncome = $accumulatedIncome + $balance->value;
                        }
                    }
                    
                    $investmentMap['activeInvestimentValue'] = $activeInvestimentValue;
                    $investmentMap['activeDailyIncome'] = number_format((float)$activeDailyIncome, 2, ',', '');
                    $investmentMap['accumulatedIncome'] = number_format((float)$accumulatedIncome, 2, ',', '');
                    
                    $chartData = array();
                    
                    $currentDate2 = (new \DateTime($currentDate))->modify('+1 day');
                    
                    $chartData = MainController::getChartData($chartData, new \DateTime($investiment->reviewdate), $currentDate2, $activeDailyIncome);
                    
                    $investmentMap['chartData'] = $chartData;
                    
                    array_push($investmentsList,$investmentMap);
                }
            }
                       

            
        }
        return view('index', [
            'investmentsList' => $investmentsList
        ]);
    }
    
    private function getChartData($chartData, $reviewDate, $currentDate, $activeDailyIncome)
    {
        
        $period = new \DatePeriod($reviewDate, new \DateInterval('P1D'), $currentDate);
        
        foreach ($period as $date)
        {
            $formattedDate= $date->format('d-m-Y');
            if(array_key_exists($formattedDate, $chartData))
            {
                $chartData[$formattedDate]=$chartData[$formattedDate] + $activeDailyIncome;
            }
            else
            {
                $chartData[$formattedDate]=$activeDailyIncome;
            }
        
        }
        
        return $chartData;
    }
}
    
    
