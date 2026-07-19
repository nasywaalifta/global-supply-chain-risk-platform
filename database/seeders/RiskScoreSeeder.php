<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\RiskScore;

class RiskScoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RiskScore::truncate();

        foreach (Country::all() as $country) {

            $weather = rand(20, 80);
            $inflation = rand(20, 80);
            $currency = rand(20, 80);
            $news = rand(20, 80);

            $total = round(
                ($weather + $inflation + $currency + $news) / 4,
                2
            );

            if ($total >= 70) {
                $level = 'High';
            } elseif ($total >= 40) {
                $level = 'Medium';
            } else {
                $level = 'Low';
            }

            RiskScore::create([
                'country_id' => $country->id,
                'weather_score' => $weather,
                'inflation_score' => $inflation,
                'currency_score' => $currency,
                'news_score' => $news,
                'total_score' => $total,
                'risk_level' => $level,
                'score_date' => now()->toDateString(),
            ]);
        }
    }
}