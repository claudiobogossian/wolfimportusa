<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currency';	
    protected $fillable = array('id', 'name', 'prefix');
    public $timestamps = false;
}
