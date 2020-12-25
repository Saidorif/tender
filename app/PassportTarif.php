<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassportTarif extends Model
{
    protected $fillable = [
        'direction_id',
        'status',
        'summa',
        'summa_bagaj',
        'approved_id',
    ];

    public function direction()
    {
        return $this->belongsTo(\App\Direction::class,'direction_id');
    }
    
    public function approved()
    {
        return $this->belongsTo(\App\User::class,'approved_id');
    }
}
