<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Port extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_id',
        'name',
        'city',
        'latitude',
        'longitude',
        'type',
        'risk_score',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}