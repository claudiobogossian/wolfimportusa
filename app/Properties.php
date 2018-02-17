<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Properties extends Model
{
    protected $table = 'properties';	
    protected $fillable = array('name','value','propertytype');
    public $timestamps = false;
}
