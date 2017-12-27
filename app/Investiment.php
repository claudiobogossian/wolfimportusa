<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Investiment extends Model
{
    protected $table = 'investiment';	
    protected $fillable = array('userid', 'value','planid','enabled','requestid');
    public $timestamps = false;
}
