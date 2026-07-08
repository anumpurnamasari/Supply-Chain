<!DOCTYPE html>
<html>

<head>

<title>
ChainPulse Dashboard
</title>


<!-- BOOTSTRAP -->
<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<!-- LEAFLET CSS -->
<link
rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>


<!-- CHART JS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- LEAFLET JS -->
<script
src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>


<style>


body{

background:#062c3d;
font-family:'Segoe UI',sans-serif;

}


.sidebar{

height:100vh;
background:#073B4C;
padding:25px;
color:white;

}


.logo{

font-size:25px;
font-weight:bold;
color:#06D6A0;

}


.menu{

margin-top:30px;

}


.menu div{

padding:10px;
border-radius:10px;
margin-bottom:10px;
border:1px solid #118AB2;

}


.main{

padding:25px;

}


.header{

background:linear-gradient(
90deg,#5cc6d0,#118AB2
);

padding:25px;
border-radius:15px;
color:white;

}



.stat-card{

background:#ffffff;

height:125px;

border-radius:16px;

padding:12px;

display:flex;
flex-direction:column;

align-items:center;
justify-content:center;

box-shadow:0 5px 15px #0003;

}



.stat-card p{

font-size:15px;

color:#333;

margin-bottom:8px;

}



.stat-card h2{

font-size:32px;

font-weight:800;

color:#073B4C;

margin:0;

}



.stat-card span{

font-size:13px;

color:#222;

margin-top:5px;

}

.country-card{

background:white;
height:115px;
padding:15px 25px;
border-radius:18px;

display:flex;
align-items:center;

box-shadow:0 5px 15px #0003;

}


.country-card img{

width:70px;

}


.country-card h3{

font-size:26px;
font-weight:bold;
color:#073B4C;
margin:0;

}


.country-card p{

font-size:14px;
color:#777;
margin:0;

}



.panel{


background:white;

height:300px;

border-radius:16px;

padding:15px;

margin-top:15px;

overflow:hidden;


box-shadow:0 5px 15px #0003;

}



.panel h5{


font-size:20px;

font-weight:bold;

color:#222;


}



#map{


height:220px;

width:100%;

border-radius:12px;


}




#riskChart{

height:220px!important;

}


</style>


</head>



<body>



<div class="container-fluid">


<div class="row">



<!-- SIDEBAR -->


<div class="col-md-2 sidebar">


<div class="logo">

🌐 ChainPulse

</div>



<div class="menu">


<div>Dashboard</div>

<div>Weather Risk</div>

<div>Currency Impact</div>

<div>Port Monitoring</div>

<div>News Intelligence</div>

<div>Country Compare</div>


</div>


</div>





<!-- MAIN -->


<div class="col-md-10 main">



<div class="header">


<h3>
Comprehensive Supply Chain Risk Dashboard
</h3>


<p>
Real-Time Global Logistics Intelligence Platform
</p>


</div>

<!-- COUNTRY PROFILE -->


<div class="row mt-4">


<div class="col-md-12">


<div class="country-card">


<div class="row align-items-center">


<div class="col-md-2 text-center">


<img
src="{{ $country->flag ?? '' }}"
width="100">


</div>



<div class="col-md-3">


<h3>

{{ $country->name ?? 'Unknown Country' }}

</h3>


<p>
Global Monitoring Area
</p>


</div>





<div class="col-md-2">


<b>
Region
</b>

<br>


{{ $country->region ?? '-' }}


</div>





<div class="col-md-2">


<b>
Currency
</b>

<br>


{{ $country->currency ?? '-' }}


</div>






<div class="col-md-3">


<b>
Population
</b>

<br>


{{ number_format(
$country->population ?? 0
) }}


</div>



</div>


</div>


</div>


</div>




<!-- CARD -->

<div class="row mt-4">


<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">

<p>
🌦 Weather Risk
</p>

<h2>
{{ $risk->weather_score ?? 0 }}%
</h2>

<span>
{{ $risk->risk_level ?? 'LOW' }}
</span>

</div>

</div>





<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">

<p>
🌡 Temperature
</p>

<h2>

{{ $weather->temperature ?? 0 }}°

</h2>

</div>

</div>





<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">

<p>
🌧 Rainfall
</p>

<h2>

{{ $weather->rainfall ?? 0 }}

</h2>

</div>

</div>





<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">

<p>
💨 Wind Speed
</p>

<h2>

{{ $weather->wind_speed ?? 0 }}

</h2>

</div>

</div>


</div>

