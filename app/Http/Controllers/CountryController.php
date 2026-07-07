<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $countries = Country::query()

            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('cca3', 'like', "%{$search}%")
                      ->orWhere('region', 'like', "%{$search}%");
            })

            ->orderBy('name')

            ->paginate(15)

            ->withQueryString();

        return view('countries.index', compact('countries', 'search'));
    }

    public function show(Country $country)
    {
        return view('countries.show', compact('country'));
    }
}