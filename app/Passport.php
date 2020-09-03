<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    protected $fillable = ['direction_id','name'];

    public function files()
    {
        return $this->hasMany(\App\PassportFile::class,'passport_id');
    }

    public function direction()
    {
        return $this->belongsTo(\App\Direction::class,'direction_id');
    }
}