<?php


namespace App\Services;


use App\Models\PositiveWord;
use App\Models\NegativeWord;


class SentimentService
{


public function analyze($text)
{


$text =
preg_replace(
'/[^a-zA-Z ]/',
'',
strtolower($text)
);


$words =
explode(
" ",
$text
);



$positive =
PositiveWord::pluck('word')
->toArray();


$negative =
NegativeWord::pluck('word')
->toArray();



$positiveScore=0;

$negativeScore=0;



foreach($words as $word){


if(
in_array($word,$positive)
){

$positiveScore++;

}


if(
in_array($word,$negative)
){

$negativeScore++;

}


}



if(
$positiveScore >
$negativeScore
){

return [

'type'=>'Positive',
'score'=>20

];

}



if(
$negativeScore >
$positiveScore
){

return [

'type'=>'Negative',
'score'=>80

];

}



return [

'type'=>'Neutral',
'score'=>40

];


}


}
