<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'direction_id',
        'tarif',
        'status',
        'daily_technical_job',
        'daily_medical_job',
        '30_hours_rule',
        'videoregistrator',
        'gps',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function cars()
    {
        return $this->hasMany(\App\UserCar::class,'direction_id');
    }
}
