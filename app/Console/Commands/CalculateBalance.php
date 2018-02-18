<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Balance;

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
            ->select('investiment.id', 'investiment.value', 'investiment.userid', 'investiment.investimentpercent', 'investiment.durationindays', 'requests.reviewdate', 'requests.id as requestid')
            ->whereDate('investiment.duedate', '>=', $currentDate)
            ->where('requests.approved', true)
            ->get();
        
        if (! empty($investiments)) {
            foreach ($investiments as $investiment) {
                
                $totalearning = $investiment->value * ($investiment->investimentpercent / 100);
                $dailyearning = $totalearning / $investiment->durationindays;
                
                if($investiment->reviewdate!=$currentDate)
                {
                    $period = new \DatePeriod(new \DateTime($investiment->reviewdate), new \DateInterval('P1D'), new \DateTime($currentDate));
                    
                    foreach ($period as $date) {
                        $balance = Balance::where('date', '=', $date)->get();
                        if ($balance->isEmpty()) {
                            DB::beginTransaction();
                            
                            try {
                                
                                $newBalance = new Balance();
                                $newBalance->userid = $investiment->userid;
                                $newBalance->date = $date;
                                $newBalance->value = $dailyearning;
                                $newBalance->requestid = $investiment->requestid;
                                
                                $newBalance->save();
                                
                            } catch (\Exception $e) {
                                
                                echo $e->message;
                                
                                DB::rollback();
                            }
                            
                            DB::commit();
                        }
                    }
                }
                
               
            }
        }
    }
}