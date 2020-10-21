<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'direction_ids',
        'tender_id',
        'lot_id',
        'tarif',
        'status',
        'daily_technical_job',
        'daily_medical_job',
        'hours_rule',
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
        return $this->hasMany(\App\UserCar::class,'app_id');
    }

    public function carsWith()
    {
        return $this->cars()->with(['bustype','busmodel','tclass','busmarka']);
    }

    public function tender()
    {
        return $this->belongsTo(\App\Tender::class,'tender_id')->with('tenderlots');
    }
    public function lots()
    {
        return $this->belongsTo(\App\TenderLot::class,'lot_id');//->with('tenderlots');
    }

    public function attachment()
    {
        return $this->hasMany(\App\File::class,'app_id');
    }
}
