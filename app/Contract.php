<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'user_id',
        'app_id',
        'app_ball_id',
        'tender_id',
        'lot_id',
        'number',
        'date',
        'exp_date',
        'contract_period',
    ];

    public function lot()
    {
        return $this->belongsTo(\App\TenderLot::class,'lot_id');
    }
    
    public function tender()
    {
        return $this->belongsTo(\App\Tender::class,'tender_id');
    }
    
    public function app()
    {
        return $this->belongsTo(\App\Application::class,'app_id')->with('carsWith');
    }
    
    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }
    
    public function ball()
    {
        return $this->belongsTo(\App\ApplicationBall::class,'app_ball_id');
    }
}
