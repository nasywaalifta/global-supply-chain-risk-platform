<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather', function (Blueprint $table) {

            $table->id();

            $table->foreignId('port_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->decimal('temperature',5,2)->nullable();

            $table->integer('humidity')->nullable();

            $table->decimal('wind_speed',5,2)->nullable();

            $table->string('condition')->nullable();

            $table->integer('weather_risk')->default(0);

            $table->timestamp('last_update')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather');
    }
};