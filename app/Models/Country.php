<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WeatherCache;

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

    public function weather()
    {
        return $this->hasOne(
            WeatherCache::class
        );
    }
}
