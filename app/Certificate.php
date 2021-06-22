<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'company_name',
        'contract_id',
        'seria',
        'number',
        'car_id',
        'direction_id',
        'exp_date',
        'qr_code',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function direction()
    {
        return $this->belongsTo(\App\Direction::class,'direction_id');
    }

    public function car()
    {
        return $this->belongsTo(\App\UserCar::class,'car_id');
    }
}