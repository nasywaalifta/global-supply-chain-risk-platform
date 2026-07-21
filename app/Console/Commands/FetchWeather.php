<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Port;
use App\Models\Weather;
use App\Services\OpenMeteoService;

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
    public function handle(OpenMeteoService $weatherService)
    {
        $this->info('Mengambil data cuaca...');

        $ports = Port::all();

        foreach ($ports as $port) {

            if (!$port->latitude || !$port->longitude) {
                continue;
            }

            $weather = $weatherService->getCurrentWeather(
                $port->latitude,
                $port->longitude
            );

            if (!$weather) {

                $this->warn("Gagal mengambil cuaca {$port->name}");

                continue;
            }

            $risk = match ($weather['storm_risk']) {
                'Tinggi' => 100,
                'Sedang' => 60,
                default => 20,
            };

            Weather::updateOrCreate(

                [
                    'port_id' => $port->id
                ],

                [
                    'temperature' => $weather['temperature'] ?? null,

                    'humidity' => null,

                    'wind_speed' => $weather['wind_speed'] ?? null,

                    'precipitation' => $weather['precipitation'] ?? null,

                    'storm_risk' => $weather['storm_risk'] ?? null,

                    'condition' => $weather['weather_code'] ?? null,

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