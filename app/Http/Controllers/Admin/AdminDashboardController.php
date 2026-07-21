<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Port;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalPorts' => Port::count(),
            'totalArticles' => Article::count(),
        ]);
    }
}