<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnalysis extends Model
{
    protected $table = 'useranalysis';	
    protected $fillable = array('userid', 'enabled', 'investimentpercent','requestid');
    public $timestamps = false;
}
