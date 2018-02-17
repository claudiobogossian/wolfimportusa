<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investiment extends Model
{
    protected $table = 'investiment';	
    protected $fillable = array('userid', 'value','durationindays','enabled','requestid','duedate');
    public $timestamps = false;
}
