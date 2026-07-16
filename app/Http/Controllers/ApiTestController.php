<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CurrencyRate;
use App\Models\EconomicData;
use App\Models\NewsCache;
use App\Models\Port;
use App\Models\WeatherData;

use App\Services\CountryService;
use App\Services\WeatherService;
use App\Services\WorldBankService;
use App\Services\CurrencyService;
use App\Services\NewsService;
use App\Services\PortService;

class ApiTestController extends Controller
{
    public function index()
    {
        return view('api-test');
    }

    public function countries(CountryService $service)
    {
        return response()->json(
            $service->syncCountries()
        );
    }

    public function weather(WeatherService $service)
    {
        $country = Country::where('code','ID')->first();

        $service->syncWeather($country);

        return WeatherData::where(
            'country_id',
            $country->id
        )->first();
    }

    public function economic(WorldBankService $service)
    {
        $country = Country::where('code','ID')->first();

        return response()->json(
            $service->getEconomic($country->code)
        );
    }

    public function currency(CurrencyService $service)
    {
        $country = Country::where('code','ID')->first();

        $service->syncCurrency($country);

        return CurrencyRate::where(
            'country_id',
            $country->id
        )->first();
    }

    public function news(NewsService $service)
    {
        return response()->json(
            $service->getNews("Indonesia")
        );
    }

    public function ports(PortService $service)
    {
        $country = Country::where('code','ID')->first();

        $service->syncPorts($country);

        return Port::where(
            'country_id',
            $country->id
        )->get();
    }
}
