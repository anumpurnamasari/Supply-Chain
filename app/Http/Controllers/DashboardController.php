<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;


class DashboardController extends Controller
{


    public function index()
    {


        $country =
        Country::latest()
        ->first();


        $weather =
        WeatherData::latest()
        ->first();


        $risk =
        RiskScore::latest()
        ->first();



        return view(
            'dashboard',
            compact(
                'country',
                'weather',
                'risk'
            )
        );


    }


}
