<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class CountryService
{
    public function syncCountries()
    {
        $response = Http::get(
            'https://countriesnow.space/api/v0.1/countries/info?returns=currency,flag,unicodeFlag,dialCode'
        );


        if (!$response->successful()) {
            throw new \Exception('Country API failed');
        }


        $result = $response->json();


        $countries = $result['data'];


        $count = 0;


        foreach ($countries as $item) {


            Country::updateOrCreate(

                [
                    'country_name'
                    =>
                    $item['name']
                    ?? null
                ],


                [
                    'country_code'
                    =>
                    strtoupper(
                        substr(
                            md5($item['name']),
                            0,
                            5
                        )
                    ),


                    'currency'
                    =>
                    $item['currency']
                    ?? null,


                    'flag'
                    =>
                    $item['flag']
                    ?? null,


                    'last_synced'
                    =>
                    now()

                ]

            );


            $count++;
        }


        return $count;
    }
}
