<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/countries.json');

        if (!file_exists($path)) {
            $this->command->error('countries.json tidak ditemukan.');
            return;
        }

        $countries = json_decode(file_get_contents($path), true);

        foreach ($countries as $item) {

            $currencyCode = null;
            $currencySymbol = null;

            if (!empty($item['currencies'])) {
                $currencyCode = array_key_first($item['currencies']);
                $currencySymbol = $item['currencies'][$currencyCode]['symbol'] ?? null;
            }

            Country::updateOrCreate(
                [
                    'country_code' => $item['cca3'],
                ],
                [
                    'country_name'    => $item['name']['common'] ?? null,
                    'capital'         => $item['capital'][0] ?? null,
                    'region'          => $item['region'] ?? null,
                    'currency'        => $currencyCode,
                    'currency_symbol' => $currencySymbol,
                    'population'      => $item['population'] ?? null,
                    'latitude'        => $item['latlng'][0] ?? null,
                    'longitude'       => $item['latlng'][1] ?? null,
                    'flag'            => $item['flags']['png'] ?? null,
                    'last_synced'     => now(),
                ]
            );
        }

        $this->command->info('Countries berhasil diimport.');
    }
}
