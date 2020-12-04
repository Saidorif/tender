<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AdliyaCar extends Model
{
    protected $fillable = [
        "user_id",
        "app_id",
        "pINN",
        "pPinfl",
        "nameOwner",
        "pKuzov",
        "pNumberNatarius",
        "pDateNatarius",
        "startDate",
        "expirationDate",
        "resultCode",
        "resultNote",
    ];
}
