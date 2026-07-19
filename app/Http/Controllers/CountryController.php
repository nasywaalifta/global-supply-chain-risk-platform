<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $countries = Country::with(['riskScore', 'weather', 'ports'])
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('cca3', 'like', "%{$search}%")
                      ->orWhere('region', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('countries.index', compact('countries', 'search'));
    }

    public function show(Country $country)
    {
        // Hitung jumlah pelabuhan pada negara ini
        $totalPorts = Port::where('country_id', $country->id)->count();

        return view('countries.show', compact(
            'country',
            'totalPorts'
        ));
    }
}