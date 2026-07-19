<?php

namespace App\Http\Controllers;

use App\Models\Currency;

class CurrencyController extends Controller
{
    public function show(Country $country)
{
    $country->load([
        'weather',
        'riskScore',
        'ports'
    ]);

    $totalPorts = $country->ports->count();

    return view('countries.show', compact(
        'country',
        'totalPorts'
    ));
}
}