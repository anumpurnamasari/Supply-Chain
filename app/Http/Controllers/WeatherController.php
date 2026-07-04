<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Services\WeatherService;


class WeatherController extends Controller
{

    public function sync(
        WeatherService $service
    )
    {


        $countries =
            Country::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();


        $count = 0;


        foreach ($countries as $country) {


            $service->syncWeather(
                $country
            );


            $count++;

        }



        return "Synced weather for {$count} countries";


    }

}
