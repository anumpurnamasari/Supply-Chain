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





<!-- KPI SUMMARY -->


<div class="row g-4">


<div class="col-md-3">

<div class="card-box text-center">

<h5>
TOTAL RISK
</h5>


<h2>

{{ $risk->total_score ?? 0 }}%

</h2>


<span>

{{ $risk->risk_level ?? 'LOW RISK' }}

</span>


</div>

</div>





<div class="col-md-3">

<div class="card-box text-center">


<h5>
WEATHER STATUS
</h5>


<h2>
🌦
</h2>


<span>

{{ $risk->weather_score ?? 0 }}%
Risk

</span>


</div>

</div>






<div class="col-md-3">

<div class="card-box text-center">


<h5>
CURRENCY IMPACT
</h5>


<h2>
{{ number_format($currency->rate ?? 0) }}
</h2>


<span>

{{ $currency->base_currency ?? 'USD' }}
/
{{ $currency->target_currency ?? 'IDR' }}

</span>


</div>

</div>






<div class="col-md-3">


<div class="card-box text-center">


<h5>
NEWS SENTIMENT
</h5>


<h2>
{{ $news->first()->sentiment ?? 'Neutral' }}
</h2>


<span>

{{ $news->count() }}
News Analyzed

</span>


</div>


</div>









</div>











<!-- CHART + MAP -->


<div class="row g-4 mt-2">


<div class="col-md-6">


<div class="card-box analytics-card">


<h5>
📊 Risk Composition Analysis
</h5>


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

<div class="col-md-6">

<div class="card-box analytics-card">


<h5>
🌎 ACTIVE COUNTRY
</h5>



<div class="country-monitor">


<div class="country-main">


<img
src="{{ $country->flag ?? '' }}"
class="country-flag"
>



<div>


<h2>

{{ $country->name ?? 'No Country' }}

</h2>


<span>

Global Supply Monitoring

</span>


</div>


</div>






<div class="country-info">


<div>

<p>Region</p>

<h4>

{{ $country->region ?? '-' }}

</h4>

</div>





<div>

<p>Currency</p>

<h4>

{{ $country->currency ?? '-' }}

</h4>

</div>





<div>

<p>Population</p>

<h4>

{{ number_format($country->population ?? 0) }}

</h4>

</div>


</div>







<div class="risk-badge">


<span>

{{ $risk->risk_level ?? 'LOW' }}

</span>


<h3>

{{ $risk->total_score ?? 0 }}%

</h3>


</div>



</div>



</div>







</div>








<div class="col-md-6">


<div class="card-box analytics-box">


<h5>
🚨 Latest Intelligence Alert
</h5>



<div class="alert-list">


@forelse($news as $item)


<div class="alert-item">


<div>


<h6>

{{ $item->title }}

</h6>


<span>

Sentiment :
{{ $item->sentiment }}

|
Score :
{{ $item->sentiment_score }}

</span>


</div>


</div>


@empty


<p>
No intelligence data available
</p>


@endforelse



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
-2,
118
],
4
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






L.marker(

[
country.lat,
country.lng
]

)

.addTo(map)


.bindPopup(

`

<h3>

${markerColor}
${country.name}

</h3>


<hr>


Risk Level :
<b>

${country.risk}

</b>


<br>


Risk Score :

${country.score}%


`

);


L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

)
.addTo(map);




</script>


@endsection
