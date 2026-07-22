<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Country;
use App\Models\WeatherData;
use App\Models\EconomicData;
use App\Models\CurrencyRate;
use App\Models\RiskScore;

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

            // WEATHER

            $weatherA = WeatherData::where('country_id', $countryA->id)
                ->latest()
                ->first();

            $weatherB = WeatherData::where('country_id', $countryB->id)
                ->latest()
                ->first();

            // ECONOMIC

            $economicA = EconomicData::where('country_id', $countryA->id)
                ->where(function ($q) {
                    $q->where('gdp', '>', 0)
                      ->orWhere('inflation', '>', 0)
                      ->orWhere('population', '>', 0);
                })
                ->latest()
                ->first();

            $economicB = EconomicData::where('country_id', $countryB->id)
                ->where(function ($q) {
                    $q->where('gdp', '>', 0)
                      ->orWhere('inflation', '>', 0)
                      ->orWhere('population', '>', 0);
                })
                ->latest()
                ->first();

            // CURRENCY

            $currencyA = CurrencyRate::where('country_id', $countryA->id)
                ->where('exchange_rate', '>', 0)
                ->latest()
                ->first();

            $currencyB = CurrencyRate::where('country_id', $countryB->id)
                ->where('exchange_rate', '>', 0)
                ->latest()
                ->first();

                    // RISK SCORE

            $riskA = RiskScore::where('country_id', $countryA->id)
                ->where('total_score', '>', 0)
                ->latest()
                ->first();

            $riskB = RiskScore::where('country_id', $countryB->id)
                ->where('total_score', '>', 0)
                ->latest()
                ->first();
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
