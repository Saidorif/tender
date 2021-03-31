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
        'app_categories',
        'lot_categories',
        'categories_ball',
        'app_models',
        'lot_models',
        'models_ball',
        'daily_technical_job',
        'daily_medical_job',
        'hours_rule',
        'videoregistrator',
        'gps',
        'tadbirlar_rejasi_ball',
        'cars_ball',
        'total_ball',
        'status',
    ];

    protected $casts = [
        //'direction_ids' => 'array',
        'app_categories' => 'array',
        'lot_categories' => 'array',
        'app_models' => 'array',
        'lot_models' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function application()
    {
        return $this->belongsTo(\App\Application::class,'app_id');
    }

    public function getAppCategoriesAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
        foreach ($d_ids as $key => $id) {
            $bustype = BusType::find($id);
            $result[] = $bustype;
        }
        return $result;
    }

    public function getLotCategoriesAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
        foreach ($d_ids as $key => $id) {
            $bustype = BusType::find($id);
            $result[] = $bustype;
        }
        return $result;
    }

    public function getAppModelsAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
        foreach ($d_ids as $key => $id) {
            $bustype = TClass::find($id);
            $result[] = $bustype;
        }
        return $result;
    }

    public function getLotModelsAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
        foreach ($d_ids as $key => $id) {
            $bustype = TClass::find($id);
            $result[] = $bustype;
        }
        return $result;
    }
}
