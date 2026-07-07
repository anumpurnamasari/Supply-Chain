<?php


namespace App\Services;


use Illuminate\Support\Facades\Http;



class WorldBankService
{


    public function getEconomic(
        $countryCode
    )
    {



        // GDP

        $gdpResponse =
        Http::get(

        "https://api.worldbank.org/v2/country/"
        .$countryCode.
        "/indicator/NY.GDP.MKTP.CD?format=json"

        );



        // Inflation


        $inflationResponse =
        Http::get(

        "https://api.worldbank.org/v2/country/"
        .$countryCode.
        "/indicator/FP.CPI.TOTL.ZG?format=json"

        );




        return [


            "gdp" =>

            $gdpResponse
            ->json()[1][0]['value']
            ?? 0,



            "inflation" =>

            $inflationResponse
            ->json()[1][0]['value']
            ?? 0


        ];



    }


}
