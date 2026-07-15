<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\EconomicData;
use App\Services\WorldBankService;

class EconomicController extends Controller
{
    public function sync(Request $request, WorldBankService $service)
    {
        $country = Country::find($request->country_id);

        if (!$country) {
            return response()->json([
                'success' => false,
                'message' => 'Country not found'
            ], 404);
        }

        $data = $service->getEconomic($country->code);

        $risk = 20;

        if (($data['inflation'] ?? 0) > 10) {
            $risk += 40;
        }

        if (($data['gdp'] ?? 0) < 100000000000) {
            $risk += 20;
        }

        if (($data['exports'] ?? 0) < ($data['imports'] ?? 0)) {
            $risk += 20;
        }

        $risk = min($risk, 100);

        $economic = EconomicData::updateOrCreate(

            [
                'country_id' => $country->id
            ],

            [
                'gdp' => $data['gdp'],
                'inflation' => $data['inflation'],
                'population' => $data['population'],
                'exports' => $data['exports'],
                'imports' => $data['imports'],
                'economic_risk' => $risk
            ]

        );

        return response()->json([

            'success' => true,

            'country' => $country->name,

            'data' => $economic

        ]);
    }
}
