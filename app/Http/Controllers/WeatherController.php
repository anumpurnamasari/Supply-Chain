<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;
use App\Services\OpenMeteoService;


class WeatherController extends Controller
{

    public function sync(
        Country $country,
        OpenMeteoService $weatherService
    )
    {

        $data = $weatherService->getWeather(
            $country->latitude,
            $country->longitude
        );


        $current = $data['current'];


        $weather = WeatherData::create([
            'country_id' => $country->id,

            'temperature' =>
            $current['temperature_2m'],

            'rainfall' =>
            $current['rain'],

            'wind_speed' =>
            $current['wind_speed_10m'],

            'weather_code' => 0
        ]);



        /*
        SIMPLE RISK ALGORITHM
        */

        $score = 0;


        if ($weather->temperature > 35) {
            $score += 30;
        }


        if ($weather->rainfall > 10) {
            $score += 40;
        }


        if ($weather->wind_speed > 40) {
            $score += 30;
        }



        if ($score <= 30) {

            $level = "LOW";

        } elseif ($score <= 60) {

            $level = "MEDIUM";

        } else {

            $level = "HIGH";
        }



        RiskScore::create([

            'country_id'
                => $country->id,

            'weather_score'
                => $score,

            'risk_level'
                => $level
        ]);



        return redirect()
            ->back()
            ->with(
                'success',
                'Weather Updated'
            );

    }
}
