<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Direction;

class Tender extends Model
{
    protected $fillable = [
        'direction_ids',
        'time',
        'address',
        'status',
        'approved_by',
        'created_by',
    ];

    protected $casts = [
        'direction_ids' => 'array'
    ];

    public function tenderlots()
    {
        return $this->hasMany(\App\TenderLot::class,'tender_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class,'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\User::class,'approved_by');
    }

    public function getDirectionIdsAttribute($value)
    {
        $value = json_decode($value,true);
        // var_dump($value);die;
        $directions = Direction::whereIn('id', $value)->get();
        return $directions;
    }
}
