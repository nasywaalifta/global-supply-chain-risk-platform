<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;

class PortController extends Controller
{
    /**
     * Menampilkan daftar pelabuhan
     */
    public function index(Request $request)
    {
        $search = $request->search;

        $ports = Port::with('country')

            ->when($search, function ($query) use ($search) {

                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('city', 'like', "%{$search}%");

            })

            ->orderBy('name')

            ->paginate(10)

            ->withQueryString();

        return view('ports.index', compact('ports', 'search'));
    }
}