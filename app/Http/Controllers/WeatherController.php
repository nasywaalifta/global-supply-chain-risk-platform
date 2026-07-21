<?php

namespace App\Http\Controllers;

use App\Models\Weather;

use App\Models\Country;

class WeatherController extends Controller
{
    public function index()
    {
        $weather = Weather::with('port.country')
            ->join('ports', 'weather.port_id', '=', 'ports.id')
            ->join('countries', 'ports.country_id', '=', 'countries.id')
            ->select('weather.*')
            ->orderBy('countries.name', 'asc')
            ->paginate(20);

        $mapWeather = Country::with('ports.weather')
            ->whereHas('ports.weather')
            ->orderBy('name', 'asc')
            ->get();

        $avgTemperature = round(Weather::avg('temperature') ?? 0, 1);
        $avgRain = round(Weather::avg('precipitation') ?? 0, 1);
        $maxWind = round(Weather::max('wind_speed') ?? 0, 1);
        $highRisk = Weather::where('storm_risk', 'Tinggi')->count();

        return view('weather.index', compact(
            'weather',
            'mapWeather',
            'avgTemperature',
            'avgRain',
            'maxWind',
            'highRisk'
        ));
    }

}