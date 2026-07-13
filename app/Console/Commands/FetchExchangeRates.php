<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\ExchangeRate;

class FetchExchangeRates extends Command
{
    /**
     * Nama command Artisan
     */
    protected $signature = 'exchange:fetch';

    /**
     * Deskripsi command
     */
    protected $description = 'Mengambil data nilai tukar mata uang dari Frankfurter API';

    /**
     * Jalankan command
     */
    public function handle()
    {
        $this->info('Mengambil data nilai tukar mata uang...');

        $response = Http::get('https://api.frankfurter.app/latest?from=USD');

        if (!$response->successful()) {
            $this->error('Gagal mengambil data dari API.');
            return Command::FAILURE;
        }

        $data = $response->json();

        if (!isset($data['rates'])) {
            $this->error('Data API tidak valid.');
            return Command::FAILURE;
        }

        // Hapus data lama
        ExchangeRate::truncate();

        foreach ($data['rates'] as $code => $rate) {

            ExchangeRate::create([
                'currency'       => $code,
                'code'           => $code,
                'rate'           => $rate,
                'base_currency'  => 'USD',
                'updated_at_api' => now(),
            ]);
        }

        $this->info('Berhasil menyimpan '.count($data['rates']).' mata uang.');

        return Command::SUCCESS;
    }
}