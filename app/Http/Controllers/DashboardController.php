<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\GNews;
use App\Models\Watchlist;
use App\Models\WeatherData;
use App\Models\ExchangeRate;
use App\Models\RiskScore;

class DashboardController extends Controller
{
    public function index()
    {
        // ==========================
        // Data Negara
        // ==========================
        $countries = Country::orderBy('name')->get();

        // ==========================
        // Statistik Risiko
        // ==========================
        $highRisk = RiskScore::where('risk_level', 'High')->count();

        $mediumRisk = RiskScore::where('risk_level', 'Medium')->count();

        $lowRisk = RiskScore::where('risk_level', 'Low')->count();

        // ==========================
        // Currency Trend
        // ==========================
        $currencyTrend = ExchangeRate::whereIn('code', [
            'USD',
            'EUR',
            'GBP',
            'JPY',
            'SGD',
            'MYR',
            'CNY',
            'AUD',
            'CAD',
            'IDR',
        ])->orderBy('code')->get();

        // ==========================
        // Data Map
        // ==========================
        $weatherMap = WeatherData::with('country')->get();

        // ==========================
        // Berita Terbaru
        // ==========================
        $latestNews = GNews::latest()->take(5)->get();

        return view('dashboard.index', [

            /*
            |--------------------------------------------------------------------------
            | Statistik Dashboard
            |--------------------------------------------------------------------------
            */

            'countries'       => $countries,

            'totalCountries'  => Country::count(),

            'totalPorts'      => Port::count(),

            'totalNews'       => GNews::count(),

            'totalWatchlist'  => Watchlist::count(),

            /*
            |--------------------------------------------------------------------------
            | Ringkasan Risiko
            |--------------------------------------------------------------------------
            */

            'highRisk'        => $highRisk,

            'mediumRisk'      => $mediumRisk,

            'lowRisk'         => $lowRisk,

            /*
            |--------------------------------------------------------------------------
            | Risk Trend
            |--------------------------------------------------------------------------
            */

            'riskChartLabels' => [
                'Risiko Tinggi',
                'Risiko Sedang',
                'Risiko Rendah'
            ],

            'riskChartData' => [
                $highRisk,
                $mediumRisk,
                $lowRisk,
            ],

            /*
            |--------------------------------------------------------------------------
            | Currency Trend
            |--------------------------------------------------------------------------
            */

            'currencyLabels' => $currencyTrend->pluck('code'),

            'currencyRates' => $currencyTrend->pluck('rate'),

            /*
            |--------------------------------------------------------------------------
            | World Risk Map
            |--------------------------------------------------------------------------
            */

            'weatherMap' => $weatherMap,

            /*
            |--------------------------------------------------------------------------
            | News Intelligence
            |--------------------------------------------------------------------------
            */

            'latestNews' => $latestNews,

        ]);
    }
}