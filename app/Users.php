<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';	
    protected $fillable = array('firstname', 'lastname', 'email','document','birthdate', 'registrydate', 'password', 'currencyid', 'languageid');
    public $timestamps = false;
}
