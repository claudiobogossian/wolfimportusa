<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankData extends Model
{
    protected $table = 'bankdata';	
    protected $fillable = array('userid', 'bankid', 'agency', 'account', 'enabled');
    public $timestamps = false;
}
