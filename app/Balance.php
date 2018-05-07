<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table = 'balance';	
    protected $fillable = array('userid', 'date', 'value', 'investimentid');
    public $timestamps = false;
}
