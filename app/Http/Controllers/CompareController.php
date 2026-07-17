<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\WeatherData;
use App\Models\EconomicData;
use App\Models\CurrencyRate;
use App\Models\RiskScore;

use Illuminate\Http\Request;

class CompareController extends Controller
{
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();

        $countryA = null;
        $countryB = null;

        $weatherA = null;
        $weatherB = null;

        $economicA = null;
        $economicB = null;

        $currencyA = null;
        $currencyB = null;

        $riskA = null;
        $riskB = null;

        if ($request->filled('country_a') && $request->filled('country_b')) {

            $countryA = Country::find($request->country_a);
            $countryB = Country::find($request->country_b);

            $weatherA = WeatherData::where('country_id',$countryA->id)->latest()->first();
            $weatherB = WeatherData::where('country_id',$countryB->id)->latest()->first();

            $economicA = EconomicData::where('country_id',$countryA->id)->latest()->first();
            $economicB = EconomicData::where('country_id',$countryB->id)->latest()->first();

            $currencyA = CurrencyRate::where('country_id',$countryA->id)->latest()->first();
            $currencyB = CurrencyRate::where('country_id',$countryB->id)->latest()->first();

            $riskA = RiskScore::where('country_id',$countryA->id)->latest()->first();
            $riskB = RiskScore::where('country_id',$countryB->id)->latest()->first();
        }

        return view('pages.compare', compact(

            'countries',

            'countryA',
            'countryB',

            'weatherA',
            'weatherB',

            'economicA',
            'economicB',

            'currencyA',
            'currencyB',

            'riskA',
            'riskB'

        ));
    }
}
