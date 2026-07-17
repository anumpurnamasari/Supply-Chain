@extends('layouts.app')


@section('content')


<!-- HEADER -->

<div class="module-header">

<h2>
🌐 ChainPulse Command Center
</h2>

<p>
Global Supply Chain Risk Intelligence Overview
</p>

</div>

<div class="card-box mb-4">

    <div class="row align-items-center">

        <div class="col-md-6">

            <h5 class="mb-2">
                🌍 Select Country
            </h5>

            <small>
                Select a country to monitor supply chain risk.
            </small>

        </div>


        <div class="col-md-6">

            <form method="POST" action="{{ route('country.active') }}">

                @csrf

                    <select
                    name="country_id"
                    class="form-select"
                    onchange="this.form.submit()">

                    @foreach($countries as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ session('active_country', $country->id) == $item->id ? 'selected' : '' }}>

                            {{ $item->name }}

                        </option>

                    @endforeach

                    @php
    $isFavorite = \App\Models\Watchlist::where('country_id', $country->id)->exists();
@endphp

@if(!$isFavorite)

<form action="{{ route('watchlist.store', $country->id) }}" method="POST" class="mt-2">
    @csrf

    <button class="btn btn-warning btn-sm w-100">
        ⭐ Add to Watchlist
    </button>
</form>

@else

<form action="{{ route('watchlist.destroy', $country->id) }}" method="POST" class="mt-2">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger btn-sm w-100">
        Remove Favorite
    </button>
</form>

@endif

                </select>

            </form>

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

            <h2>

                @if($economic && $economic->gdp)

                    {{ number_format($economic->gdp / 1000000000, 2) }} B

                @else

                    -

                @endif

            </h2>

            <span>

                Gross Domestic Product

            </span>

        </div>

    </div>



    <!-- Inflation -->

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Inflation
            </h5>

            <h2>

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

            <h2>

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

            <h2>

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

<p class="mb-3">

{{ $country->name }}

</p>


<canvas id="riskChart"></canvas>



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

                    <h3>

                        {{ number_format($weather->temperature ?? 0,1) }} °C

                    </h3>

                </div>

                <div class="col-6 mb-4">

                    <h6>Rainfall</h6>

                    <h3>

                        {{ number_format($weather->rainfall ?? 0,1) }} mm

                    </h3>

                </div>

                <div class="col-6">

                    <h6>Wind Speed</h6>

                    <h3>

                        {{ number_format($weather->wind_speed ?? 0,1) }} km/h

                    </h3>

                </div>

                <div class="col-6">

                    <h6>Storm Risk</h6>

                    <h3>

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

                    <strong>

                        {{ $weather->weather_code ?? '-' }}

                    </strong>

                </div>

                <div class="col-6 text-end">

                    <small>

                        Updated

                    </small>

                    <br>

                    <strong>

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

            <div class="alert-list">

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


// ======================
// CHART
// ======================


new Chart(

document.getElementById(
'riskChart'
),


{


type:'doughnut',



data:{


labels:[

'Weather',

'Inflation',

'Currency',

'News'

],



datasets:[{


data:[

{{ $risk->weather_score ?? 0 }},

{{ $risk->inflation_score ?? 0 }},

{{ $risk->currency_score ?? 0 }},

{{ $risk->news_score ?? 0 }}


]


}]


}


}

);







// ======================
// GLOBAL RISK MAP
// ======================


var map =
L.map('map')
.setView(

[
{{ $country->latitude }},
{{ $country->longitude }}
],

5

);



L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

)
.addTo(map);






// ======================
// ACTIVE COUNTRY MARKER
// ======================


let country = {


name:

"{{ $country->name ?? 'Unknown' }}",


lat:

{{ $country->latitude ?? -6.2 }},


lng:

{{ $country->longitude ?? 106.8 }},


risk:

"{{ $risk->risk_level ?? 'LOW' }}",


score:

{{ $risk->total_score ?? 0 }}


};





let markerColor;


if(
country.risk == "HIGH"
){

markerColor =
"🔴";

}
else if(
country.risk == "MEDIUM"
){

markerColor =
"🟡";

}
else{

markerColor =
"🟢";

}


L.marker([
    country.lat,
    country.lng
])

.addTo(map)

.bindPopup(`

<b>${country.name}</b>

<hr>

GDP :
{{ number_format(($economic->gdp ?? 0) / 1000000000,2) }} B

<br>

Inflation :
{{ number_format($economic->inflation ?? 0,2) }} %

<br>

Temperature :
{{ number_format($weather->temperature ?? 0,1) }} °C

<br>

Risk :
${country.risk}

(${country.score}%)

`);


</script>


@endsection

