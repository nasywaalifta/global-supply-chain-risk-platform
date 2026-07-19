<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function getLatestRates()
    {
        $response = Http::get('https://open.er-api.com/v6/latest/USD');

        if (!$response->successful()) {
            return [];
        }

        return $response->json()['rates'] ?? [];
    }
}