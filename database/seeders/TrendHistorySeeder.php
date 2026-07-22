<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EconomicData;
use App\Models\CurrencyRate;
use App\Models\RiskScore;
use Carbon\Carbon;

class TrendHistorySeeder extends Seeder
{
    public function run(): void
    {
        foreach (EconomicData::all() as $economic) {

            for ($i = 10; $i >= 1; $i--) {

                $date = Carbon::now()->subDays($i);

                EconomicData::create([
                    'country_id'    => $economic->country_id,
                    'gdp'           => $economic->gdp * (1 - rand(-2,2)/100),
                    'inflation'     => max(0, $economic->inflation + rand(-20,20)/100),
                    'population'    => $economic->population,
                    'exports'       => $economic->exports * (1 - rand(-3,3)/100),
                    'imports'       => $economic->imports * (1 - rand(-3,3)/100),
                    'economic_risk' => $economic->economic_risk,
                    'created_at'    => $date,
                    'updated_at'    => $date,
                ]);
            }
        }

        foreach (CurrencyRate::all() as $currency) {

            for ($i = 10; $i >= 1; $i--) {

                $date = Carbon::now()->subDays($i);

                CurrencyRate::create([
                    'country_id'     => $currency->country_id,
                    'currency'       => $currency->currency,
                    'exchange_rate'  => $currency->exchange_rate * (1 - rand(-2,2)/100),
                    'currency_risk'  => $currency->currency_risk,
                    'created_at'     => $date,
                    'updated_at'     => $date,
                ]);
            }
        }

        foreach (RiskScore::all() as $risk) {

            for ($i = 10; $i >= 1; $i--) {

                $date = Carbon::now()->subDays($i);

                RiskScore::create([
                    'country_id'       => $risk->country_id,
                    'weather_score'    => max(0,min(100,$risk->weather_score+rand(-5,5))),
                    'inflation_score'  => max(0,min(100,$risk->inflation_score+rand(-5,5))),
                    'currency_score'   => max(0,min(100,$risk->currency_score+rand(-5,5))),
                    'news_score'       => max(0,min(100,$risk->news_score+rand(-5,5))),
                    'total_score'      => max(0,min(100,$risk->total_score+rand(-5,5))),
                    'risk_level'       => $risk->risk_level,
                    'created_at'       => $date,
                    'updated_at'       => $date,
                ]);
            }
        }
    }
}
