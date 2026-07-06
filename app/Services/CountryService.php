<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class CountryService
{


    public function getCountry($name)
    {


        $response =
        Http::post(
            "https://countriesnow.space/api/v0.1/countries/population",
            [
                "country" => $name
            ]
        );


        return $response->json();


    }


}
