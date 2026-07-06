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

background:white;
border-radius:15px;
padding:25px;
text-align:center;
height:150px;
box-shadow:0 5px 15px #0003;

}


.stat-card p{

color:#555;

}



.stat-card h2{

font-weight:bold;
color:#073B4C;

}

.country-card{

background:white;
padding:25px;
border-radius:20px;
box-shadow:0 5px 20px #0003;

}


.country-card h3{

color:#073B4C;
font-weight:bold;

}


.country-card p{

color:#777;

}


.panel{

background:white;
border-radius:15px;
padding:20px;
margin-top:20px;
height:420px;

}



#map{

height:330px;
width:100%;
border-radius:15px;

}



#riskChart{

height:300px!important;

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



<div class="col-md-3">

<div class="stat-card">


<p>Weather Risk</p>


<h2>

{{ $risk->weather_score ?? 0 }}%

</h2>


<span>

{{ $risk->risk_level ?? 'LOW' }}

</span>


</div>

</div>





<div class="col-md-3">

<div class="stat-card">

<p>Temperature</p>


<h2>

{{ $weather->temperature ?? 0 }}°

</h2>


</div>

</div>






<div class="col-md-3">

<div class="stat-card">


<p>Rainfall</p>


<h2>

{{ $weather->rainfall ?? 0 }}

</h2>


</div>

</div>






<div class="col-md-3">

<div class="stat-card">


<p>Wind Speed</p>


<h2>

{{ $weather->wind_speed ?? 0 }}

</h2>


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


</div>


</div>


</div>







<!-- SCRIPT HARUS DI BAWAH -->


<script>


document.addEventListener(
"DOMContentLoaded",
function(){



// ==========================
// CHART
// ==========================


const ctx =
document.getElementById(
'riskChart'
);



new Chart(ctx,{


type:'line',


data:{


labels:[

'Indonesia',
'China',
'Germany',
'Australia',
'USA'

],


datasets:[{


label:'Risk Score',


data:[

20,
60,
25,
45,
70

],


borderWidth:3,


tension:0.4


}]


}


});







// ==========================
// MAP
// ==========================


var map =
L.map('map')
.setView(
[20,0],
2
);



L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

).addTo(map);




let countries=[


{
name:'Indonesia',
lat:-6.2,
lng:106.8,
risk:'LOW'
},



{
name:'China',
lat:35.8,
lng:104.1,
risk:'MEDIUM'
},



{
name:'Germany',
lat:51,
lng:10,
risk:'LOW'
}


];





countries.forEach(
country=>{


L.marker(
[
country.lat,
country.lng
]
)

.addTo(map)

.bindPopup(

`
<b>${country.name}</b>
<br>
Risk Level :
${country.risk}
`

);



});



});


</script>



</body>


</html>
