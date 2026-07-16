<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
    public function getNews($country)
    {
        $keyword = '"' . $country . '" logistics trade shipping economy';

        $response = Http::get(

            'https://gnews.io/api/v4/search',

            [

                'q' => $keyword,

                'lang' => 'en',

                'max' => 10,

                'sortby' => 'publishedAt',

                'apikey' => env('GNEWS_API_KEY')

            ]

        );

        return $response->json();
    }
}
