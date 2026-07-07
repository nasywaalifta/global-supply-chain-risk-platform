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
        Schema::create('news_caches', function (Blueprint $table) {

            $table->id();

            $table->foreignId('country_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('title');

            $table->text('description')->nullable();

            $table->text('content')->nullable();

            $table->string('source')->nullable();

            $table->string('author')->nullable();

            $table->string('url')->nullable();

            $table->string('image_url')->nullable();

            $table->string('category')->nullable();

            $table->timestamp('published_at')->nullable();

            $table->enum('sentiment', [
                'Positive',
                'Neutral',
                'Negative'
            ])->default('Neutral');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news_caches');
    }
};