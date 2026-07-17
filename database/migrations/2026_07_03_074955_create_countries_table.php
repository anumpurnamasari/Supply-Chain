<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('code')->nullable();

            $table->decimal('latitude', 10, 6)->default(0);
            $table->decimal('longitude', 10, 6)->default(0);

            $table->string('currency')->nullable();

            $table->string('region')->nullable();
            $table->bigInteger('population')->default(0);
            $table->string('flag')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
