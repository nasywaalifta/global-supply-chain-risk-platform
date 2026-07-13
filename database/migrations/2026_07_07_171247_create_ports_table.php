<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ports', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->constrained()
                ->cascadeOnDelete();

            // UN/LOCODE (contoh: IDTPP, SGSIN, CNSHA)
            $table->string('code')->nullable();

            // Nama pelabuhan
            $table->string('name');

            // Kota
            $table->string('city')->nullable();

            // Koordinat
            $table->decimal('latitude', 10, 6)->nullable();
            $table->decimal('longitude', 10, 6)->nullable();

            // Jenis lokasi (Sea Port, River Port, dll)
            $table->string('type')->nullable();

            // Status dari dataset UN/LOCODE
            $table->string('status')->nullable();

            // Risk Score
            $table->integer('risk_score')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ports');
    }
};