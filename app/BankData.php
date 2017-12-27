<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankData extends Model
{
    protected $table = 'bankdata';	
    protected $fillable = array('userid', 'bankid', 'fullname', 'document', 'agency', 'account', 'type', 'enabled');
    public $timestamps = false;
}
