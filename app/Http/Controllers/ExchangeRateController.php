<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $exchangeRates = ExchangeRate::orderBy('code')->get();

        return view('exchange_rates.index', compact('exchangeRates'));
    }
}