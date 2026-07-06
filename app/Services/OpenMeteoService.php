<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class OpenMeteoService
{
    public function getWeather($latitude, $longitude)
    {
        $response = Http::get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => [
                    'temperature_2m',
                    'rain',
                    'wind_speed_10m'
                ]
            ]
        );


        return $response->json();
    }
}