<!-- ==============================
BUSINESS INTELLIGENCE CARD
============================== -->


<div class="row mt-4">



<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">


<p>
🚨 Total Risk
</p>


<h2>

{{ $risk->total_score ?? 0 }}%

</h2>


<span>

{{ $risk->risk_level ?? 'LOW' }}

</span>


</div>

</div>






<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">


<p>
💱 Currency Rate
</p>


<h2>

{{ number_format($currency->exchange_rate ?? 0) }}

</h2>


<span>

{{ $currency->currency ?? 'USD' }}

</span>


</div>

</div>






<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">


<p>
📈 Inflation
</p>


<h2>

{{ $economic->inflation ?? 0 }}%

</h2>


<span>

World Bank

</span>


</div>

</div>






<div class="col-md-3 col-lg-3 mb-3">

<div class="stat-card">


<p>
💰 GDP
</p>


<h2 style="font-size:32px">


${{
number_format(
($economic->gdp ?? 0)
/1000000000,
1
)
}}B


</h2>


<span>

GDP Value

</span>


</div>

</div>




</div>




<!-- CHART + MAP -->


<div class="row">



<div class="col-md-6">


<div class="panel">


<h5>
📊 Global Risk Trend
</h5>


<canvas id="riskChart"></canvas>


</div>


</div>






<div class="col-md-6">


<div class="panel">


<h5>
🌍 Global Supply Risk Map
</h5>


<div id="map"></div>














</div>


</div>


</div>




<div class="row">


<div class="col-md-6">


<div class="panel">


<h5>
📰 News Intelligence
</h5>


@foreach($news as $item)


<div class="mb-3">


<b>

{{ $item->title }}

</b>


<br>


Source:

{{ $item->source }}


<br>


Sentiment:


<span>


{{ $item->sentiment }}


</span>


</div>


<hr>


@endforeach


</div>


</div>





<div class="col-md-6">


<div class="panel">


<h5>
⚓ Port Monitoring
</h5>


@foreach($ports as $port)


<p>


<b>

{{ $port->name }}

</b>


<br>


{{ $port->city }}


<br>


Status:


{{ $port->status }}


<br>


Risk:


{{ $port->risk_level }}


</p>


<hr>


@endforeach



</div>


</div>


</div>






<!-- SCRIPT HARUS DI BAWAH -->




<script>



document.addEventListener(
"DOMContentLoaded",
function(){



// ==========================
// CHART JS - RISK TREND
// ==========================


const ctx =
document.getElementById(
'riskChart'
);



if(ctx){


new Chart(ctx,{


type:'line',


data:{


labels:
{!! json_encode(
array_keys($riskChart)
) !!},


datasets:[{


label:
'Supply Chain Risk Score',


data:

{!! json_encode(
array_values($riskChart)
) !!},


borderWidth:3,


tension:0.4


}]


},



options:{


responsive:true,


plugins:{


legend:{

display:true

}


},


scales:{


y:{


beginAtZero:true,


max:100


}


}


}


});


}







// ==========================
// LEAFLET GLOBAL MAP
// ==========================


var map =
L.map(
'map'
)
.setView(
[15,50],
2
);




L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png',

{

maxZoom:19

}

)
.addTo(map);







// ==========================
// PORT MARKER DATABASE
// ==========================


let ports = {!! json_encode($ports ?? [])!!};




ports.forEach(function(port){



let latitude =
parseFloat(
port.latitude
);



let longitude =
parseFloat(
port.longitude
);




if(
!isNaN(latitude)
&&
!isNaN(longitude)
){



L.marker([

latitude,

longitude

])

.addTo(map)


.bindPopup(

`

<h6>

⚓ ${port.name}

</h6>


<hr>


<b>City:</b>

${port.city}


<br>


<b>Status:</b>

${port.status}


<br>


<b>Risk Level:</b>

${port.risk_level}


`

);



}



});









// ==========================
// COUNTRY MARKER DATABASE
// ==========================


@isset($country)



let countryLat =
parseFloat(
"{{ $country->latitude }}"
);


let countryLng =
parseFloat(
"{{ $country->longitude }}"
);




if(
!isNaN(countryLat)
&&
!isNaN(countryLng)
){



L.circleMarker(

[

countryLat,

countryLng

],

{

radius:10

}

)


.addTo(map)


.bindPopup(

`

🌍 <b>

{{ $country->name }}

</b>


<br>


Country Risk:

{{ $risk->risk_level ?? 'LOW' }}


`

);


}



@endisset






});


</script>



</body>


</html>
