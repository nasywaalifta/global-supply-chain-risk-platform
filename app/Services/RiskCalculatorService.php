<?php

namespace App\Services;

class RiskCalculatorService
{
    public function calculate(
        float $temperature,
        float $rain,
        float $wind,
        string $stormRisk,
        float $inflation,
        float $exchangeRate,
        int $negativeNews
    ): array {

        // =========================
        // Weather Score
        // =========================

        $weatherScore = 20;

        if ($stormRisk === 'Sedang') {
            $weatherScore = 50;
        }

        if ($stormRisk === 'Tinggi') {
            $weatherScore = 80;
        }

        if ($wind > 40) {
            $weatherScore += 10;
        }

        if ($rain > 80) {
            $weatherScore += 10;
        }

        $weatherScore = min(100, $weatherScore);

        // =========================
        // Inflation Score
        // =========================

        $inflationScore = min(100, $inflation * 10);

        // =========================
        // Currency Score
        // =========================

        if ($exchangeRate <= 2) {
            $currencyScore = 20;
        } elseif ($exchangeRate <= 10) {
            $currencyScore = 40;
        } elseif ($exchangeRate <= 100) {
            $currencyScore = 60;
        } else {
            $currencyScore = 80;
        }

        // =========================
        // News Score
        // =========================

        $newsScore = min(100, $negativeNews * 10);

        // =========================
        // Total
        // =========================

        $total = round(
            (
                $weatherScore +
                $inflationScore +
                $currencyScore +
                $newsScore
            ) / 4,
            2
        );

        if ($total >= 70) {
            $level = 'High';
        } elseif ($total >= 40) {
            $level = 'Medium';
        } else {
            $level = 'Low';
        }

        return [

            'weather_score' => $weatherScore,

            'inflation_score' => round($inflationScore,2),

            'currency_score' => $currencyScore,

            'news_score' => $newsScore,

            'total_score' => $total,

            'risk_level' => $level

        ];
    }
}