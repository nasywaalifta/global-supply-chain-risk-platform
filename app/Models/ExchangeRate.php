<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $fillable = [
        'currency',
        'code',
        'rate',
        'base_currency',
        'updated_at_api',
    ];

    protected $casts = [
        'updated_at_api' => 'datetime',
    ];
}