<?php

namespace App\Http\Controllers;


use App\Services\CountryService;


class CountryController extends Controller
{

    public function sync(
        CountryService $service
    )
    {

        $total = $service->syncCountries();

        return "Synced ".$total." countries";

    }

}
