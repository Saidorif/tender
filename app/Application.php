<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'direction_ids',
        'tender_id',
        'tarif',
        'status',
        'daily_technical_job',
        'daily_medical_job',
        '30_hours_rule',
        'videoregistrator',
        'gps',
    ];

    protected $casts = ['direction_ids' => 'array'];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function cars()
    {
        return $this->hasMany(\App\UserCar::class,'tender_id');
    }

    public function carsWith()
    {
        return $this->cars()->with(['bustype','busmodel','tclass']);
    }
}
