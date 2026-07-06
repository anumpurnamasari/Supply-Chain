<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Services\CountryService;


class CountryController extends Controller
{


    public function sync(
        CountryService $service
    )
    {


        $result =
        $service->getCountry(
            "Indonesia"
        );



        if(
            $result['error'] == true
        ){

            return $result;

        }



        $data =
        $result['data'];



        Country::updateOrCreate(

            [
                'name' =>
                $data['country']
            ],


            [

                'code' =>
                "ID",


                'region' =>
                "Asia",


                'population' =>
                end(
                    $data['populationCounts']
                )
                ['value'],


                'currency' =>
                "IDR",


                'latitude' =>
                -6.200000,


                'longitude' =>
                106.816666,


                'flag'=>
                "https://flagcdn.com/w320/id.png"


            ]

        );




        return
        "Country API berhasil disimpan";


    }


}
