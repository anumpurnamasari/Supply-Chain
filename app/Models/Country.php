<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
        'currency',
        'region',
        'population',
        'flag'
    ];

    public function weather()
    {
        return $this->hasMany(WeatherData::class);
    }

    public function watchlist()
    {
        return $this->hasOne(Watchlist::class);
    }
}
