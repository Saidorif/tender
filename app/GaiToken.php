<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GaiToken extends Model
{
    protected $fillable = ['token','expires_in'];
}
