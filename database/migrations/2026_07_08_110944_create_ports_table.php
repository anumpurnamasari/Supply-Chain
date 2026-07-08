<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

    public function up(): void
    {

        Schema::create('ports', function(Blueprint $table){


            $table->id();


            $table
            ->foreignId('country_id')
            ->constrained()
            ->cascadeOnDelete();


            $table->string('name');


            $table->string('city')
            ->nullable();


            $table->decimal(
                'latitude',
                10,
                6
            );


            $table->decimal(
                'longitude',
                10,
                6
            );


            $table->string(
                'status'
            )
            ->default('Active');


            $table->string(
                'risk_level'
            )
            ->default('LOW');


            $table->timestamps();


        });

    }


    public function down(): void
    {

        Schema::dropIfExists('ports');

    }

};
