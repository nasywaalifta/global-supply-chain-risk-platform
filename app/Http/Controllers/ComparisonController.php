<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\Weather;
use App\Models\ExchangeRate;
use App\Models\GNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ComparisonController extends Controller
{
    /**
     * Display the comparison page.
     */
    public function index(Request $request)
    {
        $countries = Country::orderBy('name')->get();
        
        $country1Id = $request->country1_id;
        $country2Id = $request->country2_id;
        
        $comparison = null;

        if ($country1Id && $country2Id) {
            $c1 = Country::find($country1Id);
            $c2 = Country::find($country2Id);

            if ($c1 && $c2) {
                $comparison = [
                    'c1' => $this->getCountryComparisonData($c1),
                    'c2' => $this->getCountryComparisonData($c2),
                ];
            }
        }

        return view('comparison.index', compact('countries', 'comparison', 'country1Id', 'country2Id'));
    }

    /**
     * Helper to get comparison parameters for a country.
     */
    private function getCountryComparisonData(Country $country)
    {
        // 1. Fetch Weather
        $weatherCacheKey = "country_weather_" . $country->id;
        $weatherInfo = Cache::remember($weatherCacheKey, 3600, function () use ($country) {
            try {
                $lat = $country->latitude ?? 0;
                $lng = $country->longitude ?? 0;
                $response = Http::timeout(5)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => $lat,
                    'longitude' => $lng,
                    'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m'
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return [
                        'temp' => round($data['current']['temperature_2m'] ?? 24),
                        'wind_speed' => $data['current']['wind_speed_10m'] ?? 10,
                    ];
                }
            } catch (\Exception $e) {
                logger()->error('Comparison weather fetch failed: ' . $e->getMessage());
            }
            return ['temp' => 24, 'wind_speed' => 10];
        });

        // 2. Fetch Inflation
        $inflationCacheKey = "country_inflation_" . $country->cca3;
        $inflation = Cache::remember($inflationCacheKey, 86400, function () use ($country) {
            try {
                $response = Http::timeout(5)->get("https://api.worldbank.org/v2/country/{$country->cca3}/indicator/FP.CPI.TOTL.ZG?format=json&mrnev=1");
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data[1][0]['value'])) {
                        return round($data[1][0]['value'], 1);
                    }
                }
            } catch (\Exception $e) {
                logger()->error('Comparison inflation fetch failed: ' . $e->getMessage());
            }
            if ($country->cca3 === 'IDN') return 1.9;
            if ($country->cca3 === 'DEU') return 2.2;
            if ($country->cca3 === 'CHN') return 0.7;
            return 2.5;
        });

        // 3. Fetch GDP
        $gdpCacheKey = "country_gdp_" . $country->cca3;
        $gdp = Cache::remember($gdpCacheKey, 86400, function () use ($country) {
            try {
                $response = Http::timeout(5)->get("https://api.worldbank.org/v2/country/{$country->cca3}/indicator/NY.GDP.MKTP.CD?format=json&mrnev=1");
                if ($response->successful()) {
                    $data = $response->json();
                    if (isset($data[1][0]['value'])) {
                        return $data[1][0]['value'];
                    }
                }
            } catch (\Exception $e) {
                logger()->error('Comparison GDP fetch failed: ' . $e->getMessage());
            }
            if ($country->cca3 === 'IDN') return 1319000000000;
            if ($country->cca3 === 'DEU') return 4072000000000;
            if ($country->cca3 === 'CHN') return 17960000000000;
            return 50000000000; // generic fallback
        });

        // 4. Calculate Risk
        $portIds = Port::where('country_id', $country->id)->pluck('id');
        $avgPortWeatherRisk = Weather::whereIn('port_id', $portIds)->avg('weather_risk');
        $weatherRisk = $avgPortWeatherRisk ?: (($weatherInfo['wind_speed'] > 20 || $weatherInfo['temp'] > 32) ? 60 : 20);

        if ($inflation < 2) {
            $inflationRisk = 15;
        } elseif ($inflation < 4) {
            $inflationRisk = 30;
        } elseif ($inflation < 8) {
            $inflationRisk = 65;
        } else {
            $inflationRisk = 90;
        }

        $currencyCode = $country->currency_code;
        $rate = ExchangeRate::where('code', $currencyCode)->first();
        if ($currencyCode === 'USD') {
            $currencyRisk = 0;
        } elseif (in_array($currencyCode, ['EUR', 'GBP', 'AUD', 'SGD'])) {
            $currencyRisk = 15;
        } else {
            $currencyRisk = 40;
        }

        $newsQuery = GNews::where('title', 'like', "%{$country->name}%")
            ->orWhere('description', 'like', "%{$country->name}%")
            ->get();
        $negCount = 0;
        $posCount = 0;
        foreach ($newsQuery as $news) {
            if ($news->sentiment === 'Negative') $negCount++;
            if ($news->sentiment === 'Positive') $posCount++;
        }
        if ($newsQuery->count() > 0) {
            $newsSentimentRisk = ($negCount + 1) / ($negCount + $posCount + 2) * 100;
        } else {
            if ($country->cca3 === 'IDN') {
                $newsSentimentRisk = 72.5;
            } else {
                $newsSentimentRisk = 35;
            }
        }

        $totalRiskScore = round(
            ($weatherRisk * 0.3) + 
            ($inflationRisk * 0.2) + 
            ($currencyRisk * 0.1) + 
            ($newsSentimentRisk * 0.4)
        );

        if ($totalRiskScore <= 35) {
            $riskLevel = 'Low Risk';
            $riskClass = 'success';
        } elseif ($totalRiskScore <= 65) {
            $riskLevel = 'Medium Risk';
            $riskClass = 'warning text-dark';
        } else {
            $riskLevel = 'High Risk';
            $riskClass = 'danger';
        }

        // Exchange rate info
        $exRate = $rate ? $rate->rate : 1.0;

        return [
            'name' => $country->name,
            'cca2' => $country->cca2,
            'cca3' => $country->cca3,
            'flag_png' => $country->flag_png,
            'gdp' => $gdp,
            'inflation' => $inflation,
            'currency_code' => $currencyCode,
            'currency_rate' => $exRate,
            'temp' => $weatherInfo['temp'],
            'risk_score' => $totalRiskScore,
            'risk_level' => $riskLevel,
            'risk_class' => $riskClass,
        ];
    }

    /**
     * Handle compare form submission (redirect with query parameters).
     */
    public function compare(Request $request)
    {
        $request->validate([
            'country1_id' => 'required|exists:countries,id',
            'country2_id' => 'required|exists:countries,id|different:country1_id',
        ]);

        return redirect()->route('comparison.index', [
            'country1_id' => $request->country1_id,
            'country2_id' => $request->country2_id,
        ]);
    }
}
