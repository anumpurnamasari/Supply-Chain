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
        'currency'
    ];

    public function weather()
    {
        return $this->hasMany(WeatherData::class);
    }
}
