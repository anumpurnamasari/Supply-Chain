<?php

namespace App\Http\Controllers;

use App\Models\CurrencyRate;

class CurrencyController extends Controller
{
    public function index()
    {
        $currency = CurrencyRate::latest()->first();

        return view(
            'pages.currency',
            compact('currency')
        );
    }
}
