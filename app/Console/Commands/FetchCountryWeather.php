<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Models\WeatherData;
use App\Services\OpenMeteoService;

class FetchCountryWeather extends Command
{
    /**
     * Nama command
     */
    protected $signature = 'weather:country-fetch';

    /**
     * Deskripsi command
     */
    protected $description = 'Fetch weather data for all countries using Open-Meteo API';

    /**
     * Jalankan command
     */
    public function handle(OpenMeteoService $service)
    {
        $this->info('=======================================');
        $this->info('Mengambil data cuaca seluruh negara...');
        $this->info('=======================================');

        $countries = Country::all();

        foreach ($countries as $country) {

            if (!$country->latitude || !$country->longitude) {
                $this->warn("{$country->name} tidak memiliki koordinat.");
                continue;
            }

            try {

                $weather = $service->getCurrentWeather(
                    $country->latitude,
                    $country->longitude
                );

            } catch (\Exception $e) {

                $this->warn("⚠ Gagal mengambil {$country->name}, dilewati.");

                continue;

            }

            if (!$weather) {
                $this->error("Gagal mengambil data {$country->name}");
                continue;
            }

            // Part 2 akan dimulai dari sini
                        WeatherData::updateOrCreate(

                [
                    'country_id' => $country->id,
                ],

                [
                    'temperature' => $weather['temperature'],
                    'precipitation' => $weather['precipitation'],
                    'wind_speed' => $weather['wind_speed'],
                    'storm_risk' => $weather['storm_risk'],
                    'weather_code' => $weather['weather_code'],
                    'updated_at_api' => now(),
                ]

            );

            $this->info("✔ {$country->name} ({$weather['storm_risk']})");

        }

        $this->info('=======================================');
        $this->info('Semua data cuaca berhasil diperbarui.');
        $this->info('=======================================');

        return Command::SUCCESS;
    }
}