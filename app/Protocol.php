<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $fillable = [
        'region_id',
        'created_by',
        'number',
        'date',
        'file'
    ];

    public function region()
    {
        return $this->belongsTo(\App\Region::class,'region_id');
    }

    public function creater()
    {
        return $this->belongsTo(\App\User::class,'created_by');
    }
}
