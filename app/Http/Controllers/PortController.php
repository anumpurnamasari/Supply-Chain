<?php

namespace App\Http\Controllers;

use App\Models\Port;

class PortController extends Controller
{
    public function index()
    {
        $ports = Port::all();

        return view(
            'pages.ports',
            compact('ports')
        );
    }
}
