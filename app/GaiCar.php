<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GaiCar extends Model
{
    protected $fillable = [
        'user_id',
        'app_id',
        'pTexpassportSery',
        'pTexpassportNumber',
        'pPlateNumber',
        "pVehicleId",
        "pMarka",
        "pMadeofYear",
        "pNumberofplace",
        "pWeightAuto",
        "pNameOfClient",
        "pTypeOfAuto",
        "pTechnicalStatus",
        "pAdressOfClient",
        "status",
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function application()
    {
        return $this->belongsTo(\App\Application::class,'app_id');
    }
}
