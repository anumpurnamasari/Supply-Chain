<?php

namespace App\Services;


use App\Models\Country;
use App\Models\WeatherData;
use Illuminate\Support\Facades\Http;


class WeatherService
{

    public function syncWeather(
        Country $country
    )
    {


        $response = Http::get(

            'https://api.open-meteo.com/v1/forecast',

            [

                'latitude'
                    =>
                $country->latitude,


                'longitude'
                    =>
                $country->longitude,


                'current'
                    =>
                'temperature_2m,rain,wind_speed_10m,weather_code'


            ]

        );



        if (!$response->successful()) {

            return false;

        }


        $data = $response->json();


        $current =
            $data['current'];



        $stormRisk =
            $this->calculateStormRisk(

                $current['rain'],

                $current['wind_speed_10m']

            );



        WeatherData::updateOrCreate(

            [
                'country_id'
                    =>
                $country->id
            ],


            [

                'temperature'
                    =>
                $current['temperature_2m'],


                'rainfall'
                    =>
                $current['rain'],


                'wind_speed'
                    =>
                $current['wind_speed_10m'],


                'storm_risk'
                    =>
                $stormRisk,

                'weather_code' => $current['weather_code'] ?? null,

                'last_synced'
                    =>
                now()

            ]

        );


        return true;

    }

    private function calculateStormRisk($rain, $wind)
{
    $risk = 0;

    if ($rain >= 5) {
        $risk += 20;
    }

    if ($rain >= 20) {
        $risk += 30;
    }

    if ($wind >= 30) {
        $risk += 20;
    }

    if ($wind >= 60) {
        $risk += 30;
    }

    return min($risk,100);
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
