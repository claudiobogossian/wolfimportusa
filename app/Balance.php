<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Balance extends Model
{
    protected $table = 'balance';	
    protected $fillable = array('userid', 'date', 'value', 'investimentid');
    public $timestamps = false;
    
    public static function calculateCurrentBalance($user)
    {
        $balancesFromInvestiment = DB::table('balance')
        ->join('investiment','balance.investimentid','=','investiment.id')
        ->select('balance.value')
        ->where('investiment.done','=',1)
        ->where('balance.userid','=',$user->id)
        ->get();
        
        $balancesWithoutInvestiment = DB::table('balance')
        ->select('balance.value')
        ->where('balance.investimentid',null)
        ->where('balance.requestid',null)
        ->where('balance.userid','=',$user->id)
        ->get();
        
        $accumulatedIncome=0;
        
        if (! empty($balancesFromInvestiment)) {
            foreach ($balancesFromInvestiment as $balance) {
                $accumulatedIncome = $accumulatedIncome + $balance->value;
            }
        }
        
        if (! empty($balancesWithoutInvestiment)) {
            foreach ($balancesWithoutInvestiment as $balance) {
                $accumulatedIncome = $accumulatedIncome + $balance->value;
            }
        }
        
        return $accumulatedIncome;
    }
   

}
