<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DirectionReq extends Model
{
    protected $fillable = [
        'direction_id',
        'auto_type',
        'auto_type_name',
        'auto_model_class',
        'auto_trans_count',
        'auto_trans_count_from',
        'auto_trans_count_to',
        'auto_trans_working_days',
        'auto_trans_weekends',
        'auto_trans_status',
        'direction_total_length',
        'direction_from_value',
        'direction_from_name',
        'direction_to_value',
        'direction_to_name',
        'stations_count',
        'stations_from_name',
        'stations_to_name',
        'stations_from_value',
        'stations_to_value',
        'seasonal',
        'reyses_count',
        'reyses_from_value',
        'reyses_from_name',
        'reyses_to_value',
        'reyses_to_name',
        'schedule_begin_time',
        'schedule_begin_from',
        'schedule_begin_to',
        'schedule_end_time',
        'schedule_end_from',
        'schedule_end_to',
        'station_intervals',
        'reys_time',
        'reys_from_value',
        'reys_to_value',
        'schedules',
        'tarif',
        'tarif_one_km',
        'tarif_full_km',
        'tarif_city',
        'transports_capacity',
        'transports_seats',
        'minimum_bal',
        'status',
        'approver',
        'text',
    ];

    protected $casts = ['auto_model_class' => 'array'];

    public function type()
    {
        return $this->direction();
    }

    public function direction()
    {
        return $this->belongsTo(\App\Direction::class,'direction_id');
    }

    public function getAutoModelClassAttribute($value)
    {
        $d_ids = json_decode($value,true);
        $result = [];
        if(!empty($d_ids)){
            foreach ($d_ids as $key => $id) {
                $tclass = DirectionCar::with(['marka','model','bustype','tclass'])->where(['id' => $id])->first();
                $result[] = $tclass;
            }
        }
        return $result;
    }
}
