<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Country;
use App\Services\WorldBankService;

class FetchWorldBankData extends Command
{
    protected $signature = 'worldbank:fetch';

    protected $description = 'Fetch GDP dan Inflasi dari World Bank';

    public function handle(WorldBankService $service)
{
    $countries = Country::all();

    foreach ($countries as $country) {

        try {

            $code = strtolower($country->cca2);

            $gdpData = $service->getGDP($code);
            $inflationData = $service->getInflation($code);

            $gdp = null;
            $inflation = null;

            if (isset($gdpData[1])) {
                foreach ($gdpData[1] as $item) {
                    if (!empty($item['value'])) {
                        $gdp = $item['value'];
                        break;
                    }
                }
            }

            if (isset($inflationData[1])) {
                foreach ($inflationData[1] as $item) {
                    if (!empty($item['value'])) {
                        $inflation = round($item['value'], 2);
                        break;
                    }
                }
            }

            $country->update([
                'gdp' => $gdp,
                'inflation' => $inflation,
            ]);

            $this->info("{$country->name} updated");

            // jeda 0,3 detik
            usleep(300000);

        } catch (\Exception $e) {

            $this->error("{$country->name} gagal : ".$e->getMessage());

            continue;
        }
    }

    $this->info('Selesai.');
}
}