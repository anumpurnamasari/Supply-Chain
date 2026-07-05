<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('weather_data', function (Blueprint $table) {
            $table->id();

            $table->foreignId('country_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->float('temperature');
            $table->float('rainfall');
            $table->float('wind_speed');

            $table->integer('weather_code')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('weather_data');
    }
};
