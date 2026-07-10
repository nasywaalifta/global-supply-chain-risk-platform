<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\News;
use App\Models\Weather;
use App\Models\Watchlist;

class DashboardController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view('dashboard.index', [

            // Data Negara
            'countries' => $countries,
            'totalCountries' => Country::count(),

            // Pelabuhan
            'totalPorts' => Port::count(),

            // Berita
            'totalNews' => News::count(),

            // Watchlist
            'totalWatchlist' => Watchlist::count(),

            // Risk Cuaca
            'highRisk' => Weather::where('weather_risk', '>=', 70)->count(),

            'mediumRisk' => Weather::whereBetween('weather_risk', [40, 69])->count(),

            'lowRisk' => Weather::where('weather_risk', '<', 40)->count(),

        ]);
    }
}