<?php

namespace App\Services;


use App\Models\Country;
use App\Models\WeatherCache;
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
                'temperature_2m,rain,wind_speed_10m'


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



        WeatherCache::updateOrCreate(

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


                'last_synced'
                    =>
                now()

            ]

        );


        return true;

    }



    private function calculateStormRisk(
        $rain,
        $wind
    )
    {

        $score = 0;


        if ($rain > 20) {

            $score += 50;

        }


        if ($wind > 50) {

            $score += 50;

        }


        return $score;

    }

}
