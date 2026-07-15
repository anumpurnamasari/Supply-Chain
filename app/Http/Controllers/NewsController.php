<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\NewsCache;

use App\Services\NewsService;
use App\Services\SentimentService;


class NewsController extends Controller
{


public function sync(
    Request $request,
    NewsService $newsService,
    SentimentService $sentimentService
)
{


$country = Country::find($request->country_id);

if (!$country) {

    $country = Country::where('code', 'ID')->first();

}


$result = $newsService->getNews($country->name);


if(
!isset($result['articles'])
||
count($result['articles']) == 0
){


return "Tidak ada berita ditemukan";


}


NewsCache::where(
    'country_id',
    $country->id
)->delete();


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

    'country_id' => $country->id,

    'title' => $article['title'],

    'description' => $article['description'],

    'source' => $article['source']['name'] ?? null,

    'url' => $article['url'] ?? null,

    'sentiment' => $sentiment['type'],

    'sentiment_score' => $sentiment['score']

]);



}




return
"News Intelligence Updated";


}


}
