<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\GNews;
use App\Services\GNewsService;
use App\Models\Country;
use App\Models\PositiveWord;
use App\Models\NegativeWord;

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

            $positiveWords = PositiveWord::pluck('word')->toArray();
            $negativeWords = NegativeWord::pluck('word')->toArray();

            $positiveScore = 0;
            $negativeScore = 0;

            $words = preg_split('/\s+/', $text);

            foreach ($words as $word) {

                $word = preg_replace('/[^a-z]/', '', $word);

                if (in_array($word, $positiveWords)) {
                    $positiveScore++;
                }

                if (in_array($word, $negativeWords)) {
                    $negativeScore++;
                }
            }

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

            if ($positiveScore > $negativeScore) {

                $sentiment = 'Positive';

            } elseif ($negativeScore > $positiveScore) {

                $sentiment = 'Negative';

            } else {

                $sentiment = 'Neutral';

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