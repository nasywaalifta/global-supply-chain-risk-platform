<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsService
{
    public function getNews(): array
    {
        try {

            $response = Http::timeout(20)
                ->retry(3, 1000)
                ->acceptJson()
                ->get(
                    'https://newsapi.org/v2/everything',
                    [
                        'q' => '"supply chain" OR logistics OR shipping OR maritime OR seaport OR cargo OR container OR freight',
                        'searchIn' => 'title,description',
                        'language' => 'en',
                        'sortBy' => 'publishedAt',
                        'pageSize' => 20,
                        'apiKey' => env('NEWS_API_KEY'),
                    ]
                );

            if (! $response->successful()) {

                logger()->error('News API Error', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                ]);

                return [];

            }

            $articles = $response->json()['articles'] ?? [];

            // Filter agar hanya berita yang benar-benar relevan
            $keywords = [
                'shipping',
                'ship',
                'port',
                'seaport',
                'logistics',
                'supply chain',
                'cargo',
                'container',
                'freight',
                'maritime',
                'export',
                'import',
                'trade',
                'harbor',
            ];

            $filtered = [];

            foreach ($articles as $article) {

                $text = strtolower(
                    ($article['title'] ?? '') . ' ' .
                    ($article['description'] ?? '')
                );

                foreach ($keywords as $keyword) {

                    if (str_contains($text, strtolower($keyword))) {

                        $filtered[] = $article;

                        break;
                    }
                }
            }

            return $filtered;

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            return [];

        }
    }
}