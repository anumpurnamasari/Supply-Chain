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

    if ($request->filled('country_id')) {

        $country = Country::find($request->country_id);

    } else {

        $country = Country::where('code', 'ID')->first();

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
// UPDATE NEWS
// ======================

$cachedNews = NewsCache::where('country_id', $country->id)
    ->where('updated_at', '>=', now()->subHours(6))
    ->count();

if ($cachedNews == 0) {

    $result = $this->newsService->getNews($country->name);

    if (isset($result['articles'])) {


        NewsCache::where('country_id', $country->id)->delete();

        foreach ($result['articles'] as $article) {

            $text = ($article['title'] ?? '') . ' ' . ($article['description'] ?? '');

            $sentiment = $this->sentimentService->analyze($text);

            NewsCache::create([

                'country_id' => $country->id,

                'title' => $article['title'] ?? '-',

                'description' => $article['description'] ?? null,

                'source' => $article['source']['name'] ?? null,

                'url' => $article['url'] ?? null,

                'sentiment' => $sentiment['type'],

                'sentiment_score' => $sentiment['score']

            ]);

        }

    }

}

    // ======================
    // AUTO CALCULATE RISK
    // ======================

    $risk = null;

    if ($country) {

        $risk = $this->riskService->calculate(
            $country->id
        );

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

    $economic = EconomicData::where('country_id', $country->id ?? 0)
        ->latest()
        ->first();

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
            'riskChart'
        )
    );
}


}
