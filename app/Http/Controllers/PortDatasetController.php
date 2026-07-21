<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Port;
use App\Services\PortImportService;
use Illuminate\Http\Request;

class PortDatasetController extends Controller
{
    public function index()
    {
        $ports = Port::with('country')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.ports.index', compact('ports'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('admin.ports.create', compact('countries'));
    }

    public function store(Request $request)
    {
        Port::create($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success','Port created.');
    }

    public function edit(Port $port)
    {
        $countries = Country::orderBy('name')->get();

        return view(
            'admin.ports.edit',
            compact('port','countries')
        );
    }

    public function update(Request $request, Port $port)
    {
        $port->update($request->all());

        return redirect()
            ->route('ports.index')
            ->with('success','Port updated.');
    }

    public function destroy(Port $port)
    {
        $port->delete();

        return back()->with('success','Port deleted.');
    }

    public function import(PortImportService $service)
    {
        $service->import();

        return back()->with('success','Dataset imported successfully.');
    }
}
