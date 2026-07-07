<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;


class NewsService
{


    public function getNews($keyword)
    {


        $response =
        Http::get(
            "https://gnews.io/api/v4/search",
            [

                "q" =>
                $keyword,


                "lang" =>
                "en",


                "country" =>
                "us",


                "max" =>
                10,


                "apikey" =>
                env("GNEWS_API_KEY")


            ]
        );



        return
        $response->json();


    }


}
