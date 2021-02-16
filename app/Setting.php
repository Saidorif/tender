<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'salary',
        'logo',
        'favicon',
        'name',
        'bank_number',
        'city',
        'oked',
        'mfo',
        'inn',
        'phone',
        'address',
        'email',
        'created_by',
        'updated_by',
    ];
}
