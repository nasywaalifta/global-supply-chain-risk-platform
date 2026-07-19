<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExchangeRate;
use App\Services\ExchangeRateService;

class FetchExchangeRates extends Command
{
    protected $signature = 'exchange:fetch';

    protected $description = 'Mengambil data nilai tukar mata uang dari ExchangeRate API';

    public function handle(ExchangeRateService $service)
    {
        $this->info('Mengambil data nilai tukar mata uang...');

        $data = $service->getLatestRates();

        if (empty($data)) {

            $this->error('Gagal mengambil data ExchangeRate API.');

            return Command::FAILURE;

        }

        if (!isset($data['rates'])) {

            $this->error('Data API tidak valid.');

            return Command::FAILURE;

        }

        ExchangeRate::truncate();

        foreach ($data['rates'] as $code => $rate) {

            ExchangeRate::create([

                'currency' => $code,

                'code' => $code,

                'rate' => $rate,

                'base_currency' => $data['base_code'],

                'updated_at_api' => now(),

            ]);

        }

        $this->info('Berhasil menyimpan '.count($data['rates']).' mata uang.');

        return Command::SUCCESS;
    }
}