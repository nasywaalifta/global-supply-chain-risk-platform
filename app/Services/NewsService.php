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
                ->get('https://newsapi.org/v2/everything', [

                    'q' => '"supply chain" OR shipping OR maritime OR port OR cargo OR logistics OR freight OR "container ship" OR "port authority" OR "trade route"',

                    'language' => 'en',

                    'sortBy' => 'publishedAt',

                    'pageSize' => 100,

                    'apiKey' => env('NEWS_API_KEY'),

                ]);

            if (! $response->successful()) {

                logger()->error($response->body());

                return [];

            }

            $articles = $response->json()['articles'] ?? [];

            $keywords = [

                'port',
                'shipping',
                'ship',
                'container',
                'cargo',
                'logistics',
                'freight',
                'maritime',
                'harbor',
                'terminal',
                'trade',
                'export',
                'import',
                'canal',
                'strait',
                'vessel',
                'supply chain',

            ];

            $blacklist = [

                'amazon',
                'discount',
                'coupon',
                'sale',
                'adidas',
                'nike',
                'shoe',
                'fashion',
                'lego',
                'toy',
                'music box',

                'python',
                'pypi',
                'pip',
                'npm',
                'github',
                'laravel',
                'react',
                'vue',
                'node',
                'package',
                'library',
                'framework',
                'codec',
                'kanonak',
                'pipguard',
                'cli',
                'agentsentinel',

                'archive of our own',
                'fanfiction',
                'ao3',
                'slickdeals',
                'dealnews',

            ];

            $filtered = [];

            foreach ($articles as $article) {

                $title = strtolower($article['title'] ?? '');
                $description = strtolower($article['description'] ?? '');

                $text = $title . ' ' . $description;

                $matchCount = 0;

                foreach ($keywords as $keyword) {

                    if (str_contains($text, strtolower($keyword))) {

                        $matchCount++;

                    }

                }

                $valid = $matchCount >= 1;

                foreach ($blacklist as $bad) {

                    if (str_contains($text, strtolower($bad))) {

                        $valid = false;

                        break;

                    }

                }

                if (
                    $valid &&
                    strlen($title) > 20 &&
                    !empty($description)
                ) {

                    $source = strtolower($article['source']['name'] ?? '');

                    if (
                        str_contains($source, 'archive') ||
                        str_contains($source, 'slickdeals') ||
                        str_contains($source, 'dealnews')
                    ) {
                        continue;
                    }

                    $filtered[] = $article;

                }

            }

            return $filtered;

        } catch (\Throwable $e) {

            logger()->error($e->getMessage());

            return [];

        }
    }
}