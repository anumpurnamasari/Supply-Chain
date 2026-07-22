<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    public function index()
    {
    $country = Country::find(
        session('active_country')
    );

    if (!$country) {

        $country = Country::where(
            'code',
            'ID'
        )->first();

    }

    $weather = WeatherData::where(
        'country_id',
        $country->id
    )
    ->latest()
    ->first();

    $risk = RiskScore::where(
        'country_id',
        $country->id
    )
    ->latest()
    ->first();

    // Selected Country Weather
    $selectedWeather = WeatherData::with('country')
        ->where('country_id', $country->id)
        ->latest()
        ->first();

    return view(
        'pages.weather',
        compact(
            'country',
            'weather',
            'risk',
            'selectedWeather'
        )
    );
    }

    public function syncAll(Request $request, WeatherService $weatherService)
    {
    $page = $request->get('page', 1);

    $perPage = 20;

    $countries = Country::skip(
        ($page - 1) * $perPage
    )->take($perPage)->get();

    foreach ($countries as $country) {

        try {

            $weatherService->syncWeather($country);

            usleep(300000);

        } catch (\Exception $e) {
            return $e->getMessage();

        }

    }

    $totalPages = ceil(
        Country::count() / $perPage
    );

    // Kalau masih ada halaman berikutnya
    if ($page < $totalPages) {

        return response("
            <h2>Sync Weather</h2>

            <p>Page {$page} selesai.</p>

            <p>Melanjutkan ke Page ".($page+1)." ...</p>

            <script>

                setTimeout(function(){

                    window.location.href='/weather/sync-all?page=".($page+1)."';

                },500);

            </script>

        ");

    }

    return "

        <h2>

        ✅ Weather Sync Finished

        </h2>

        <p>

        Total Country :

        ".Country::count()."

        </p>

    ";
    }
}
