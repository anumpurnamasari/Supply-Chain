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

        Schema::create('countries', function (Blueprint $table) {


            $table->id();


            // kode negara
            // contoh: ID, DE, CN
            $table->string('country_code', 10)
                  ->unique();



            // nama negara
            // contoh: Indonesia, Germany
            $table->string('country_name');



            // ibu kota
            $table->string('capital')
                  ->nullable();



            // wilayah
            // contoh: Asia, Europe
            $table->string('region')
                  ->nullable();



            // kode mata uang
            // contoh: IDR, EUR
            $table->string('currency', 20)
                  ->nullable();



            // simbol mata uang
            // contoh: Rp, €
            $table->string('currency_symbol', 20)
                  ->nullable();



            // jumlah penduduk
            $table->bigInteger('population')
                  ->nullable();



            // koordinat untuk OpenMeteo & Leaflet
            $table->decimal(
                'latitude',
                10,
                6
            )->nullable();


            $table->decimal(
                'longitude',
                10,
                6
            )->nullable();



            // url bendera negara
            $table->text('flag')
                  ->nullable();



            // waktu terakhir sinkron API
            $table->timestamp('last_synced')
                  ->nullable();



            $table->timestamps();


        });

    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropIfExists('countries');

    }


};
