<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class CountryService
{
    private string $baseUrl = 'https://countries.dev';

    public function getAllCountries(): array
    {
        try {

            $response = Http::timeout(60)
                ->acceptJson()
                ->get($this->baseUrl . '/countries');

            $response->throw();

            $data = $response->json();

            if (! is_array($data)) {
                return [];
            }

            return $data;

        } catch (RequestException $e) {

            logger()->error('Countries API Error', [
                'message' => $e->getMessage()
            ]);

            return [];

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            return [];
        }
    }
}