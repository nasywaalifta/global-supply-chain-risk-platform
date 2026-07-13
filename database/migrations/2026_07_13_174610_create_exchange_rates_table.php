<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exchange_rates', function (Blueprint $table) {

            $table->id();

            $table->string('currency');

            $table->string('code',10);

            $table->decimal('rate',15,6);

            $table->string('base_currency')->default('USD');

            $table->timestamp('updated_at_api')->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exchange_rates');
    }
};