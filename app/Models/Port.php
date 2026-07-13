<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [

        'country_id',

        'code',

        'name',

        'city',

        'latitude',

        'longitude',

        'type',

        'status',

        'risk_score',

    ];

    /**
     * Relasi ke Country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Relasi ke Weather
     */
    public function weather()
    {
        return $this->hasOne(Weather::class);
    }
}