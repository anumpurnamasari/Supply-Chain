<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WorldBankService
{
    public function getEconomic($countryCode)
    {
        return [

            'gdp'        => $this->getIndicator($countryCode, 'NY.GDP.MKTP.CD'),

            'inflation'  => $this->getIndicator($countryCode, 'FP.CPI.TOTL.ZG'),

            'population' => $this->getIndicator($countryCode, 'SP.POP.TOTL'),

            'exports'    => $this->getIndicator($countryCode, 'NE.EXP.GNFS.CD'),

            'imports'    => $this->getIndicator($countryCode, 'NE.IMP.GNFS.CD'),

        ];
    }

    private function getIndicator($countryCode, $indicator)
    {
        $response = Http::timeout(15)->get(
            "https://api.worldbank.org/v2/country/{$countryCode}/indicator/{$indicator}",
            [
                'format' => 'json',
                'per_page' => 1
            ]
        );

        if (!$response->successful()) {
            return 0;
        }

        $json = $response->json();

        if (
            isset($json[1]) &&
            isset($json[1][0]) &&
            isset($json[1][0]['value'])
        ) {

            return $json[1][0]['value'] ?? 0;

        }

        return 0;
    }
}
