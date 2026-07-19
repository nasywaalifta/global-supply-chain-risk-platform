<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WorldBankService
{
    public function getGDP($country)
{
    $url = "https://api.worldbank.org/v2/country/{$country}/indicator/NY.GDP.MKTP.CD?format=json&per_page=5";

    return Http::timeout(60)->get($url)->json();
}

public function getInflation($country)
{
    $url = "https://api.worldbank.org/v2/country/{$country}/indicator/FP.CPI.TOTL.ZG?format=json&per_page=5";

    return Http::timeout(60)->get($url)->json();
}
}