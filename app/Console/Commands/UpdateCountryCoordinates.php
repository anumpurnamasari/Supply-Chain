<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Country;

class UpdateCountryCoordinates extends Command
{
    protected $signature = 'countries:update-coordinates';
    protected $description = 'Update latitude dan longitude semua negara';

    public function handle()
    {
        $response = Http::get('https://restcountries.com/v3.1/all');

        if (!$response->successful()) {
            $this->error('Gagal mengambil data dari REST Countries.');
            return;
        }

        $countries = $response->json();
        dd($countries[0]);

        $updated = 0;

        foreach ($countries as $item) {

            if (!isset($item['cca3']) || !isset($item['latlng'])) {
                continue;
            }

            $country = Country::where('country_code', $item['cca3'])->first();

            if ($country) {
                $country->update([
                    'latitude' => $item['latlng'][0] ?? null,
                    'longitude' => $item['latlng'][1] ?? null,
                ]);

                $updated++;
            }
        }

        $this->info("Berhasil mengupdate {$updated} negara.");
    }
}
