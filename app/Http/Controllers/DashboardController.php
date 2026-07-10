<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;
use App\Services\RiskCalculatorService;
use App\Models\Port;
use App\Models\CurrencyRate;
use App\Models\EconomicData;
use App\Models\NewsCache;


class DashboardController extends Controller
{


    private RiskCalculatorService $riskService;



    public function __construct(
        RiskCalculatorService $riskService
    )
    {

        $this->riskService =
        $riskService;

    }




    public function index()
    {


        // ======================
        // COUNTRY
        // ======================


        $country =
        Country::latest()
        ->first();




        // ======================
        // AUTO CALCULATE RISK
        // ======================


        if($country){


            $risk =
            $this
            ->riskService
            ->calculate(
                $country->id
            );


        }
        else{


            $risk =
            null;


        }






        // ======================
        // OTHER DATA
        // ======================


        $weather =
        WeatherData::latest()
        ->first();




        $ports =
        Port::all();




        $currency =
        CurrencyRate::latest()
        ->first();




        $economic =
        EconomicData::latest()
        ->first();




        $news =
        NewsCache::latest()
        ->take(5)
        ->get();






        // ======================
        // CHART DATA
        // ======================


        $riskChart = [


            'Weather'
            =>
            $risk->weather_score ?? 0,



            'Currency'
            =>
            $risk->currency_score ?? 0,



            'Inflation'
            =>
            $risk->inflation_score ?? 0,



            'News'
            =>
            $risk->news_score ?? 0,



            'Total'
            =>
            $risk->total_score ?? 0


        ];








        return view(

            'dashboard',


            compact(

                'country',

                'weather',

                'risk',

                'ports',

                'currency',

                'economic',

                'news',

                'riskChart'

            )

        );


    }


}
