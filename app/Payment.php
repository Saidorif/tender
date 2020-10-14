<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['user_id', 'summ', 'date', 'status', 'details', 'delete_reason', 'transaction_id','inn', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(\App\User::class, 'updated_by');
    }
}
