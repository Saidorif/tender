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
        'region_id',
        'direction_ids',
        'protocol_id',
        'type',
        'file',
        'created_by',
    ];

    protected $casts = [
        'direction_ids' => 'array'
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

    public function protocol()
    {
        return $this->belongsTo(\App\Protocol::class,'protocol_id');
    }

    public function region()
    {
        return $this->belongsTo(\App\Region::class,'region_id');
    }

    public function cars()
    {
        return $this->hasMany(\App\ContractCar::class,'contract_id')->with(['bustype','busmodel','busmarka','tclass','user']);
    }

    public function getDirectionIdsAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
        foreach ($d_ids as $key => $id) {
            $direction = Direction::where(['id' => $id])->with('type')->first();
            $result[] = $direction;
        }
        return $result;
    }
}
