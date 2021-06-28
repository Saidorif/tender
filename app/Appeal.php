<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $fillable = [
        'company_name',
        'user_id',
        'contract_id',
        'type',
        'text',
        'user_file',
        'answer_file',
        'date',
        'approved_by',
        'approved_date',
        'answer_text',
        'status',
        'region_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class,'user_id');
    }

    public function contract()
    {
        return $this->belongsTo(\App\Contract::class,'contract_id');
    }

    public function region()
    {
        return $this->belongsTo(\App\Region::class,'region_id');
    }
}
