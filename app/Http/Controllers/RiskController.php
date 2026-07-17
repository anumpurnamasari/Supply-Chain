<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;

class RiskController extends Controller
{
    public function index()
    {
        $country = Country::find(
            session('active_country')
        );

        if (!$country) {

            $country = Country::where(
                'code',
                'ID'
            )->first();

        }

        $risk = RiskScore::where(
            'country_id',
            $country->id
        )->latest()->first();

        // TOP 5 HIGHEST RISK
        $topRisks = RiskScore::with('country')
            ->orderByDesc('total_score')
            ->take(5)
            ->get();

        return view(
            'pages.risk',
            compact(
                'country',
                'risk',
                'topRisks'
            )
        );
    }
}
