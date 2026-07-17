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

            <table class="table table-dark">

                <tr>

                    <td>Country</td>

                    <td>{{ $country->name }}</td>

                </tr>

                <tr>

                    <td>Temperature</td>

                    <td>{{ number_format($weather->temperature ?? 0,1) }} °C</td>

                </tr>

                <tr>

                    <td>Rainfall</td>

                    <td>{{ number_format($weather->rainfall ?? 0,1) }} mm</td>

                </tr>

                <tr>

                    <td>Wind Speed</td>

                    <td>{{ number_format($weather->wind_speed ?? 0,1) }} km/h</td>

                </tr>

                <tr>

                    <td>Storm Risk</td>

                    <td>{{ $weather->storm_risk ?? 0 }} %</td>

                </tr>

                <tr>

                    <td>Risk Level</td>

                    <td>{{ $risk->risk_level ?? '-' }}</td>

                </tr>

            </table>

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



let weatherData = @json($allWeather);

weatherData.forEach(function(item){

    if(!item.country) return;

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

    let radius = 8;
    let weight = 2;

    // Highlight active country

    if(item.country_id == {{ $country->id }}){

        radius = 14;
        weight = 4;

    }

    L.circleMarker(

        [

            item.country.latitude,

            item.country.longitude

        ],

        {

            radius:radius,

            color:"#00F5D4",

            weight:weight,

            fillColor:color,

            fillOpacity:.9

        }

    )

    .addTo(map)

    .bindPopup(

        `

        <h5>${item.country.name}</h5>

        <hr>

        <b>Status :</b>

        ${status}

        <br><br>

        🌡 Temperature :

        ${item.temperature} °C

        <br>

        🌧 Rainfall :

        ${item.rainfall} mm

        <br>

        💨 Wind :

        ${item.wind_speed} km/h

        <br>

        ⛈ Storm Risk :

        ${item.storm_risk} %

        `

    );

});



// Legend

var legend = L.control({

position:'bottomright'

});

legend.onAdd = function(){

var div = L.DomUtil.create('div');

div.style.background="#0E2238";
div.style.padding="12px";
div.style.color="white";
div.style.borderRadius="10px";
div.style.border="1px solid #00D9D5";

div.innerHTML=

`

<b>Weather Legend</b>

<br><br>

<span style="color:#06D6A0;">●</span> Normal

<br>

<span style="color:#FFD166;">●</span> Heavy Rain

<br>

<span style="color:#F77F00;">●</span> Strong Wind

<br>

<span style="color:#EF476F;">●</span> Storm Warning

<br><br>

<b>Selected Country</b>

=

Large Marker

`;

return div;

};

legend.addTo(map);

</script>

@endsection
