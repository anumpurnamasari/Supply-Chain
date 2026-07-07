<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{

public function up(): void
{

Schema::table('risk_scores', function(Blueprint $table){


$table->integer('currency_score')
->default(0);


$table->integer('inflation_score')
->default(0);


$table->integer('news_score')
->default(0);


$table->integer('total_score')
->default(0);


});


}



public function down(): void
{

Schema::table('risk_scores', function(Blueprint $table){


$table->dropColumn([

'currency_score',
'inflation_score',
'news_score',
'total_score'

]);


});


}


};
