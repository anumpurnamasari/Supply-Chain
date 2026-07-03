<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [

        'country_code',
        'country_name',
        'capital',
        'region',
        'currency',
        'currency_symbol',
        'population',
        'latitude',
        'longitude',
        'flag',
        'last_synced'

    ];
}
