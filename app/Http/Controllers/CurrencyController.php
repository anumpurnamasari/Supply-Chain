<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\CurrencyRate;
use App\Services\CurrencyService;

class CurrencyController extends Controller
{
    public function index(
        Request $request,
        CurrencyService $service
    )
    {
        $country = Country::find($request->country_id);

        if (!$country) {
            $country = Country::where('code', 'ID')->first();
        }

        if ($country) {
            $service->syncCurrency($country);
        }

        $currency = CurrencyRate::where(
            'country_id',
            $country->id
        )->latest()->first();

        return view(
            'pages.currency',
            compact(
                'country',
                'currency'
            )
        );
    }
}
