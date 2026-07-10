<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getWeather($latitude, $longitude)
    {
        try {

            $response = Http::timeout(20)
                ->retry(3, 1000)
                ->acceptJson()
                ->get(
                    'https://api.open-meteo.com/v1/forecast',
                    [
                        'latitude' => $latitude,
                        'longitude' => $longitude,
                        'current' => 'temperature_2m,relative_humidity_2m,wind_speed_10m,weather_code',
                    ]
                );

            if (! $response->successful()) {
                return null;
            }

            $current = $response->json()['current'] ?? null;

            if (! $current) {
                return null;
            }

            $current['condition'] = $this->weatherCondition(
                $current['weather_code']
            );

            return $current;

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            return null;

        }
    }

    /**
     * Konversi Weather Code Open-Meteo menjadi teks.
     */
    private function weatherCondition(int $code): string
    {
        return match ($code) {

            0 => '☀ Clear Sky',

            1 => '🌤 Mostly Clear',

            2 => '⛅ Partly Cloudy',

            3 => '☁ Overcast',

            45, 48 => '🌫 Fog',

            51, 53, 55 => '🌦 Drizzle',

            56, 57 => '🌧 Freezing Drizzle',

            61 => '🌧 Rain',

            63 => '🌧 Moderate Rain',

            65 => '🌧 Heavy Rain',

            66, 67 => '🧊 Freezing Rain',

            71 => '❄ Snow',

            73 => '❄ Moderate Snow',

            75 => '❄ Heavy Snow',

            77 => '🌨 Snow Grains',

            80 => '🌦 Rain Shower',

            81 => '🌦 Heavy Rain Shower',

            82 => '🌧 Violent Rain Shower',

            85 => '🌨 Snow Shower',

            86 => '❄ Heavy Snow Shower',

            95 => '⛈ Thunderstorm',

            96, 99 => '⛈ Severe Thunderstorm',

            default => '🌍 Unknown',

        };
    }
}