<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = ['user_id','inn', 'created_by','tender_id','lot_id','status', 'year','number','date','qrcode','text','region_id','app_id','price'];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    public function tender()
    {
        return $this->belongsTo(\App\Tender::class, 'tender_id');
    }

    public function lot()
    {
        return $this->belongsTo(\App\TenderLot::class, 'lot_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(\App\User::class, 'created_by');
    }
}
