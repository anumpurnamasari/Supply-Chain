<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('economic_data', function (Blueprint $table) {

            $table->bigInteger('population')
                ->nullable()
                ->after('inflation');

            $table->decimal('exports',20,2)
                ->nullable()
                ->after('population');

            $table->decimal('imports',20,2)
                ->nullable()
                ->after('exports');

        });
    }

    public function down(): void
    {
        Schema::table('economic_data', function (Blueprint $table) {

            $table->dropColumn([
                'population',
                'exports',
                'imports'
            ]);

        });
    }
};
