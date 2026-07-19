<?php

namespace App\Services;

use App\Models\Country;
use App\Models\ExchangeRate;
use App\Models\GNews;
use App\Models\RiskScore;
use App\Models\WeatherData;
use Carbon\Carbon;

class RiskScoreService
{
    /**
     * Hitung seluruh risk score semua negara
     */
    public function calculateAll()
    {
        $countries = Country::all();

        foreach ($countries as $country) {

            $weatherScore = $this->calculateWeatherScore($country);

            $currencyScore = $this->calculateCurrencyScore($country);

            $newsScore = $this->calculateNewsScore($country);

            // Belum ada data inflasi
            $inflationScore = 0;

            $totalScore = min(
                100,
                $weatherScore +
                $currencyScore +
                $newsScore +
                $inflationScore
            );

            $riskLevel = $this->riskLevel($totalScore);

            RiskScore::updateOrCreate(
                [
                    'country_id' => $country->id,
                ],
                [
                    'score_date' => Carbon::today(), 
                    'weather_score' => $weatherScore,
                    'inflation_score' => $inflationScore,
                    'currency_score' => $currencyScore,
                    'news_score' => $newsScore,
                    'total_score' => $totalScore,
                    'risk_level' => $riskLevel,
                ]
            );
        }
    }

    /**
     * Hitung skor cuaca
     */
    private function calculateWeatherScore(Country $country)
    {
        $weather = WeatherData::where('country_id', $country->id)->first();

        if (!$weather) {
            return 0;
        }

        $score = 0;

        switch ($weather->storm_risk) {

            case 'Tinggi':
                $score += 40;
                break;

            case 'Sedang':
                $score += 20;
                break;

            case 'Rendah':
                $score += 5;
                break;

            default:
                $score += 0;
                break;
        }

        // Curah hujan
        if ($weather->precipitation > 50) {
            $score += 20;
        } elseif ($weather->precipitation > 20) {
            $score += 10;
        }

        // Kecepatan angin
        if ($weather->wind_speed > 50) {
            $score += 20;
        } elseif ($weather->wind_speed > 30) {
            $score += 10;
        }

        // Suhu ekstrem
        if ($weather->temperature >= 40 || $weather->temperature <= 0) {
            $score += 20;
        }

        return min(100, $score);
    }

    /**
     * Hitung skor nilai tukar
     */
    private function calculateCurrencyScore(Country $country)
    {
        if (!$country->currency_code) {
            return 0;
        }

        $exchange = ExchangeRate::where(
            'code',
            $country->currency_code
        )->first();

        if (!$exchange) {
            return 0;
        }

        $rate = (float) $exchange->rate;

        if ($rate >= 15000) {
            return 20;
        }

        if ($rate >= 10000) {
            return 15;
        }

        if ($rate >= 5000) {
            return 10;
        }

        return 5;
    }

    /**
     * Hitung skor berita
     */
    private function calculateNewsScore(Country $country)
    {
        $news = GNews::where('country', $country->name)->get();

        if ($news->isEmpty()) {
            return 0;
        }

        $score = 0;

        foreach ($news as $item) {

            switch (strtolower($item->sentiment)) {

                case 'negative':
                    $score += 10;
                    break;

                case 'neutral':
                    $score += 5;
                    break;

                case 'positive':
                    $score += 0;
                    break;
            }
        }

        return min(40, $score);
    }

    /**
     * Tentukan level risiko
     */
    private function riskLevel($score)
    {
        if ($score >= 70) {
            return 'High';
        }

        if ($score >= 40) {
            return 'Medium';
        }

        return 'Low';
    }
}