<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

public function up(): void
{

Schema::create('currency_rates', function (Blueprint $table){


$table->id();


$table
->foreignId('country_id')
->constrained()
->cascadeOnDelete();


$table->string('currency');


$table->decimal(
'exchange_rate',
15,
4
);


$table->integer(
'currency_risk'
);


$table->timestamps();


});


}



public function down(): void
{

Schema::dropIfExists(
'currency_rates'
);

}


};
