<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'port_id',
        'temperature',
        'humidity',
        'wind_speed',
        'condition',
        'weather_risk',
        'last_update',
    ];

    public function port()
    {
        return $this->belongsTo(Port::class);
    }
}