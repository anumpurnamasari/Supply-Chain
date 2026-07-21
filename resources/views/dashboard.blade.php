@php
use Illuminate\Support\Facades\Auth;
@endphp

@extends('layouts.app')


@section('content')


<!-- HEADER -->

<div class="admin-header">

    <div class="admin-info">

        <div class="admin-icon">
            <i class="bi bi-person-circle"></i>
        </div>

        <div>
            <h2>Welcome, {{ Auth::user()->name }}</h2>
            <p>user Access</p>
        </div>

    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>

</div>

<div class="card-box mb-4">

    <div class="row align-items-center">

        <div class="col-md-6">

            <h5 class="mb-2">
                Select Country
            </h5>

            <small>
                Select a country to monitor supply chain risk.
            </small>

        </div>


        <div class="col-md-6">


            <select id="countrySelect" class="form-select">
    @foreach($countries as $item)
        <option
            value="{{ $item->id }}"
            {{ session('active_country', $country->id) == $item->id ? 'selected' : '' }}>
            {{ $item->name }}
        </option>
    @endforeach
</select>

@php
    $isFavorite = \App\Models\Watchlist::where('country_id',$country->id)->exists();
@endphp

@if(!$isFavorite)
<form action="{{ route('watchlist.store',$country->id) }}" method="POST" class="mt-2">
    @csrf
    <button class="btn btn-warning btn-sm w-100">
        ⭐ Add to Watchlist
    </button>
</form>
@else
<form action="{{ route('watchlist.destroy',$country->id) }}" method="POST" class="mt-2">
    @csrf
    @method('DELETE')
    <button class="btn btn-danger btn-sm w-100">
        Remove Favorite
    </button>
</form>
@endif

        </div>

    </div>

</div>



<!-- KPI SUMMARY -->

<div class="row g-4">

    <!-- GDP -->

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                GDP
            </h5>

            <h2 id="gdpValue">

                @if($economic && $economic->gdp)

                    {{ number_format($economic->gdp / 1000000000, 2) }} B

                @else

                    -

                @endif

            </h2>

            <span>

                GrossDomesticProduct

            </span>

        </div>

    </div>



    <!-- Inflation -->

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Inflation
            </h5>

            <h2 id="inflationValue">

                {{ number_format($economic->inflation ?? 0, 2) }}%

            </h2>

            <span>

                Current Inflation Rate

            </span>

        </div>

    </div>



    <!-- Population -->

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Population
            </h5>

            <h2 id="populationValue">

                {{ number_format(($country->population ?? 0) / 1000000, 1) }} M

            </h2>

            <span>

                Total Population

            </span>

        </div>

    </div>



    <!-- Currency -->

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Currency
            </h5>

            <h2 id="currencyValue">

                {{ $country->currency ?? '-' }}

            </h2>

            <span>

                @if($currency)

                    1 USD =
                    {{ number_format($currency->exchange_rate, 2) }}
                    {{ $country->currency }}

                @else

                    Exchange Rate Unavailable

                @endif

            </span>

        </div>

    </div>

</div>


<!-- CHART + MAP -->


<div class="row g-4 mt-2">


<div class="col-md-6">


<div class="card-box analytics-card">


<h5>
Supply Chain Risk Composition
</h5>

<p class="mb-3" id="countryName">

{{ $country->name }}

</p>


<canvas id="riskChart"></canvas>

<div class="row g-4 mt-3">

    <div class="col-md-6">
        <div class="card-box analytics-card">
            <h5>GDP Trend</h5>
            <canvas id="gdpTrendChart"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box analytics-card">
            <h5>Inflation Trend</h5>
            <canvas id="inflationTrendChart"></canvas>
        </div>
    </div>

</div>

<div class="row g-4 mt-3">

    <div class="col-md-6">
        <div class="card-box analytics-card">
            <h5>Currency Trend</h5>
            <canvas id="currencyTrendChart"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card-box analytics-card">
            <h5>Risk Trend</h5>
            <canvas id="riskTrendChart"></canvas>
        </div>
    </div>

</div>



</div>


</div>






<div class="col-md-6">


<div class="card-box analytics-card">


<h5>
🌍 Global Risk Monitoring Map
</h5>


<div id="map"></div>















</div>


</div>


</div>

<!-- INFO -->

