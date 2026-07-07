<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PortController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::get('/countries', [CountryController::class, 'index'])
    ->name('countries.index');

Route::get('/countries/{country}', [CountryController::class, 'show'])
    ->name('countries.show');

Route::get('/ports', [PortController::class, 'index'])
    ->name('ports.index');