<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PortManagementController extends Controller
{
    /**
     * Display a listing of the ports.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $country = $request->country;

        $ports = Port::with('country')
            ->when($country, function ($query) use ($country) {
                $query->where('country_id', $country);
            })
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        $countries = Country::orderBy('name')->get();

        return view('admin.ports.index', compact('ports', 'countries', 'search', 'country'));
    }

    /**
     * Show the form for creating a new port.
     */
    public function create()
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.ports.create', compact('countries'));
    }

    /**
     * Store a newly created port in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'risk_score' => 'required|integer|min:0|max:100',
            'congestion_score' => 'required|integer|min:0|max:100',
            'congestion_level' => 'required|in:Low,Medium,High',
        ]);

        Port::create($request->all());

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Pelabuhan berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified port.
     */
    public function edit(Port $port)
    {
        $countries = Country::orderBy('name')->get();
        return view('admin.ports.edit', compact('port', 'countries'));
    }

    /**
     * Update the specified port in storage.
     */
    public function update(Request $request, Port $port)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'type' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'risk_score' => 'required|integer|min:0|max:100',
            'congestion_score' => 'required|integer|min:0|max:100',
            'congestion_level' => 'required|in:Low,Medium,High',
        ]);

        $port->update($request->all());

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Pelabuhan berhasil diperbarui.');
    }

    /**
     * Remove the specified port from storage.
     */
    public function destroy(Port $port)
    {
        $port->delete();

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Pelabuhan berhasil dihapus.');
    }

    /**
     * Synchronize ports dataset using command.
     */
    public function sync()
    {
        Artisan::call('ports:fetch');

        return redirect()
            ->route('admin.ports.index')
            ->with('success', 'Data pelabuhan berhasil disinkronisasi.');
    }
}
