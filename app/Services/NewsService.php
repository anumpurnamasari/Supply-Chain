<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
    public function getNews($country)
    {
        $queries = [

            '"' . $country . '" AND (logistics OR shipping OR trade OR economy)',

            '"' . $country . '" economy',

            '"' . $country . '"',

            'global supply chain',

        ];

        foreach ($queries as $keyword) {

            $response = Http::get(
                'https://gnews.io/api/v4/search',
                [
                    'q'       => $keyword,
                    'lang'    => 'en',
                    'max'     => 20,
                    'sortby'  => 'publishedAt',
                    'apikey'  => env('GNEWS_API_KEY')
                ]
            );

            $data = $response->json();

            if (
                isset($data['articles']) &&
                count($data['articles']) > 0
            ) {
                return $data;
            }
        }

        return [
            'articles' => []
        ];
    }
}