<div class="row g-4 mt-2">

    <!-- CURRENT WEATHER -->

    <div class="col-md-6">

        <div class="card-box analytics-card">

            <h5>

                CURRENT WEATHER

            </h5>

            <div class="row mt-4">

                <div class="col-6 mb-4">

                    <h6>Temperature</h6>

                    <h3 id="temperatureValue">

                        {{ number_format($weather->temperature ?? 0,1) }} °C

                    </h3>

                </div>

                <div class="col-6 mb-4">

                    <h6>Rainfall</h6>

                    <h3 id="rainfallValue">

                        {{ number_format($weather->rainfall ?? 0,1) }} mm

                    </h3>
                </div>

                <div class="col-6">

                    <h6>Wind Speed</h6>

                    <h3 id="windValue">

                        {{ number_format($weather->wind_speed ?? 0,1) }} km/h

                    </h3>

                </div>

                <div class="col-6">

                    <h6>Storm Risk</h6>

                    <h3 id="stormValue">

                        {{ $weather->storm_risk ?? 0 }} %

                    </h3>

                </div>

            </div>

            <hr>

            <div class="row">

                <div class="col-6">

                    <small>

                        Weather Code

                    </small>

                    <br>

                    <strong id="weatherCodeValue">

                        {{ $weather->weather_code ?? '-' }}

                    </strong>

                </div>

                <div class="col-6 text-end">

                    <small>

                        Updated

                    </small>

                    <br>

                    <strong id="weatherUpdatedValue">

                        {{ optional($weather->updated_at)->format('d M Y H:i') }}

                    </strong>

                </div>

            </div>

        </div>

    </div>



    <!-- LATEST NEWS -->

    <div class="col-md-6">

        <div class="card-box analytics-card">

            <h5>

                LATEST NEWS

            </h5>

            <div class="alert-list" id="newsContainer">

                @forelse($news as $item)

                    <div class="alert-item">

                        <h6>

                            <a

                                href="{{ $item->url }}"

                                target="_blank"

                                style="color:white;text-decoration:none;">

                                {{ $item->title }}

                            </a>

                        </h6>

                        <span>

                            {{ $item->source }}

                            <br>

                            Sentiment :

                            {{ $item->sentiment }}

                            |

                            Score :

                            {{ $item->sentiment_score }}

                        </span>

                    </div>

                @empty

                    <p>

                        No news available.

                    </p>

                @endforelse

            </div>

        </div>

    </div>

</div>

@endsection



@section('script')

<script>

const economicTrend = @json($economicTrend);
const currencyTrend = @json($currencyTrend);
const riskTrend = @json($riskTrend);

const riskChart = new Chart(
    document.getElementById('riskChart'),
    {
        type: 'doughnut',
        data: {
            labels: [
                'Weather',
                'Inflation',
                'Currency',
                'News'
            ],
            datasets: [{
                data: [
                    {{ $risk->weather_score ?? 0 }},
                    {{ $risk->inflation_score ?? 0 }},
                    {{ $risk->currency_score ?? 0 }},
                    {{ $risk->news_score ?? 0 }}
                ]
            }]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false
        }
    }
);

