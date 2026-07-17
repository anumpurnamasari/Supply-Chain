<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\EconomicData;
use App\Models\CurrencyRate;
use App\Models\RiskScore;

class DataVisualizationController extends Controller
{
    public function index()
    {
        // Ambil semua negara
        $countries = Country::orderBy('name')->get();

        $labels = [];
        $gdpData = [];
        $inflationData = [];
        $currencyData = [];
        $riskData = [];

        foreach ($countries as $country) {

            $economic = EconomicData::where('country_id', $country->id)
                ->latest()
                ->first();

            $currency = CurrencyRate::where('country_id', $country->id)
                ->latest()
                ->first();

            $risk = RiskScore::where('country_id', $country->id)
                ->latest()
                ->first();

            $labels[] = $country->name;

            $gdpData[] = $economic->gdp ?? 0;

            $inflationData[] = $economic->inflation ?? 0;

            $currencyData[] = $currency->currency_risk ?? 0;

            $riskData[] = $risk->total_score ?? 0;
        }

        return view('pages.visualization', compact(
            'labels',
            'gdpData',
            'inflationData',
            'currencyData',
            'riskData'
        ));
    }
}
