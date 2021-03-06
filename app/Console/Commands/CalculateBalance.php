<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Balance;
use Illuminate\Support\Facades\Log;
use App\Investiment;
use Illuminate\Support\Facades\Mail;
use App\UserAnalysis;

class CalculateBalance extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calculate:balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command calculates the balance os each user with active investment daily.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $currentDate = date('Y\-m\-d');
        
        $investiments = DB::table('investiment')->join('requests', 'investiment.requestid', '=', 'requests.id')
        ->select('investiment.id', 'investiment.value', 'investiment.userid', 'investiment.investimentpercent', 'investiment.durationindays', 'investiment.duedate','requests.reviewdate', 'requests.id as requestid')
           // ->whereDate('investiment.duedate', '>=', $currentDate)
            ->where('requests.approved', true)
            ->get();
        
        if (! empty($investiments)) {
            foreach ($investiments as $investiment) {
                
                $numberofmonths = $investiment->durationindays/30;
                $totalperiodpercent = ($investiment->investimentpercent*$numberofmonths);
                $totalearning = $investiment->value * ( $totalperiodpercent / 100);
                $dailyearning = $totalearning / $investiment->durationindays;
                
                if($investiment->reviewdate!=$currentDate)
                {
                    $currentDate2 = (new \DateTime($currentDate))->modify('+1 day');
                    
                    $period = new \DatePeriod(new \DateTime($investiment->reviewdate), new \DateInterval('P1D'), $currentDate2);
                    
                    if($investiment->duedate>=$currentDate)
                    {
                        foreach ($period as $date) {
                            $balance = Balance::where('date', '=', $date)
                            ->where('userid','=',$investiment->userid)
                            ->where('investimentid','=',$investiment->id)
                            ->get();
                            if ($balance->isEmpty()) {
                                DB::beginTransaction();
                                
                                try {
                                    
                                    $newBalance = new Balance();
                                    $newBalance->userid = $investiment->userid;
                                    $newBalance->date = $date;
                                    $newBalance->value = $dailyearning;
                                    $newBalance->requestid = $investiment->requestid;
                                    $newBalance->investimentid = $investiment->id;
                                    
                                    $newBalance->save();
                                    
                                } catch (\Exception $e) {
                                    
                                    echo $e->message;
                                    
                                    DB::rollback();
                                }
                                
                                DB::commit();
                            }
                        }
                    }
                    else 
                    {
                        $doneInvestiments = Investiment::where("investiment.id", "=", $investiment->id);
                        
                        if (! empty($doneInvestiments)) {
                            $doneInvestiment = $doneInvestiments->first();
                            
                            if($doneInvestiment->done==false)
                            {
                             try
                               {
                                   $doneInvestiment->done = true;
                                   
                                   $doneInvestiment->save();
                                   
                                   //Adding investment value to balance
                                   $newBalance = new Balance();
                                   
                                   $newBalance->userid = $doneInvestiment->userid;
                                   
                                   $newBalance->date = $currentDate;
                                   
                                   $newBalance->value = $doneInvestiment->value;
                                   
                                   $newBalance->requestid = $doneInvestiment->requestid;
                                   
                                   $newBalance->investimentid = $investiment->id;
                                   
                                   $newBalance->save();
                                   
                                   //Updating investment percent when fisrt investment is done
                                   
                                   $matchThese = ['userid' => $investiment->userid];
                                   
                                   $userAnalysis = UserAnalysis::where($matchThese)->first();
                                   
                                   if($userAnalysis->investimentpercent<20)
                                   {
                                       $userAnalysis->investimentpercent = 20;
                                   }
                                   
                                   $userAnalysis->save();
                                   
                                } catch (\Exception $e) {
                                    
                                    echo $e->message;
                                    
                                    DB::rollback();
                                }
                            }
                        }
                       
                    }
                }
            }
        }
    }
 
}
