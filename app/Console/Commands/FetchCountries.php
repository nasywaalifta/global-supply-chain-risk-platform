<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CountryService;
use App\Models\Country;

class FetchCountries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countries:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all countries from Countries API';

    /**
     * Execute the console command.
     */
    public function handle(CountryService $countryService)
    {
        $this->info('Mengambil data negara...');

        $countries = $countryService->getAllCountries();

        if (empty($countries)) {
            $this->error('Gagal mengambil data dari API.');
            return Command::FAILURE;
        }

        foreach ($countries as $country) {

            if (empty($country['alpha3Code'])) {
                continue;
            }

            Country::updateOrCreate(

                [
                    'cca3' => $country['alpha3Code'],
                ],

                [

                    'name' => $country['name'] ?? null,

                    'official_name' => $country['nativeName'] ?? null,

                    'cca2' => $country['alpha2Code'] ?? null,

                    'capital' => $country['capital'] ?? null,

                    'region' => $country['region'] ?? null,

                    'subregion' => $country['subregion'] ?? null,

                    'population' => $country['population'] ?? 0,

                    'area' => $country['area'] ?? 0,

                    'currency_code' => $country['currencies'][0]['code'] ?? null,

                    'currency_name' => $country['currencies'][0]['name'] ?? null,

                    'currency_symbol' => $country['currencies'][0]['symbol'] ?? null,

                    'language' => isset($country['languages'])
                        ? implode(', ', array_column($country['languages'], 'name'))
                        : null,

                    'flag_png' => $country['flags']['png'] ?? null,

                    'flag_svg' => $country['flags']['svg'] ?? null,

                    'latitude' => $country['latlng'][0] ?? null,

                    'longitude' => $country['latlng'][1] ?? null,

                    'timezones' => isset($country['timezones'])
                        ? implode(', ', $country['timezones'])
                        : null,

                    'google_maps' => $country['maps']['googleMaps'] ?? null,

                ]

            );
        }

        $this->info('====================================');
        $this->info('Import negara selesai.');
        $this->info('Total Negara : ' . Country::count());
        $this->info('====================================');

        return Command::SUCCESS;
    }
}