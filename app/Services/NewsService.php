<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;


class NewsService
{


    public function getNews($countryName)
    {
    $queries = [

        "$countryName economy",

        "$countryName trade",

        "$countryName shipping",

        "$countryName logistics"

    ];

    foreach ($queries as $query) {

        $response = Http::get(
            "https://gnews.io/api/v4/search",
            [

                "q" => $query,

                "lang" => "en",

                "max" => 10,

                "apikey" => env("GNEWS_API_KEY")

            ]
        );

        $json = $response->json();

        if (!empty($json['articles'])) {

            return $json;

        }

    }

    return [

        "articles" => []

    ];
    }


}
