<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\NewsCache;
use App\Services\NewsService;
use App\Services\SentimentService;

class NewsController extends Controller
{

    // ======================================
    // NEWS PAGE
    // ======================================

    public function index()
    {

        $country = Country::find(
            session('active_country')
        );

        if (!$country) {

            $country = Country::where(
                'code',
                'ID'
            )->first();

        }

        $news = NewsCache::where(
            'country_id',
            $country->id
        )
        ->latest()
        ->paginate(10);

        $positive = NewsCache::where('country_id', $country->id)
            ->where('sentiment', 'Positive')
            ->count();

        $neutral = NewsCache::where('country_id', $country->id)
            ->where('sentiment', 'Neutral')
            ->count();

        $negative = NewsCache::where('country_id', $country->id)
            ->where('sentiment', 'Negative')
            ->count();

        return view(
            'pages.news',
            compact(
                'country',
                'news',
                'positive',
                'neutral',
                'negative'
            )
        );

    }



    // ======================================
    // SYNC NEWS FROM GNEWS
    // ======================================

    public function sync(
        Request $request,
        NewsService $newsService,
        SentimentService $sentimentService
    )
    {

        $country = Country::find(
            $request->country_id
        );

        if (!$country) {

            $country = Country::where(
                'code',
                'ID'
            )->first();

        }

        $result = $newsService->getNews(
            $country->name
        );

        if (isset($result['articles'])) {
    $result['articles'] = collect($result['articles'])
        ->unique(function ($article) {
            // Jika URL ada, gunakan URL sebagai kunci
            return $article['url'] ?? ($article['title'] ?? '');
        })
        ->values()
        ->toArray();
}

        if (
            !isset($result['articles']) ||
            count($result['articles']) == 0
        ) {

            return back()->with(
                'error',
                'No news available for this country.'
            );

        }

        NewsCache::where(
            'country_id',
            $country->id
        )->delete();

        foreach ($result['articles'] as $article) {

            if (
                NewsCache::where('country_id', $country->id)
                    ->where('title', $article['title'] ?? '')
                    ->exists()
            ) {
                continue;
            }

            $text =
                ($article['title'] ?? '') . ' ' .
                ($article['description'] ?? '');

            $sentiment = $sentimentService->analyze($text);

            $lowerText = strtolower($text);

            $category = 'Economy';

            if (str_contains($lowerText, 'logistics')) {

                $category = 'Logistics';

            } elseif (
                str_contains($lowerText, 'shipping') ||
                str_contains($lowerText, 'ship') ||
                str_contains($lowerText, 'port')
            ) {

                $category = 'Shipping';

            } elseif (
                str_contains($lowerText, 'trade') ||
                str_contains($lowerText, 'export') ||
                str_contains($lowerText, 'import')
            ) {

                $category = 'Trade';

            }

            NewsCache::create([

                'country_id' => $country->id,

                'title' => $article['title'] ?? '-',

                'description' => $article['description'] ?? null,

                'source' => $article['source']['name'] ?? null,

                'url' => $article['url'] ?? null,

                'image' => $article['image'] ?? null,

                'published_at' => isset($article['publishedAt'])
                ? date('Y-m-d H:i:s', strtotime($article['publishedAt']))
                : null,

                'category' => $category,

                'sentiment' => $sentiment['type'],

                'sentiment_score' => $sentiment['score']

            ]);

        }


        return "News Intelligence Updated";

    }

}
