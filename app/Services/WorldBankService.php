<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use App\Models\EconomicData;
use App\Models\Country;

class WorldBankService
{
    public function getEconomic($countryCode)
    {
        return Cache::remember(
            "worldbank_{$countryCode}",
            now()->addDay(),
            function () use ($countryCode) {

                try {

                    $responses = Http::pool(fn ($pool) => [

                        'gdp' => $pool->connectTimeout(3)
                            ->timeout(8)
                            ->get(
                                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/NY.GDP.MKTP.CD",
                                [
                                    'format' => 'json',
                                    'per_page' => 1,
                                ]
                            ),

                        'inflation' => $pool->connectTimeout(3)
                            ->timeout(8)
                            ->get(
                                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/FP.CPI.TOTL.ZG",
                                [
                                    'format' => 'json',
                                    'per_page' => 1,
                                ]
                            ),

                        'population' => $pool->connectTimeout(3)
                            ->timeout(8)
                            ->get(
                                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/SP.POP.TOTL",
                                [
                                    'format' => 'json',
                                    'per_page' => 1,
                                ]
                            ),

                        'exports' => $pool->connectTimeout(3)
                            ->timeout(8)
                            ->get(
                                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/NE.EXP.GNFS.CD",
                                [
                                    'format' => 'json',
                                    'per_page' => 1,
                                ]
                            ),

                        'imports' => $pool->connectTimeout(3)
                            ->timeout(8)
                            ->get(
                                "https://api.worldbank.org/v2/country/{$countryCode}/indicator/NE.IMP.GNFS.CD",
                                [
                                    'format' => 'json',
                                    'per_page' => 1,
                                ]
                            ),

                    ]);

                    return [
                        'gdp'        => $this->extractValue($responses['gdp']),
                        'inflation'  => $this->extractValue($responses['inflation']),
                        'population' => $this->extractValue($responses['population']),
                        'exports'    => $this->extractValue($responses['exports']),
                        'imports'    => $this->extractValue($responses['imports']),
                    ];

                } catch (\Throwable $e) {

                    logger()->warning('WorldBank API Error: ' . $e->getMessage());

                    return [
                        'gdp' => 0,
                        'inflation' => 0,
                        'population' => 0,
                        'exports' => 0,
                        'imports' => 0,
                    ];
                }
            }
        );
    }

    private function extractValue($response)
    {
        if (!$response || !$response->successful()) {
            return 0;
        }

        $json = $response->json();

        return $json[1][0]['value'] ?? 0;
    }
}