const gdpTrendChart = new Chart(
    document.getElementById('gdpTrendChart'),
    {
        type: 'line',
        data: {
            labels: economicTrend.map(item =>
                new Date(item.created_at).toLocaleDateString('id-ID')
            ),
            datasets: [{
                label: 'GDP',
                data: economicTrend.map(item =>
                    item.gdp / 1000000000
                ),
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    }
);

const inflationTrendChart = new Chart(
    document.getElementById('inflationTrendChart'),
    {
        type: 'line',
        data: {
            labels: economicTrend.map(item =>
                new Date(item.created_at).toLocaleDateString('id-ID')
            ),
            datasets: [{
                label: 'Inflation (%)',
                data: economicTrend.map(item => item.inflation),
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    }
);

const currencyTrendChart = new Chart(
    document.getElementById('currencyTrendChart'),
    {
        type:'line',
        data:{
            labels:currencyTrend.map(item =>
                new Date(item.created_at).toLocaleDateString()
            ),
            datasets:[{
                label:'Exchange Rate',
                data:currencyTrend.map(item=>item.exchange_rate),
                tension:0.4
            }]
        },
        options:{
            responsive:true
        }
    }
);

const riskTrendChart = new Chart(
    document.getElementById('riskTrendChart'),
    {
        type:'line',
        data:{
            labels:riskTrend.map(item =>
                new Date(item.created_at).toLocaleDateString()
            ),
            datasets:[{
                label:'Risk Score',
                data:riskTrend.map(item=>item.total_score),
                tension:0.4
            }]
        },
        options:{
            responsive:true
        }
    }
);

const map = L.map('map').setView([
    {{ $country->latitude ?? -6.2 }},
    {{ $country->longitude ?? 106.8 }}
],5);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom:19,
        attribution:'© OpenStreetMap'
    }
).addTo(map);

// ======================================
// COUNTRY OBJECT
// ======================================

let currentCountry = {
    name: "{{ $country->name }}",
    lat: {{ $country->latitude ?? -6.2 }},
    lng: {{ $country->longitude ?? 106.8 }},
    risk: "{{ $risk->risk_level ?? 'LOW' }}",
    score: {{ $risk->total_score ?? 0 }}
};

// ======================================
// MARKER
// ======================================

let marker = L.marker([
    currentCountry.lat,
    currentCountry.lng
]).addTo(map);

marker.bindPopup(`
<b>${currentCountry.name}</b>
<br>
Risk :
${currentCountry.risk}
(${currentCountry.score}%)
`);

// ======================================
// COUNTRY SELECT
// ======================================

const countrySelect = document.getElementById('countrySelect');

countrySelect.addEventListener('change',function(){

fetch("{{ route('dashboard.active-country') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify({
        country_id: this.value
    })
});

fetch("{{ url('/dashboard/country') }}/"+this.value)

.then(response=>response.json())

.then(data=>{

// ======================================
// COUNTRY
// ======================================

document.getElementById('countryName').innerHTML =
data.country.name;

// ======================================
// GDP
// ======================================

document.getElementById('gdpValue').innerHTML =
data.economic
? (data.economic.gdp/1000000000).toFixed(2)+' B'
: '-';

// ======================================
// INFLATION
// ======================================

document.getElementById('inflationValue').innerHTML =
data.economic
? Number(data.economic.inflation).toFixed(2)+'%'
: '-';

// ======================================
// POPULATION
// ======================================

document.getElementById('populationValue').innerHTML =
(data.country.population/1000000).toFixed(1)+' M';

// ======================================
// CURRENCY
// ======================================

document.getElementById('currencyValue').innerHTML =
data.country.currency ?? '-';

// ======================================
// WEATHER
// ======================================

document.getElementById('temperatureValue').innerHTML =
data.weather
? Number(data.weather.temperature).toFixed(1)+' °C'
: '-';

document.getElementById('rainfallValue').innerHTML =
data.weather
? Number(data.weather.rainfall).toFixed(1)+' mm'
: '-';

document.getElementById('windValue').innerHTML =
data.weather
? Number(data.weather.wind_speed).toFixed(1)+' km/h'
: '-';

document.getElementById('stormValue').innerHTML =
data.weather
? data.weather.storm_risk+' %'
: '-';

document.getElementById('weatherCodeValue').innerHTML =
data.weather
? data.weather.weather_code
: '-';

document.getElementById('weatherUpdatedValue').innerHTML =
data.weather
? new Date(data.weather.updated_at).toLocaleString()
: '-';

// ======================================
// UPDATE CHART
// ======================================

riskChart.data.datasets[0].data = [
    data.risk ? data.risk.weather_score : 0,
    data.risk ? data.risk.inflation_score : 0,
    data.risk ? data.risk.currency_score : 0,
    data.risk ? data.risk.news_score : 0
];

riskChart.update();

// ======================================
// UPDATE GDP TREND
// ======================================

gdpTrendChart.data.labels = data.economicTrend.map(item =>
    new Date(item.created_at).toLocaleDateString('id-ID')
);

gdpTrendChart.data.datasets[0].data = data.economicTrend.map(item =>
    item.gdp / 1000000000
);

gdpTrendChart.update();

// ======================================
// UPDATE INFLATION TREND
// ======================================

inflationTrendChart.data.labels = data.economicTrend.map(item =>
    new Date(item.created_at).toLocaleDateString('id-ID')
);

inflationTrendChart.data.datasets[0].data = data.economicTrend.map(item =>
    item.inflation
);

inflationTrendChart.update();

// ======================================
// UPDATE CURRENCY TREND
// ======================================

currencyTrendChart.data.labels = data.currencyTrend.map(item =>
    new Date(item.created_at).toLocaleDateString('id-ID')
);

currencyTrendChart.data.datasets[0].data = data.currencyTrend.map(item =>
    item.exchange_rate
);

currencyTrendChart.update();

// ======================================
// UPDATE RISK TREND
// ======================================

riskTrendChart.data.labels = data.riskTrend.map(item =>
    new Date(item.created_at).toLocaleDateString('id-ID')
);

riskTrendChart.data.datasets[0].data = data.riskTrend.map(item =>
    item.total_score
);

riskTrendChart.update();

// ======================================
// UPDATE MAP
// ======================================

marker.setLatLng([
    data.country.latitude,
    data.country.longitude
]);

marker.bindPopup(`
<b>${data.country.name}</b>
<br>
Risk :
${data.risk ? data.risk.risk_level : '-'}
(${data.risk ? data.risk.total_score : 0}%)
`);

map.setView([
    data.country.latitude,
    data.country.longitude
],5);

// ======================================
// UPDATE NEWS
// ======================================

let html = '';

if (data.news && data.news.length > 0) {

    data.news.forEach(function(item){

        html += `
        <div class="alert-item">

            <h6>
                <a href="${item.url}"
                   target="_blank"
                   style="color:white;text-decoration:none;">
                    ${item.title}
                </a>
            </h6>

            <span>
                ${item.source}<br>
                Sentiment : ${item.sentiment} |
                Score : ${item.sentiment_score}
            </span>

        </div>
        `;

    });

} else {

    html = `<p>No news available.</p>`;

}

document.getElementById('newsContainer').innerHTML = html;

}) // end then

.catch(error=>{
    console.error(error);
});

}); // end change event

</script>

@endsection
