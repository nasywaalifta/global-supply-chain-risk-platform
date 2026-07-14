<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\News;
use App\Services\NewsService;

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
    protected $description = 'Fetch latest global supply chain news';

    /**
     * Execute the console command.
     */
    public function handle(NewsService $newsService)
    {
        $this->info('Mengambil berita terbaru...');

        $articles = $newsService->getNews();

        if (empty($articles)) {

            $this->error('Tidak ada berita yang ditemukan.');

            return Command::FAILURE;
        }

        foreach ($articles as $article) {

            $title = $article['title'] ?? '';

            $sentiment = 'Neutral';

            if (
                str_contains(strtolower($title), 'war') ||
                str_contains(strtolower($title), 'attack') ||
                str_contains(strtolower($title), 'storm') ||
                str_contains(strtolower($title), 'earthquake') ||
                str_contains(strtolower($title), 'crisis') ||
                str_contains(strtolower($title), 'delay')
            ) {

                $sentiment = 'Negative';

            } elseif (

                str_contains(strtolower($title), 'growth') ||
                str_contains(strtolower($title), 'recovery') ||
                str_contains(strtolower($title), 'improve') ||
                str_contains(strtolower($title), 'expansion')

            ) {

                $sentiment = 'Positive';

            }

            News::updateOrCreate(

                [
                    'url' => $article['url']
                ],

                [

                    'title' => $title,

                    'description' => $article['description'] ?? null,

                    'source' => $article['source']['name'] ?? null,

                    'author' => isset($article['author'])
                        ? substr($article['author'], 0, 255)
                        : null,

                    'image_url' => $article['urlToImage'] ?? null,

                    'country' => null,

                    'sentiment' => $sentiment,

                    'published_at' => $article['publishedAt'] ?? now(),

                ]

            );

            $this->info("✔ {$title}");
        }

        $this->info('==============================');
        $this->info('Import berita selesai.');
        $this->info('Total Berita : ' . News::count());
        $this->info('==============================');

        return Command::SUCCESS;
    }
}