<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->integer('congestion_score')
                  ->default(0)
                  ->after('longitude');

            $table->string('congestion_level')
                  ->default('Low')
                  ->after('congestion_score');

        });
    }

    public function down(): void
    {
        Schema::table('ports', function (Blueprint $table) {

            $table->dropColumn([
                'congestion_score',
                'congestion_level'
            ]);

        });
    }
};