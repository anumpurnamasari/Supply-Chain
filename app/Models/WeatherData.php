<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $fillable = [
        'country_id',
        'temperature',
        'rainfall',
        'wind_speed',
        'weather_code'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
