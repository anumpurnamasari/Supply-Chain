<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Services\PortImportService;

class PortController extends Controller
{

    // ======================================
    // PORT DASHBOARD
    // ======================================

    public function index()
{
    $ports = Port::with('country')
        ->orderBy('name')
        ->get();

    $countries = Country::orderBy('name')->get();

    $totalPorts = $ports->count();

    return view(
        'pages.ports',
        compact(
            'ports',
            'countries',
            'totalPorts'
        )
    );
}


    // ======================================
    // IMPORT DATASET
    // ======================================

    public function import(
        PortImportService $service
    )
    {

        return response()->json(
            $service->import()
        );

    }

}
