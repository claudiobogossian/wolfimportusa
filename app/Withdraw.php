<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    protected $table = 'withdraw';	
    protected $fillable = array('date', 'requestid', 'userid', 'value');
    public $timestamps = false;
}
