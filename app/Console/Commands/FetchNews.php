<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GNews;
use App\Services\GNewsService;
use App\Models\Country;

class FetchNews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch latest global supply chain news from GNews API';

    /**
     * Execute the console command.
     */
    public function handle(GNewsService $gnewsService)
    {
        $this->info('==============================');
        $this->info('Mengambil berita dari GNews...');
        $this->info('==============================');

        $articles = $gnewsService->getNews();

        if (empty($articles)) {

            $this->error('Tidak ada berita yang berhasil diambil.');

            return Command::FAILURE;
        }

        $saved = 0;

        $countries = Country::pluck('name')->toArray();

        foreach ($articles as $article) {

            $title = $article['title'] ?? '';

            $text = strtolower(
                ($article['title'] ?? '') . ' ' .
                ($article['description'] ?? '')
            );

            $detectedCountry = null;

            foreach ($countries as $countryName) {

                if (
                    stripos($article['title'] ?? '', $countryName) !== false ||
                    stripos($article['description'] ?? '', $countryName) !== false
                ) {
                    $detectedCountry = $countryName;
                    break;
                }

            }

            $sentiment = 'Neutral';

            if (
                str_contains($text, 'war') ||
                str_contains($text, 'attack') ||
                str_contains($text, 'storm') ||
                str_contains($text, 'earthquake') ||
                str_contains($text, 'crisis') ||
                str_contains($text, 'delay') ||
                str_contains($text, 'conflict')
            ) {

                $sentiment = 'Negative';

            } elseif (

                str_contains($text, 'growth') ||
                str_contains($text, 'recovery') ||
                str_contains($text, 'improve') ||
                str_contains($text, 'expansion') ||
                str_contains($text, 'increase')

            ) {

                $sentiment = 'Positive';

            }

            GNews::updateOrCreate(

                [
                    'url' => $article['url']
                ],

                [

                    'title' => $title,

                    'description' => $article['description'] ?? null,

                    'source' => $article['source']['name'] ?? null,

                    'author' => $article['source']['name'] ?? null,

                    'image_url' => $article['image'] ?? null,

                    'country' => $detectedCountry,

                    'sentiment' => $sentiment,

                    'published_at' => $article['publishedAt'] ?? now(),

                ]

            );

            $saved++;

            $this->line("✔ {$title}");
        }

        $this->info('');
        $this->info('==============================');
        $this->info("Berhasil disimpan : {$saved}");
        $this->info("Total Database : " . GNews::count());
        $this->info('==============================');

        return Command::SUCCESS;
    }
}