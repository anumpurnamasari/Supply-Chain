<?php

namespace App\Services;

use App\Models\WeatherData;
use App\Models\EconomicData;
use App\Models\CurrencyRate;
use App\Models\NewsCache;
use App\Models\RiskScore;
use App\Models\Country;

class RiskCalculatorService
{
    public function calculate($countryId)
    {
        // ==========================
        // GET DATA
        // ==========================

        $weather = WeatherData::where(
            'country_id',
            $countryId
        )->latest()->first();

        $economic = EconomicData::where(
            'country_id',
            $countryId
        )->latest()->first();

        $currency = CurrencyRate::where(
            'country_id',
            $countryId
        )->latest()->first();

        $news = NewsCache::where(
            'country_id',
            $countryId
        )->get();

        // ==========================
        // WEATHER SCORE (30%)
        // ==========================

        $weatherScore = 0;

        if ($weather) {

            // Rain

            if ($weather->rainfall >= 50) {

                $weatherScore += 40;

            } elseif ($weather->rainfall >= 20) {

                $weatherScore += 25;

            } else {

                $weatherScore += 10;

            }

            // Wind

            if ($weather->wind_speed >= 60) {

                $weatherScore += 40;

            } elseif ($weather->wind_speed >= 30) {

                $weatherScore += 25;

            } else {

                $weatherScore += 10;

            }

            // Storm

            $weatherScore += min(
                $weather->storm_risk,
                20
            );

        }

        $weatherScore = min(
            $weatherScore,
            100
        );

        // ==========================
        // INFLATION SCORE (20%)
        // ==========================

        $inflationScore = 0;

        if ($economic) {

            $inflation = $economic->inflation;

            if ($inflation <= 3) {

                $inflationScore = 20;

            } elseif ($inflation <= 6) {

                $inflationScore = 50;

            } elseif ($inflation <= 10) {

                $inflationScore = 75;

            } else {

                $inflationScore = 100;

            }

        }

        // ==========================
        // CURRENCY SCORE (10%)
        // ==========================

        $currencyScore = 0;

        if ($currency) {

            $currencyScore = min(
                $currency->currency_risk,
                100
            );

        }

        // ==========================
        // NEWS SCORE (40%)
        // ==========================

        $negative = $news
            ->where('sentiment', 'Negative')
            ->count();

        $totalNews = $news->count();

        if ($totalNews == 0) {

            $newsScore = 0;

        } else {

            $newsScore = round(
                ($negative / $totalNews) * 100
            );

        }

        // ==========================
        // WEIGHTED RISK MODEL
        // ==========================

        $total =

            ($weatherScore * 0.30)

            +

            ($inflationScore * 0.20)

            +

            ($currencyScore * 0.10)

            +

            ($newsScore * 0.40);

        // ==========================
        // RISK LEVEL
        // ==========================

        if ($total < 30) {

            $level = 'LOW';

        } elseif ($total < 60) {

            $level = 'MEDIUM';

        } else {

            $level = 'HIGH';

        }

        // ==========================
        // SAVE DATABASE
        // ==========================

        return RiskScore::create([

            'country_id'      => $countryId,

            'weather_score'   => round($weatherScore),

            'inflation_score' => round($inflationScore),

            'currency_score'  => round($currencyScore),

            'news_score'      => round($newsScore),

            'total_score'     => round($total),

            'risk_level'      => $level

        ]);
    }

    public function calculateAll()
{
    foreach (Country::all() as $country) {
        $this->calculate($country->id);
    }

    return [
        'success' => true,
        'message' => 'Risk score berhasil dihitung',
        'total_country' => Country::count()
    ];
}
}
