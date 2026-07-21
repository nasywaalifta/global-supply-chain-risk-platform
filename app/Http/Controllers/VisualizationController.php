<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\WeatherData;
use App\Models\Article;
use App\Models\GNews;
use App\Services\RiskCalculatorService;
use App\Services\WorldBankService;
use App\Services\ExchangeRateService;

class VisualizationController extends Controller
{
    protected $worldBank;
    protected $exchangeService;
    protected $riskCalculator;

    public function __construct(
        WorldBankService $worldBank,
        ExchangeRateService $exchangeService,
        RiskCalculatorService $riskCalculator
    ) {
        $this->worldBank = $worldBank;
        $this->exchangeService = $exchangeService;
        $this->riskCalculator = $riskCalculator;
    }

    public function index()
    {
        $countries = Country::orderBy('name')->get();

        $exchangeRates = ExchangeRate::all();

        
        return view('visualisasi.index', compact(
            'countries',
            'exchangeRates',
        ));
    }

    public function getCountryData($country)
    {
        $countryModel = Country::where('name', $country)->first();

        if (!$countryModel) {
            return response()->json([
                'success' => false,
                'message' => 'Country not found'
            ], 404);
        }

        $gdp = $this->worldBank->getGDP($countryModel->cca3);

        $inflationData = $this->worldBank->getInflation($countryModel->cca3);

        $inflation = (float) ($inflationData[1][0]['value'] ?? 0);

        $exchange = $this->exchangeService->getLatestRates();

        $weather = WeatherData::where('country_id', $countryModel->id)->first();

        $negativeNews = GNews::where('country', $countryModel->name)
            ->where('sentiment', 'Negative')
            ->count();

        $risk = $this->riskCalculator->calculate(

            $weather->temperature,

            $weather->precipitation,

            $weather->wind_speed,

            $weather->storm_risk,

            $inflation,

            $exchange['rates']['IDR'] ?? 0,

            $negativeNews

        );
            
        if (!$weather) {
            return response()->json([
                'success' => false,
                'message' => 'Weather data not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'country' => $countryModel,
            'risk' => $risk,
            'gdp' => $gdp,
            'inflation' => $inflation,
            'exchange' => $exchange
        ]);
    }
}