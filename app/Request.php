<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    protected $table = 'requests';	
    protected $fillable = array('date', 'requesttypeid', 'requeststatusid','approved');
    public $timestamps = false;
}
