<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PortService
{
    private string $baseUrl =
        'https://services.arcgis.com/hRUr1F8lE8Jq2uJo/arcgis/rest/services/World_Port_Index/FeatureServer/0/query';

    public function getPorts()
    {
        $response = Http::timeout(60)->get($this->baseUrl, [
            'where' => '1=1',
            'outFields' => '*',
            'returnGeometry' => 'true',
            'f' => 'json',
        ]);

        if (!$response->successful()) {
            throw new \Exception('Gagal mengambil data World Port Index.');
        }

        return $response->json()['features'] ?? [];
    }
}