<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function syncCurrency(Country $country)
    {

        $response = Http::get(
            'https://open.er-api.com/v6/latest/USD'
        );

        if (!$response->successful()) {
            return false;
        }

        $rates = $response->json()['rates'];

        $rate = $rates[$country->currency] ?? null;

        if (!$rate) {
            return false;
        }

        $risk = $this->calculateRisk($rate);

        CurrencyRate::updateOrCreate(

            [
                'country_id' => $country->id
            ],

            [

                'currency' => $country->currency,

                'exchange_rate' => $rate,

                'currency_risk' => $risk

            ]

        );

        return true;

    }

    private function calculateRisk($rate)
    {

        if ($rate < 0.5) {
            return 80;
        }

        if ($rate < 1) {
            return 50;
        }

        return 20;

    }
}
