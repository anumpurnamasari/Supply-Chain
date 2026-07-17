<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->integer('storm_risk')->default(0)->after('wind_speed');
            $table->timestamp('last_synced')->nullable()->after('weather_code');
        });
    }

    public function down(): void
    {
        Schema::table('weather_data', function (Blueprint $table) {
            $table->dropColumn([
                'storm_risk',
                'last_synced'
            ]);
        });
    }
};
