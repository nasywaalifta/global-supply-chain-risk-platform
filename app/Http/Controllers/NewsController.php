<?php

namespace App\Http\Controllers;

use App\Models\News;

class NewsController extends Controller
{
    /**
     * Menampilkan daftar berita.
     */
    public function index()
    {
        $news = News::orderBy('published_at', 'desc')
            ->paginate(9);

        return view('news.index', [
            'news' => $news,
        ]);
    }
}