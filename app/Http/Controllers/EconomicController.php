<?php


namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\EconomicData;
use App\Services\WorldBankService;



class EconomicController extends Controller
{


public function sync(
WorldBankService $service
)
{


$country =
Country::first();



$data =
$service->getEconomic(

$country->code

);




$risk = 0;



if(
$data['inflation']
> 10
){

$risk = 80;

}

elseif(
$data['inflation']
> 5
){

$risk = 50;

}

else{


$risk = 20;


}




EconomicData::create([


'country_id'
=>$country->id,


'gdp'
=>$data['gdp'],


'inflation'
=>$data['inflation'],


'economic_risk'
=>$risk


]);




return
"Economic data updated";


}


}
