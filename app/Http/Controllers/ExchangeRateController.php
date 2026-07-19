<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\Country;

class ExchangeRateController extends Controller
{
    public function index()
    {
        $exchangeRates = ExchangeRate::orderBy('code')->get();

        $countries = Country::all()->keyBy('currency_code');

        return view('exchange_rates.index', [
            'exchangeRates' => $exchangeRates,
            'countries'     => $countries,
        ]);
    }
}