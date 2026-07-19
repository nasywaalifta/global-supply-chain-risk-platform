<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $category = $request->category;

        $articles = Article::query()
            ->where('status', 'Published')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('summary', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($category && $category !== 'Semua Kategori', function ($query) use ($category) {
                $query->where('category', $category);
            })
            ->orderByDesc('published_at')
            ->get();

        // Statistik
        $totalArticles = Article::where('status', 'Published')->count();
        $resultCount = $articles->count();

        $categories = [
            'Semua Kategori',
            'Cuaca & Iklim',
            'Geopolitik',
            'Teknologi',
            'Logistik',
            'Ekonomi'
        ];

        return view('article.index', compact(
            'articles',
            'categories',
            'search',
            'category',
            'totalArticles',
            'resultCount'
        ));
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail();

        return view('article.show', compact('article'));
    }
}