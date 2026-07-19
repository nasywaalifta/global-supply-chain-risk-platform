<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class PortController extends Controller
{
    /**
     * Menampilkan halaman pelabuhan
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
                    ->orWhereHas('country', function ($countryQuery) use ($search) {

                        $countryQuery->where('name', 'like', "%{$search}%");

                    });

                });

            })

            ->orderBy('name')

            ->paginate(10)

            ->withQueryString();

        // Statistik
        $totalPorts = Port::count();

        $lowCount = Port::where('congestion_level', 'Low')->count();

        $mediumCount = Port::where('congestion_level', 'Medium')->count();

        $highCount = Port::where('congestion_level', 'High')->count();

        // Data untuk Leaflet
        $mapPorts = Port::with('country')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $countries = Country::orderBy('name')->get();

        return view('ports.index', compact(

            'ports',
            'search',
            'country',
            'countries',

            'totalPorts',
            'lowCount',
            'mediumCount',
            'highCount',

            'mapPorts'

        ));
    }

    public function sync()
    {
        Artisan::call('ports:fetch');

        return redirect()
            ->route('ports.index')
            ->with('success', 'Data pelabuhan berhasil disinkronisasi.');
    }
}