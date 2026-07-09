<?php

namespace App\Http\Controllers;


use App\Models\WeatherData;
use App\Models\RiskScore;


class WeatherController extends Controller
{


public function index()
{


    $weather =
    WeatherData::latest()
    ->first();


    $risk =
    RiskScore::latest()
    ->first();



    return view(
        'pages.weather',
        compact(
            'weather',
            'risk'
        )
    );


}


}
