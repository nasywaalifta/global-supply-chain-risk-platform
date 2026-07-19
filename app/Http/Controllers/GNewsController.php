<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\GNews;
use Illuminate\Http\Request;

class GNewsController extends Controller
{
    public function index(Request $request)
    {
        $country = $request->country;

        $countries = GNews::whereNotNull('country')
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->get();

        $query = GNews::query();

        if ($country) {
            $query->where('country', $country);
        }

        $news = $query
            ->orderByDesc('published_at')
            ->get();

        $total = $news->count();

        $logistics = $news->where('sentiment', 'Positive')->count();

        $economy = $news->where('sentiment', 'Neutral')->count();

        $geopolitics = $news->where('sentiment', 'Negative')->count();

        return view('gnews.index', compact(
            'news',
            'countries',
            'country',
            'total',
            'logistics',
            'economy',
            'geopolitics'
        ));
    }
}