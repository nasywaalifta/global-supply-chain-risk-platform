<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class OpenMeteoService
{
    protected string $baseUrl = 'https://api.open-meteo.com/v1/forecast';

    public function getCurrentWeather($latitude, $longitude)
    {
        $response = Http::retry(3, 1000)
            ->timeout(60)
            ->get($this->baseUrl, [
                'latitude' => $latitude,
                'longitude' => $longitude,

                // Data cuaca saat ini
                'current' => 'temperature_2m,wind_speed_10m,weather_code',

                // Data harian
                'daily' => 'precipitation_sum',

                'timezone' => 'auto'
            ]);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();

        $current = $data['current'] ?? null;
        $daily = $data['daily'] ?? null;

        if (!$current) {
            return null;
        }

        $temperature = $current['temperature_2m'] ?? 0;

        // Mengambil total curah hujan hari ini
        $precipitation = $daily['precipitation_sum'][0] ?? 0;

        $windSpeed = $current['wind_speed_10m'] ?? 0;
        $weatherCode = $current['weather_code'] ?? 0;

        return [
            'temperature'   => $temperature,
            'precipitation' => $precipitation,
            'wind_speed'    => $windSpeed,
            'weather_code'  => $weatherCode,
            'storm_risk'    => $this->calculateStormRisk($windSpeed, $precipitation),
        ];
    }

    /**
     * Menghitung tingkat risiko badai
     */
    private function calculateStormRisk($wind, $rain)
    {
        if ($wind >= 60 || $rain >= 40) {
            return 'Tinggi';
        }

        if ($wind >= 30 || $rain >= 15) {
            return 'Sedang';
        }

        return 'Rendah';
    }
}