<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\CountryService;

class CountryController extends Controller
{
    public function sync(CountryService $service)
    {
        $totalSaved = 0;

        // Free plan 100 data per halaman
        foreach ([0, 100, 200] as $offset) {

            $result = $service->syncCountries($offset);

            if (!$result['success']) {

                return response()->json($result);

            }

            $countries = $result['data']['data']['objects'] ?? [];

            foreach ($countries as $item) {

                if (empty($item['names']['common'])) {
                    continue;
                }

                Country::updateOrCreate(

                    [

                        'code' => $item['codes']['alpha_2'] ?? null

                    ],

                    [

                        'name' => $item['names']['common'],

                        'region' => $item['region'] ?? null,

                        'population' => $item['population'] ?? 0,

                        'currency' => $item['currencies'][0]['code'] ?? null,

                        'latitude' => $item['coordinates']['lat'] ?? 0,

                        'longitude' => $item['coordinates']['lng'] ?? 0,

                        'flag' => $item['flag']['url_png'] ?? null,

                    ]

                );

                $totalSaved++;
            }
        }

        return response()->json([

            'success' => true,

            'saved' => $totalSaved,

            'database_total' => Country::count()

        ]);
    }
}
