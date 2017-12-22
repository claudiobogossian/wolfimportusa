<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plan';	
    protected $fillable = array('name', 'days');
    public $timestamps = false;
}
