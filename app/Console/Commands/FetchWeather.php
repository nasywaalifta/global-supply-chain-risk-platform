<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Port;
use App\Models\Weather;
use App\Services\WeatherService;

class FetchWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch weather for all ports';

    /**
     * Execute the console command.
     */
    public function handle(WeatherService $weatherService)
    {
        $this->info('Mengambil data cuaca...');

        $ports = Port::all();

        foreach ($ports as $port) {

            if (!$port->latitude || !$port->longitude) {
                continue;
            }

            $weather = $weatherService->getWeather(
                $port->latitude,
                $port->longitude
            );

            if (!$weather) {

                $this->warn("Gagal mengambil cuaca {$port->name}");

                continue;
            }

            $risk = 0;

            // Risiko berdasarkan angin
            if (($weather['wind_speed_10m'] ?? 0) >= 50) {

                $risk += 60;

            } elseif (($weather['wind_speed_10m'] ?? 0) >= 30) {

                $risk += 30;

            }

            // Risiko berdasarkan suhu
            if (($weather['temperature_2m'] ?? 0) >= 38) {

                $risk += 20;

            }

            // Risiko berdasarkan kondisi cuaca
            $condition = $weather['condition'] ?? '';

            if (
                str_contains($condition, 'Thunderstorm') ||
                str_contains($condition, 'Heavy Rain') ||
                str_contains($condition, 'Violent')
            ) {

                $risk += 40;

            } elseif (
                str_contains($condition, 'Rain') ||
                str_contains($condition, 'Snow')
            ) {

                $risk += 20;

            }

            if ($risk > 100) {
                $risk = 100;
            }

            Weather::updateOrCreate(

                [
                    'port_id' => $port->id
                ],

                [

                    'temperature' => $weather['temperature_2m'] ?? null,

                    'humidity' => $weather['relative_humidity_2m'] ?? null,

                    'wind_speed' => $weather['wind_speed_10m'] ?? null,

                    'condition' => $weather['condition'] ?? null,

                    'weather_risk' => $risk,

                    'last_update' => now(),

                ]

            );

            $this->info("✔ {$port->name}");
        }

        $this->info('==============================');
        $this->info('Weather selesai diupdate.');
        $this->info('==============================');

        return Command::SUCCESS;
    }
}