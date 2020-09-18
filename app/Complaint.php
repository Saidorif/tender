<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'middlename',
        'phone',
        'text',
        'file',
        'status',
        'direction_id',
        'region_id',
        'area_id',
        'user_id',
    ];
}
