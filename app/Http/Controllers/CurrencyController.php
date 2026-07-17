<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CurrencyService;
use App\Models\Country;
use App\Models\CurrencyRate;
use App\Models\EconomicData;

class CurrencyController extends Controller
{
    public function index()
    {
        // ======================
        // ACTIVE COUNTRY
        // ======================

        $country = Country::find(
            session('active_country')
        );

        if (!$country) {

            $country = Country::where(
                'code',
                'ID'
            )->first();

        }

        // ======================
        // CURRENCY
        // ======================

        $currency = CurrencyRate::where(
            'country_id',
            $country->id
        )
        ->latest()
        ->first();

        // ======================
        // ECONOMIC DATA
        // ======================

        $economic = EconomicData::where(
            'country_id',
            $country->id
        )
        ->latest()
        ->first();

        // ======================
        // RISK SCORE
        // ======================

        return view(
            'pages.currency',
            compact(
                'country',
                'currency',
                'economic',
            )
        );
    }

    public function syncAll(Request $request, CurrencyService $currencyService)
{
    $page = $request->get('page', 1);
    $perPage = 20;

    $countries = Country::skip(($page - 1) * $perPage)
        ->take($perPage)
        ->get();

    foreach ($countries as $country) {
        try {
            $currencyService->syncCurrency($country);
            usleep(300000); // 0.3 detik
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    $totalPages = ceil(Country::count() / $perPage);

    if ($page < $totalPages) {
        return response("
            <h2>Sync Currency</h2>
            <p>Page {$page} selesai.</p>
            <script>
                setTimeout(function(){
                    window.location.href='/currency/sync-all?page=".($page+1)."';
                },500);
            </script>
        ");
    }

    return "
        <h2>✅ Currency Sync Finished</h2>
        <p>Total Country : ".Country::count()."</p>
    ";
}
}
