<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;

class WeatherController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $country = Country::find($request->country_id);

        if (!$country) {
            $country = Country::where('code', 'ID')->first();
        }

        $weather = WeatherData::where(
            'country_id',
            $country->id
        )->latest()->first();

        $risk = RiskScore::where(
            'country_id',
            $country->id
        )->latest()->first();

        return view(
            'pages.weather',
            compact(
                'countries',
                'country',
                'weather',
                'risk'
            )
        );
    }
}
