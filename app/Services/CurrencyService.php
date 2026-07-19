<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CurrencyService
{
    protected string $baseUrl = 'https://open.er-api.com/v6/latest/USD';

    public function getLatestRates()
    {
        $response = Http::timeout(30)->get($this->baseUrl);

        if (!$response->successful()) {
            return [];
        }

        return $response->json('rates') ?? [];
    }
}