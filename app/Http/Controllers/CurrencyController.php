<?php


namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\CurrencyRate;
use App\Services\CurrencyService;



class CurrencyController extends Controller
{


public function sync(
CurrencyService $service
)
{


$country =
Country::first();



$rate =
$service
->getRate(
$country->currency
);



$risk = 0;



if($rate > 15000){

$risk = 50;

}
else{

$risk = 10;

}




CurrencyRate::create([

'country_id'
=>$country->id,


'currency'
=>$country->currency,


'exchange_rate'
=>$rate,


'currency_risk'
=>$risk


]);




return
"Currency berhasil update";


}


}
