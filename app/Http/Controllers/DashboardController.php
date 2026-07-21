<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\WeatherData;
use App\Models\RiskScore;
use App\Services\RiskCalculatorService;
use App\Models\Port;
use App\Models\CurrencyRate;
use App\Models\EconomicData;
use App\Models\NewsCache;
use App\Services\NewsService;
use App\Services\SentimentService;
use App\Services\WeatherService;
use App\Services\WorldBankService;
use App\Services\CurrencyService;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{


    private RiskCalculatorService $riskService;
    private NewsService $newsService;
    private SentimentService $sentimentService;
    private WeatherService $weatherService;
    private WorldBankService $worldBankService;
    private CurrencyService $currencyService;


    public function __construct(
        RiskCalculatorService $riskService,
        NewsService $newsService,
        SentimentService $sentimentService,
        WeatherService $weatherService,
        WorldBankService $worldBankService,
        CurrencyService $currencyService

    )
    {

        $this->riskService = $riskService;
        $this->newsService = $newsService;
        $this->sentimentService = $sentimentService;
        $this->weatherService = $weatherService;
        $this->worldBankService = $worldBankService;
        $this->currencyService = $currencyService;


    }




    public function index(Request $request)
{


    // ======================
    // LIST COUNTRY
    // ======================

    $countries = Country::orderBy('name')->get();

    // ======================
    // ACTIVE COUNTRY
    // ======================

    $countryId = session('active_country');

    if ($countryId) {

        $country = Country::find($countryId);

    } else {

        $country = Country::where('code', 'ID')->first();

        session([
            'active_country' => $country->id
        ]);

    }

    // ======================
// WEATHER
// ======================

$this->weatherService->syncWeather($country);

// ======================
// WORLD BANK
// ======================

$economic = $this->worldBankService->getEconomic(
    $country->code
);

// ======================
// CURRENCY
// ======================

$this->currencyService->syncCurrency($country);


    // ======================
    // AUTO CALCULATE RISK
    // ======================

    $risk = null;

    if ($country) {

        $risk = $this->riskService->calculate(
            $country->id
        );

    }

    $cachedNews = NewsCache::where('country_id', $country->id)
    ->where('updated_at', '>=', now()->subHours(6))
    ->exists();


    if (!$cachedNews) {

    $result = $this->newsService->getNews($country->name);

    if (isset($result['articles'])) {

        NewsCache::where('country_id', $country->id)->delete();

        foreach ($result['articles'] as $article) {

            $text = ($article['title'] ?? '') . ' ' . ($article['description'] ?? '');

            $sentiment = $this->sentimentService->analyze($text);

            NewsCache::create([
                'country_id'      => $country->id,
                'title'           => $article['title'] ?? '-',
                'description'     => $article['description'] ?? null,
                'source'          => $article['source']['name'] ?? null,
                'url'             => $article['url'] ?? null,
                'image'           => $article['image'] ?? null,
                'published_at' => isset($article['publishedAt']) ? date('Y-m-d H:i:s', strtotime($article['publishedAt'])): null,
                'sentiment'       => $sentiment['type'],
                'sentiment_score' => $sentiment['score']
            ]);
        }
    }
}

    // ======================
    // DATA BERDASARKAN NEGARA
    // ======================

    $weather = WeatherData::where('country_id', $country->id ?? 0)
        ->latest()
        ->first();

    $currency = CurrencyRate::where('country_id', $country->id ?? 0)
        ->latest()
        ->first();

    $economic = EconomicData::where('country_id', $country->id)
    ->where(function ($q) {
        $q->where('gdp', '>', 0)
          ->orWhere('inflation', '>', 0);
    })
    ->latest()
    ->first();

    $economicTrend = EconomicData::where('country_id', $country->id)
    ->where('gdp', '>', 0)
    ->orderBy('created_at', 'asc')
    ->get();

    $currencyTrend = CurrencyRate::where('country_id', $country->id)
        ->orderBy('created_at')
        ->take(10)
        ->get();

    $riskTrend = RiskScore::where('country_id', $country->id)
        ->orderBy('created_at')
        ->take(10)
        ->get();

    $news = NewsCache::where('country_id', $country->id)
        ->latest()
        ->take(5)
        ->get();

    $ports = Port::all();

    // ======================
    // CHART
    // ======================

    $riskChart = [

        'Weather'   => $risk->weather_score ?? 0,
        'Currency'  => $risk->currency_score ?? 0,
        'Inflation' => $risk->inflation_score ?? 0,
        'News'      => $risk->news_score ?? 0,
        'Total'     => $risk->total_score ?? 0,

    ];

    return view(
    'dashboard',
    compact(
        'countries',
        'country',
        'weather',
        'risk',
        'ports',
        'currency',
        'economic',
        'news',
        'riskChart',

        'economicTrend',
        'currencyTrend',
        'riskTrend'
    )
);
}

public function countryData(Country $country)
{

    $this->weatherService->syncWeather($country);

    $weather = WeatherData::where('country_id', $country->id)
        ->latest()
        ->first();

    $currency = CurrencyRate::where('country_id', $country->id)
        ->latest()
        ->first();

    $economic = EconomicData::where('country_id', $country->id)
        ->latest()
        ->first();

    $economicTrend = EconomicData::where('country_id', $country->id)
    ->where('gdp', '>', 0)
    ->orderBy('created_at', 'asc')
    ->get();

    $currencyTrend = CurrencyRate::where('country_id', $country->id)
        ->orderBy('created_at')
        ->take(10)
        ->get();

    $riskTrend = RiskScore::where('country_id', $country->id)
        ->orderBy('created_at')
        ->take(10)
        ->get();

    $risk = RiskScore::where('country_id', $country->id)
        ->latest()
        ->first();

    $news = NewsCache::where('country_id', $country->id)
    ->latest()
    ->take(5)
    ->get();

    return response()->json([
    'country'         => $country,
    'weather'         => $weather,
    'currency'        => $currency,
    'economic'        => $economic,
    'risk'            => $risk,
    'news'            => $news,

    'economicTrend'   => $economicTrend,
    'currencyTrend'   => $currencyTrend,
    'riskTrend'       => $riskTrend,
]);
}

public function setActiveCountry(Request $request)
{
    session([
        'active_country' => $request->country_id
    ]);

    return response()->json([
        'success' => true
    ]);
}


}
