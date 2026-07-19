<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Currency;
use App\Services\CurrencyService;

class FetchCurrencies extends Command
{
    protected $signature = 'currencies:fetch';

    protected $description = 'Fetch latest currency exchange rates';

    public function handle(CurrencyService $service)
    {
        $rates = $service->getLatestRates();

        if (empty($rates)) {
            $this->error('Tidak ada data kurs.');
            return;
        }

        foreach ($rates as $code => $rate) {

            Currency::updateOrCreate(
                ['code' => $code],
                [
                    'name' => $code,
                    'rate' => $rate,
                ]
            );

        }

        $this->info('Data currency berhasil diupdate.');
    }
}