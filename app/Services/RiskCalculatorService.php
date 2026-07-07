<?php

namespace App\Services;


class RiskCalculatorService
{


    public function calculate(
        $weatherRisk,
        $currencyRisk,
        $inflationRisk = 0,
        $newsRisk = 0
    )
    {


        $total =

        ($weatherRisk * 0.3)
        +
        ($inflationRisk * 0.2)
        +
        ($newsRisk * 0.4)
        +
        ($currencyRisk * 0.1);



        if($total <= 30){


            $level =
            "LOW";


        }
        elseif($total <= 60){


            $level =
            "MEDIUM";


        }
        else{


            $level =
            "HIGH";


        }




        return [


            "score" =>
            round($total),


            "level" =>
            $level


        ];


    }


}
