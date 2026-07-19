<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GNewsService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gnews.api_key');
        $this->baseUrl = config('services.gnews.base_url');
    }

    public function getNews(?string $country = null): array
    {
        $topics = [
            'economy',
            'trade',
            'logistics',
            'shipping',
            'port',
            'supply chain',
            'cargo',
            'maritime',
            'geopolitics',
        ];

        $allArticles = [];

        foreach ($topics as $topic) {

            $query = $country
                ? "\"{$country}\" {$topic}"
                : $topic;

            $response = Http::timeout(30)->get(
                $this->baseUrl . '/search',
                [
                    'q'       => $query,
                    'lang'    => 'en',
                    'sortby'  => 'publishedAt',
                    'max'     => 20,
                    'apikey'  => $this->apiKey,
                ]
            );

            if (! $response->successful()) {
                continue;
            }

            $articles = $response->json()['articles'] ?? [];

            foreach ($articles as $article) {

                $article['category'] = $this->detectCategory($article);

                $allArticles[] = $article;
            }
        }

        // Hapus duplikat berdasarkan URL
        $unique = [];

        foreach ($allArticles as $article) {

            if (!empty($article['url'])) {
                $unique[$article['url']] = $article;
            }

        }

        $allArticles = array_values($unique);

        usort($allArticles, function ($a, $b) {

            return strtotime($b['publishedAt'])
                <=> strtotime($a['publishedAt']);

        });

        return $allArticles;
    }

    private function detectCategory(array $article): string
    {
        $text = strtolower(
            ($article['title'] ?? '') . ' ' .
            ($article['description'] ?? '')
        );

        if (
            str_contains($text, 'logistics') ||
            str_contains($text, 'shipping') ||
            str_contains($text, 'port') ||
            str_contains($text, 'cargo') ||
            str_contains($text, 'container') ||
            str_contains($text, 'harbor') ||
            str_contains($text, 'maritime')
        ) {
            return 'Logistics';
        }

        if (
            str_contains($text, 'economy') ||
            str_contains($text, 'trade') ||
            str_contains($text, 'inflation') ||
            str_contains($text, 'currency') ||
            str_contains($text, 'gdp')
        ) {
            return 'Economy';
        }

        if (
            str_contains($text, 'war') ||
            str_contains($text, 'sanction') ||
            str_contains($text, 'military') ||
            str_contains($text, 'conflict') ||
            str_contains($text, 'tariff')
        ) {
            return 'Geopolitics';
        }

        return 'General';
    }
}