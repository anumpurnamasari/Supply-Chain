<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Port;

class PortApiController extends Controller
{
    public function index()
    {
        $ports = Port::with('country')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'total' => $ports->count(),
            'data' => $ports
        ]);
    }
}
