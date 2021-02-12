<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationBall extends Model
{
    protected $fillable = [
        'user_id',
        'direction_ids',
        'company_name',
        'name',
        'app_id',
        'lot_id',
        'app_tarif',
        'lot_tarif',
        'tarif_ball',
        'app_reys',
        'lot_reys',
        'reys_ball',
        'app_years',
        'lot_years',
        'years_ball',
        'app_capacity',
        'lot_capacity',
        'capacity_ball',
        'app_categoryies',
        'lot_categoryies',
        'categoryies_ball',
        'app_models',
        'lot_models',
        'models_ball',
        'daily_technical_job',
        'daily_medical_job',
        'hours_rule',
        'videoregistrator',
        'gps',
        'cars_ball',
        'total_ball',
    ];

    protected $casts = [
        'direction_ids' => 'array',
        'app_categoryies' => 'array',
        'lot_categoryies' => 'array',
        'app_models' => 'array',
        'lot_models' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }
}
