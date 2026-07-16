<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Port;
use App\Services\PortService;
use App\Services\PortImportService;

class PortController extends Controller
{
    public function index(
        Request $request,
        PortService $service
    )
    {

        $country = Country::find($request->country_id);

        if (!$country) {

            $country = Country::where(
                'code',
                'ID'
            )->first();

        }

        $service->syncPorts($country);

        $ports = Port::where(
            'country_id',
            $country->id
        )->get();

        return view(
            'pages.ports',
            compact(
                'country',
                'ports'
            )
        );

    }

    public function import(PortImportService $service)
{
    return response()->json(
        $service->import()
    );
}
}
