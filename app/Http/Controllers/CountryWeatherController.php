<?php

namespace App\Http\Controllers;

use App\Models\WeatherData;

class CountryWeatherController extends Controller
{
    public function index()
{
    $query = WeatherData::with('country');

    // Search negara
    if (request('search')) {
        $query->whereHas('country', function ($q) {
            $q->where('name', 'like', '%' . request('search') . '%');
        });
    }

    // Filter risiko
    if (request('risk')) {
        $query->where('storm_risk', request('risk'));
    }

    $weather = $query
    ->join('countries', 'weather_data.country_id', '=', 'countries.id')
    ->orderBy('countries.name')
    ->select('weather_data.*')
    ->paginate(20)
    ->withQueryString();

    $avgTemperature = round(WeatherData::avg('temperature'), 1);
    $avgRain = round(WeatherData::avg('precipitation'), 1);
    $maxWind = round(WeatherData::max('wind_speed'), 1);
    $highRisk = WeatherData::where('storm_risk', 'Tinggi')->count();

    return view('weather.index', compact(
        'weather',
        'avgTemperature',
        'avgRain',
        'maxWind',
        'highRisk'
    ));
}
}