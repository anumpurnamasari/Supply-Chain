<?php

namespace App\Services;


use App\Models\Country;
use App\Models\WeatherData;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class WeatherService
{

    public function syncWeather(
        Country $country
    )
    {


        $response = Http::get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $country->latitude,
                'longitude' => $country->longitude,

                'current' => 'temperature_2m,wind_speed_10m,weather_code',

                'daily' => 'precipitation_sum',

                'timezone' => 'auto'
            ]
        );



        if (!$response->successful()) {

            return false;

        }


        $data = $response->json();


        $current = $data['current'];

        $rain = $data['daily']['precipitation_sum'][0] ?? 0;

        $stormRisk = $this->calculateStormRisk(
            $rain,
            $current['wind_speed_10m']
        );


        $rain = $data['daily']['precipitation_sum'][0] ?? 0;

        Log::info('Weather Sync', [
            'country_id' => $country->id,
            'country' => $country->name,
            'rain' => $rain,
            'wind' => $current['wind_speed_10m'],
        ]);

        $weather = WeatherData::updateOrCreate(
    [
        'country_id' => $country->id
    ],
    [
        'temperature' => $current['temperature_2m'],
        'rainfall' => $rain,
        'wind_speed' => $current['wind_speed_10m'],
        'storm_risk' => $stormRisk,
        'weather_code' => $current['weather_code'] ?? null,
        'last_synced' => now(),
    ]
);


        return true;

    }

    private function calculateStormRisk(float $rain, float $wind): int
{
    $risk = 0;

    if ($rain >= 1) {
            $risk += 20;
    }

    if ($rain >= 5) {
            $risk += 30;
    }

    if ($wind >= 20) {
            $risk += 20;
    }

    if ($wind >= 40) {
            $risk += 30;
    }

    return min($risk, 100);
}

    private function getWeatherDescription($code)
    {
    return match($code){

        0 => 'Clear Sky',

        1 => 'Mainly Clear',

        2 => 'Partly Cloudy',

        3 => 'Overcast',

        45 => 'Fog',

        48 => 'Fog',

        51 => 'Light Drizzle',

        53 => 'Drizzle',

        55 => 'Heavy Drizzle',

        61 => 'Light Rain',

        63 => 'Rain',

        65 => 'Heavy Rain',

        71 => 'Snow',

        80 => 'Rain Shower',

        95 => 'Thunderstorm',

        default => 'Unknown'

    };
}

}
