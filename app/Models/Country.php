<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',

        'official_name',

        'cca2',

        'cca3',

        'capital',

        'region',

        'subregion',

        'population',

        'area',

        'currency_code',

        'currency_name',

        'currency_symbol',

        'language',

        'flag_png',

        'flag_svg',

        'latitude',

        'longitude',

        'timezones',

        'google_maps'

    ];

    /**
     * Relasi ke tabel ports
     */
    public function ports()
    {
        return $this->hasMany(Port::class);
    }

    /**
     * Relasi ke tabel risk_scores
     */
    public function riskScore()
    {
        return $this->hasOne(RiskScore::class);
    }

    /**
     * Relasi ke tabel articles
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    /**
     * Relasi ke tabel watchlists
     */
    public function watchlists()
    {
        return $this->hasMany(Watchlist::class);
    }
}