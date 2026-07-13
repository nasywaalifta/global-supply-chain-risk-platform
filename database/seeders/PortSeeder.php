<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Port;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        Port::query()->delete();

        $file = database_path('data/world_port_index.csv');

        if (!file_exists($file)) {
            $this->command->error('world_port_index.csv tidak ditemukan!');
            return;
        }

        $handle = fopen($file, 'r');

        if (!$handle) {
            $this->command->error('Gagal membuka file CSV.');
            return;
        }

        // Header
        $header = fgetcsv($handle);

        $total = 0;
        $skipCountry = 0;

        while (($row = fgetcsv($handle)) !== false) {

            if (count($row) !== count($header)) {
                continue;
            }

            $data = array_combine($header, $row);

            if (!$data) {
                continue;
            }

            // Cari negara berdasarkan NAMA NEGARA
            $country = Country::where('name', trim($data['Country Code']))->first();

            if (!$country) {
                $skipCountry++;
                continue;
            }

            Port::create([
                'country_id' => $country->id,
                'code'       => trim($data['UN/LOCODE']) ?: null,
                'name'       => trim($data['Main Port Name']),
                'city'       => null,
                'latitude'   => is_numeric($data['Latitude']) ? (float) $data['Latitude'] : null,
                'longitude'  => is_numeric($data['Longitude']) ? (float) $data['Longitude'] : null,
                'type'       => trim($data['Harbor Type']),
                'status'     => trim($data['Harbor Use']),
                'risk_score' => 0,
            ]);

            $total++;
        }

        fclose($handle);

        $this->command->info("Berhasil import : {$total}");
        $this->command->warn("Negara tidak ditemukan : {$skipCountry}");
    }
}