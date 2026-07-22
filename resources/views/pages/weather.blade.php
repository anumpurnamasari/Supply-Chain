@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>
        Weather Risk Monitoring
    </h2>

    <p>

        {{ $country->name }}

        | Open-Meteo API

    </p>

</div>



{{-- WEATHER SUMMARY --}}

<div class="row g-4">

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Temperature

            </h5>

            <h2>

                {{ number_format($weather->temperature ?? 0,1) }} °C

            </h2>

            <span>

                Current Temperature

            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Rainfall

            </h5>

            <h2>

                {{ number_format($weather->rainfall ?? 0,1) }} mm

            </h2>

            <span>

                Current Rainfall

            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Wind Speed

            </h5>

            <h2>

                {{ number_format($weather->wind_speed ?? 0,1) }} km/h

            </h2>

            <span>

                Current Wind

            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Storm Risk

            </h5>

            <h2>

                {{ $weather->storm_risk ?? 0 }} %

            </h2>

            <span>

                Weather Risk

            </span>

        </div>

    </div>

</div>



{{-- MAP + STATUS --}}

<div class="row g-4 mt-2">

    <div class="col-md-8">

        <div class="card-box">

            <h5>

                Global Weather Map

            </h5>

            <div
                id="weatherMap"
                style="height:500px;border-radius:15px;">
            </div>

        </div>

    </div>



    <div class="col-md-4">

        <div class="card-box">

            <h5>

                Weather Status

            </h5>

            <br>

            @php

                $status = "Normal Weather";

                if(($weather->storm_risk ?? 0) >= 70){

                    $status = "Storm Warning";

                }
                elseif(($weather->rainfall ?? 0) >= 20){

                    $status = "Heavy Rain";

                }
                elseif(($weather->wind_speed ?? 0) >= 40){

                    $status = "Strong Wind";

                }

            @endphp

            <h2>

                {{ $status }}

            </h2>

            <hr>
<div class="mt-3">

    <div class="d-flex justify-content-between mb-2">
        <span>Country</span>
        <strong>{{ $country->name }}</strong>
    </div>

    <div class="d-flex justify-content-between mb-2">
        <span>🌡 Temperature</span>
        <strong>{{ number_format($weather->temperature ?? 0,1) }} °C</strong>
    </div>

    <div class="d-flex justify-content-between mb-2">
        <span>🌧 Rainfall</span>
        <strong>{{ number_format($weather->rainfall ?? 0,1) }} mm</strong>
    </div>

    <div class="d-flex justify-content-between mb-2">
        <span>💨 Wind Speed</span>
        <strong>{{ number_format($weather->wind_speed ?? 0,1) }} km/h</strong>
    </div>

    <div class="d-flex justify-content-between mb-2">
        <span>⛈ Storm Risk</span>
        <strong>{{ $weather->storm_risk ?? 0 }} %</strong>
    </div>

    <div class="d-flex justify-content-between">
        <span>Risk Level</span>

        <span class="badge bg-success px-3">

            {{ $risk->risk_level ?? '-' }}

        </span>
    </div>

</div>

        </div>

        <!-- Weather Legend -->
        <div class="card-box mt-4">

            <h5 class="mb-3">Weather Legend</h5>

            <div class="d-flex align-items-center mb-2">
                <span class="me-2 rounded-circle"
                    style="width:12px;height:12px;background:#06D6A0;"></span>
                <small>Normal Weather</small>
            </div>

            <div class="d-flex align-items-center mb-2">
                <span class="me-2 rounded-circle"
                    style="width:12px;height:12px;background:#FFD166;"></span>
                <small>Heavy Rain</small>
            </div>

            <div class="d-flex align-items-center mb-2">
                <span class="me-2 rounded-circle"
                    style="width:12px;height:12px;background:#F77F00;"></span>
                <small>Strong Wind</small>
            </div>

            <div class="d-flex align-items-center">
                <span class="me-2 rounded-circle"
                    style="width:12px;height:12px;background:#EF476F;"></span>
                <small>Storm Warning</small>
            </div>

        </div>

    </div>

    </div>

</div>


@endsection



@section('script')

<script>

var map = L.map('weatherMap').setView(
    [20,0],
    2
);

L.tileLayer(
    'https://tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom:19
    }
).addTo(map);



let item = @json($selectedWeather);

if(item && item.country){

    let color = "#06D6A0";
    let status = "Normal";

    if(item.storm_risk >= 70){

        color = "#EF476F";
        status = "Storm Warning";

    }
    else if(item.wind_speed >= 40){

        color = "#F77F00";
        status = "Strong Wind";

    }
    else if(item.rainfall >= 20){

        color = "#FFD166";
        status = "Heavy Rain";

    }

    map.setView(
        [
            item.country.latitude,
            item.country.longitude
        ],
        5
    );

    L.circleMarker(
        [
            item.country.latitude,
            item.country.longitude
        ],
        {
            radius:14,
            color:"#00F5D4",
            weight:4,
            fillColor:color,
            fillOpacity:.9
        }
    )
    .addTo(map)
    .bindPopup(`
        <h5>${item.country.name}</h5>
        <hr>
        <b>Status :</b> ${status}<br><br>
        🌡 Temperature : ${item.temperature} °C<br>
        🌧 Rainfall : ${item.rainfall} mm<br>
        💨 Wind : ${item.wind_speed} km/h<br>
        ⛈ Storm Risk : ${item.storm_risk} %
    `)
    .openPopup();

}



</script>

@endsection
