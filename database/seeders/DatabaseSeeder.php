<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Article;
use App\Models\PositiveWord;
use App\Models\NegativeWord;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
        $this->call([
            CountrySeeder::class,
            PortSeeder::class,
            RiskScoreSeeder::class,
        ]);

        if (User::count() === 0) {
            User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);
        }

        // Seed positive words
        $posWords = [
            'growth', 'increase', 'profit', 'stable', 'improve', 'expansion', 
            'recovery', 'success', 'boost', 'rise', 'safety', 'secure', 
            'progress', 'solution', 'strong', 'positive', 'gain', 'opportunity',
            'efficient', 'optimize', 'benefit', 'innovative', 'collaboration'
        ];
        foreach ($posWords as $word) {
            PositiveWord::firstOrCreate(['word' => $word]);
        }

        // Seed negative words
        $negWords = [
            'war', 'crisis', 'inflation', 'delay', 'disaster', 'attack', 
            'storm', 'conflict', 'decrease', 'loss', 'drop', 'decline', 
            'failure', 'risk', 'danger', 'collapse', 'shortage', 'disrupt',
            'congestion', 'threat', 'strike', 'shutdown', 'drought'
        ];
        foreach ($negWords as $word) {
            NegativeWord::firstOrCreate(['word' => $word]);
        }

        // Seed analyst articles
        $articles = [
            [
                'title' => 'Kekeringan Terusan Panama & Pergeseran Logistik Internasional',
                'summary' => 'Kekeringan ekstrem membatasi lalu lintas harian Terusan Panama, memindahkan kargo ke jalur kereta...',
                'content' => 'Kekeringan ekstrem membatasi lalu lintas harian Terusan Panama, memindahkan kargo ke jalur kereta api dan rute alternatif. Fenomena cuaca El Niño telah menurunkan tingkat air di Danau Gatun ke titik terendah dalam beberapa dekade, memaksa Otoritas Terusan Panama mengurangi jumlah transit harian dan membatasi draf kapal. Akibatnya, perusahaan pelayaran global harus mencari rute alternatif yang lebih panjang atau menggunakan layanan intermodal darat untuk menghindari keterlambatan pengiriman yang signifikan.',
                'category' => 'Cuaca & Iklim',
                'thumbnail' => 'https://images.unsplash.com/photo-1518241353330-0f7941c2d9b5?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Gangguan Geopolitik Laut Merah & Tarif Pengiriman',
                'summary' => 'Analisis jalur alternatif pengiriman di sekitar Tanjung Harapan yang memicu kenaikan tarif logistik...',
                'content' => 'Analisis jalur alternatif pengiriman di sekitar Tanjung Harapan yang memicu kenaikan tarif logistik dan inflasi bahan baku. Eskalasi konflik geopolitik di wilayah Laut Merah memaksa banyak operator kontainer global menghindari Terusan Suez dan mengalihkan kapal mereka di sekitar benua Afrika. Pengalihan rute ini menambah waktu tempuh sekitar 10 hingga 14 hari, meningkatkan biaya bahan bakar, dan menyebabkan lonjakan tarif angkutan laut (ocean freight rates) secara global.',
                'category' => 'Geopolitik',
                'thumbnail' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Inovasi AI dalam Prediksi Kemacetan Pelabuhan',
                'summary' => 'Bagaimana kecerdasan buatan membantu memprediksi dan mengurangi waktu tunggu kapal di pelabuhan utama...',
                'content' => 'Bagaimana kecerdasan buatan membantu memprediksi dan mengurangi waktu tunggu kapal di pelabuhan utama dunia. Dengan memanfaatkan algoritma pembelajaran mesin dan data historis pergerakan kapal, sistem analitik baru dapat memproyeksikan potensi kepadatan terminal pelabuhan hingga beberapa minggu ke depan. Hal ini memungkinkan operator logistik untuk menyesuaikan rute dan jadwal kedatangan secara real-time untuk menghindari waktu tunggu jangkar yang lama.',
                'category' => 'Teknologi',
                'thumbnail' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=800&q=80',
            ],
        ];

        foreach ($articles as $art) {
            Article::firstOrCreate(
                ['slug' => Str::slug($art['title'])],
                [
                    'title' => $art['title'],
                    'summary' => $art['summary'],
                    'content' => $art['content'],
                    'category' => $art['category'],
                    'thumbnail' => $art['thumbnail'],
                    'status' => 'Published',
                    'published_at' => now(),
                ]
            );
        }
    }
}