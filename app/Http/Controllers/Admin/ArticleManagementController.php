<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleManagementController extends Controller
{
    /**
     * Display a listing of the articles.
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $category = $request->category;

        $articles = Article::query()
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
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        $categories = [
            'Semua Kategori',
            'Cuaca & Iklim',
            'Geopolitik',
            'Teknologi',
            'Logistik',
            'Ekonomi'
        ];

        return view('admin.articles.index', compact('articles', 'categories', 'search', 'category'));
    }

    /**
     * Show the form for creating a new article.
     */
    public function create()
    {
        $categories = [
            'Cuaca & Iklim',
            'Geopolitik',
            'Teknologi',
            'Logistik',
            'Ekonomi'
        ];
        return view('admin.articles.create', compact('categories'));
    }

    /**
     * Store a newly created article in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string|max:2048',
            'category' => 'required|string',
            'status' => 'required|in:Draft,Published',
        ]);

        $slug = Str::slug($request->title);
        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $published_at = null;
        if ($request->status === 'Published') {
            $published_at = now();
        }

        Article::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'category' => $request->category,
            'status' => $request->status,
            'published_at' => $published_at,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified article.
     */
    public function edit(Article $article)
    {
        $categories = [
            'Cuaca & Iklim',
            'Geopolitik',
            'Teknologi',
            'Logistik',
            'Ekonomi'
        ];
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    /**
     * Update the specified article in storage.
     */
    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|string|max:2048',
            'category' => 'required|string',
            'status' => 'required|in:Draft,Published',
        ]);

        $slug = $article->slug;
        if ($request->title !== $article->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $count = 1;
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        $published_at = $article->published_at;
        if ($request->status === 'Published' && !$published_at) {
            $published_at = now();
        } elseif ($request->status === 'Draft') {
            $published_at = null;
        }

        $article->update([
            'title' => $request->title,
            'slug' => $slug,
            'summary' => $request->summary,
            'content' => $request->content,
            'thumbnail' => $request->thumbnail,
            'category' => $request->category,
            'status' => $request->status,
            'published_at' => $published_at,
        ]);

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Remove the specified article from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()
            ->route('admin.articles.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
