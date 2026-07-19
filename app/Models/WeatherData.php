<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    protected $table = 'weather_data';

    protected $fillable = [
        'country_id',
        'temperature',
        'precipitation',
        'wind_speed',
        'storm_risk',
        'weather_code',
        'updated_at_api',
    ];

    protected $casts = [
        'temperature' => 'float',
        'precipitation' => 'float',
        'wind_speed' => 'float',
        'updated_at_api' => 'datetime',
    ];

    /**
     * Relasi ke Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}