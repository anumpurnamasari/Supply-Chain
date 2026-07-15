<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CountryService
{
    public function syncCountries($offset = 0)
    {
        $response = Http::withToken(env('RESTCOUNTRIES_API_KEY'))
            ->get('https://api.restcountries.com/countries/v5', [

                'limit' => 100,

                'offset' => $offset,

                'pretty' => 1

            ]);

        if (!$response->successful()) {

            return [

                'success' => false,

                'message' => $response->body()

            ];

        }

        return [

            'success' => true,

            'data' => $response->json()

        ];

    }
}
