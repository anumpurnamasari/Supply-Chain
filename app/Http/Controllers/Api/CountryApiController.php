<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;

class CountryApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'total' => Country::count(),
            'data' => Country::orderBy('name')->get()
        ]);
    }
}
