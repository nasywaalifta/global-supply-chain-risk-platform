<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\PortController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GNewsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ExchangeRateController;
use App\Http\Controllers\WatchlistController;
use App\Http\Controllers\ComparisonController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CountryWeatherController;
use App\Http\Controllers\VisualizationController;
use App\Http\Controllers\RiskScoreController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\Admin\AdminDashboardController;

/*
|--------------------------------------------------------------------------
| Homepage
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('dashboard');
});

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Countries
    |--------------------------------------------------------------------------
    */

    Route::get('/countries', [CountryController::class, 'index'])
        ->name('countries.index');

    Route::get('/countries/{country}', [CountryController::class, 'show'])
        ->name('countries.show');

    /*
    |--------------------------------------------------------------------------
    | Ports
    |--------------------------------------------------------------------------
    */

    Route::get('/ports', [PortController::class, 'index'])
        ->name('ports.index');

    Route::post('/ports/sync', [PortController::class, 'sync'])
    ->name('ports.sync');

    /*
    |--------------------------------------------------------------------------
    | Weather
    |--------------------------------------------------------------------------
    */

    Route::get('/weather', [WeatherController::class, 'index'])
    ->name('weather.index');

    /*
    |--------------------------------------------------------------------------
    | News
    |--------------------------------------------------------------------------
    */

    Route::get('/news', [GNewsController::class, 'index'])
            ->name('news.index');

    /*
    |--------------------------------------------------------------------------
    | Exchange Rates
    |--------------------------------------------------------------------------
    */

    Route::get('/exchange-rates', [ExchangeRateController::class, 'index'])
        ->name('exchange-rates.index');

    Route::post('/exchange-rates/sync', [ExchangeRateController::class, 'sync'])
    ->name('exchange-rates.sync');
    
    Route::get('/risk-score', [RiskScoreController::class, 'index'])
    ->name('risk-score.index');

    Route::post('/risk-score/update', [RiskScoreController::class, 'update'])
    ->name('risk-score.update');

    Route::get('/currencies', [CurrencyController::class, 'index'])
    ->name('currencies.index');

    /*
    |--------------------------------------------------------------------------
    | Visualisasi Data
    |--------------------------------------------------------------------------
    */

    Route::get('/visualisasi', [VisualizationController::class, 'index'])
        ->name('visualisasi.index');
        
    Route::get('/visualisasi/data/{country}', [VisualizationController::class, 'getCountryData'])
    ->name('visualisasi.data');
    /*
    |--------------------------------------------------------------------------
    | Watchlist (Daftar Pantau)
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/daftar-pantau', [WatchlistController::class, 'index'])
        ->name('watchlist.index');

    Route::post('/dashboard/daftar-pantau', [WatchlistController::class, 'store'])
        ->name('watchlist.store');

    Route::delete('/dashboard/daftar-pantau/{watchlist}', [WatchlistController::class, 'destroy'])
        ->name('watchlist.destroy');

    /*
    |--------------------------------------------------------------------------
    | Perbandingan Negara
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/perbandingan', [ComparisonController::class, 'index'])
        ->name('comparison.index');

    Route::post('/dashboard/perbandingan', [ComparisonController::class, 'compare'])
        ->name('comparison.compare');

    /*
    |--------------------------------------------------------------------------
    | Artikel Analisis
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard/artikel', [ArticleController::class, 'index'])
        ->name('articles.index');

    Route::get('/dashboard/artikel/{slug}', [ArticleController::class, 'show'])
        ->name('articles.show');

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::middleware(['admin'])->prefix('admin')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');
        
        Route::resource('users', \App\Http\Controllers\Admin\UserManagementController::class)
            ->names('admin.users');

        Route::post('ports/sync', [\App\Http\Controllers\Admin\PortManagementController::class, 'sync'])
            ->name('admin.ports.sync');
        Route::resource('ports', \App\Http\Controllers\Admin\PortManagementController::class)
            ->names('admin.ports');

        Route::resource('articles', \App\Http\Controllers\Admin\ArticleManagementController::class)
            ->names('admin.articles');

    });
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Laravel Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';