<?php

namespace App\Http\Controllers;

use App\Models\Weather;

class WeatherController extends Controller
{
    public function index()
    {
        $weather = Weather::with('port.country')
            ->latest('last_update')
            ->paginate(20);

        return view('weather.index', compact('weather'));
    }
}