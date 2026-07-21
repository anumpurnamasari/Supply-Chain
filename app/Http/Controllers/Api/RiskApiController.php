<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\RiskScore;

class RiskApiController extends Controller
{
    public function index()
    {
        $risk = RiskScore::with('country')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'total' => $risk->count(),
            'data' => $risk
        ]);
    }
}
