<?php

namespace App\Http\Controllers;

use App\Models\ExchangeRate;
use App\Models\Country;
use Illuminate\Support\Facades\Artisan;

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

    public function sync()
    {
        Artisan::call('exchange:fetch');

        return redirect()
            ->route('exchange-rates.index')
            ->with('success', 'Data kurs berhasil disinkronkan.');
    }
}