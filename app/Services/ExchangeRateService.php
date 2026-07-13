<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ExchangeRateService
{
    public function getLatestRates()
    {
        $response = Http::get('https://api.frankfurter.app/latest?from=USD');

        if (!$response->successful()) {
            return [];
        }

        return $response->json();
    }
}