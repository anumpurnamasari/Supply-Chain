<?php


namespace App\Services;


use App\Models\RiskScore;


class RiskCalculatorService
{


public function calculate($countryId)
{


    /*
    ===============================
    WEIGHTED RISK MODEL

    Weather   = 30%
    Inflation = 20%
    News      = 40%
    Currency  = 10%
    ===============================
    */


    $weatherScore =
    rand(10,40);


    $inflationScore =
    rand(10,30);


    $currencyScore =
    rand(5,25);


    $newsScore =
    rand(10,50);




    $total =

    ($weatherScore * 0.3)
    +
    ($inflationScore * 0.2)
    +
    ($currencyScore * 0.1)
    +
    ($newsScore * 0.4);






    if($total < 30){

        $level = "LOW";

    }
    elseif($total < 60){

        $level = "MEDIUM";

    }
    else{

        $level = "HIGH";

    }






    return RiskScore::updateOrCreate(

        [

            'country_id'
            =>
            $countryId

        ],


        [

            'weather_score'
            =>
            $weatherScore,


            'inflation_score'
            =>
            $inflationScore,


            'currency_score'
            =>
            $currencyScore,


            'news_score'
            =>
            $newsScore,


            'total_score'
            =>
            round($total),


            'risk_level'
            =>
            $level

        ]

    );


}



}
