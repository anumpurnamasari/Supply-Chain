<?php

namespace App\Http\Controllers;


use App\Models\Country;
use App\Models\NewsCache;

use App\Services\NewsService;
use App\Services\SentimentService;


class NewsController extends Controller
{


public function sync(

NewsService $newsService,

SentimentService $sentimentService

)

{


$country =
Country::first();



$result =
$newsService
->getNews(
"business"
);


if(
!isset($result['articles'])
||
count($result['articles']) == 0
){


return "Tidak ada berita ditemukan";


}


NewsCache::truncate();


foreach(
$result['articles']
as $article
){



$text =

$article['title']
." "
.$article['description'];




$sentiment =
$sentimentService
->analyze(
$text
);





NewsCache::create([


'country_id'
=>
$country->id,


'title'
=>
$article['title'],


'description'
=>
$article['description'],


'source'
=>
$article['source']['name'],


'sentiment'
=>
$sentiment['type'],


'sentiment_score'
=>
$sentiment['score']


]);


}




return
"News Intelligence Updated";


}


}
