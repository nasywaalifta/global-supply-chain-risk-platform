<?php

namespace App\Console\Commands;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskScore;
use App\Services\PortService;
use Illuminate\Console\Command;

class FetchPorts extends Command
{
    protected $signature = 'ports:fetch';

    protected $description = 'Sinkronisasi data World Port Index';

    public function handle(PortService $service)
    {
        $this->info('Mengambil data World Port Index...');

        $features = $service->getPorts();

        if (empty($features)) {
            $this->error('Data pelabuhan tidak ditemukan.');
            return Command::FAILURE;
        }

        $this->info('Memilih pelabuhan terbesar setiap negara...');

        // Prioritas ukuran pelabuhan
        $priority = [
            'L' => 4,
            'M' => 3,
            'S' => 2,
            'V' => 1,
        ];

        $bestPorts = [];

        foreach ($features as $feature) {

            $attr = $feature['attributes'] ?? [];

            $countryCode = strtoupper(trim($attr['COUNTRY'] ?? ''));

            if ($countryCode == '') {
                continue;
            }

            $size = strtoupper(trim($attr['HARBORSIZE'] ?? 'V'));

            if (!isset($priority[$size])) {
                $size = 'V';
            }

            if (!isset($bestPorts[$countryCode])) {

                $bestPorts[$countryCode] = $feature;
                continue;

            }

            $oldSize = strtoupper(
                trim(
                    $bestPorts[$countryCode]['attributes']['HARBORSIZE'] ?? 'V'
                )
            );

            if ($priority[$size] > $priority[$oldSize]) {
                $bestPorts[$countryCode] = $feature;
            }
        }

        $saved = 0;

        foreach ($bestPorts as $countryCode => $feature) {

            $country = Country::where('cca2', $countryCode)->first();

            if (!$country) {
                continue;
            }

            $attr = $feature['attributes'];

            $risk = RiskScore::where('country_id', $country->id)->first();

            $riskScore = $risk?->total_score ?? rand(20, 40);

            $congestionScore = max(
                0,
                min(
                    100,
                    $riskScore + rand(-10, 10)
                )
            );

            if ($congestionScore >= 70) {
                $level = 'High';
            } elseif ($congestionScore >= 40) {
                $level = 'Medium';
            } else {
                $level = 'Low';
            }

            Port::updateOrCreate(

                [
                    'country_id' => $country->id,
                ],

                [

                    // INDEX_NO dipakai sebagai kode unik dari World Port Index
                    'code' => (string) ($attr['INDEX_NO'] ?? ''),

                    'name' => $attr['PORT_NAME'] ?? 'Unknown',

                    // Dataset ini tidak memiliki field CITY
                    'city' => null,

                    'latitude' => $attr['LATITUDE'] ?? null,

                    'longitude' => $attr['LONGITUDE'] ?? null,

                    // Large / Medium / Small / Very Small
                    'type' => $attr['HARBORSIZE'] ?? null,

                    'status' => 'Active',

                    'risk_score' => $riskScore,

                    'congestion_score' => $congestionScore,

                    'congestion_level' => $level,

                ]
            );

            $saved++;
        }

        $this->newLine();

        $this->info("Berhasil sinkronisasi {$saved} pelabuhan.");

        return Command::SUCCESS;
    }
}