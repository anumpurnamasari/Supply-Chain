<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CurrencyRate;

class CurrencyApiController extends Controller
{
    public function index()
    {
        $currency = CurrencyRate::with('country')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'total' => $currency->count(),
            'data' => $currency
        ]);
    }
}
