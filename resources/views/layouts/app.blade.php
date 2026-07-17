<!DOCTYPE html>
<html>

<head>

<title>
ChainPulse
</title>

<link
href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Orbitron:wght@600;700;800&family=Poppins:wght@400;500;600&family=Rajdhani:wght@500;600;700&display=swap"
rel="stylesheet">

<link
href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Orbitron:wght@600;700&family=Poppins:wght@400;500;600&display=swap"
rel="stylesheet">

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<link
rel="stylesheet"
href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>

<link rel="stylesheet"
href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>


<style>

.map-card{

height:420px;

}


#map{

height:300px;

width:100%;

margin-top:20px;

border-radius:18px;

overflow:hidden;


box-shadow:

0 0 25px rgba(0,245,212,.18);

}


body{

background:
linear-gradient(
135deg,
#071827,
#0A2238
);

font-family:'Inter',sans-serif;

color:#EAFBFF;

}



/* SIDEBAR */

.sidebar{

position:fixed;

top:0;
left:0;

width:250px;

height:100vh;


background:

linear-gradient(
180deg,
#081827 0%,
#0B2438 45%,
#0D3148 100%
);


padding:25px;

color:white;


border-right:

1px solid rgba(0,217,213,.25);


box-shadow:

10px 0 35px rgba(0,0,0,.7);


/* tetap scroll */
overflow-y:auto;
overflow-x:hidden;


/* firefox */
scrollbar-width:none;

}

.sidebar::-webkit-scrollbar{

display:none;

}

.logo{

font-family:'Orbitron',sans-serif;

font-size:25px;

font-weight:800;


background:

linear-gradient(
90deg,
#00D9D5,
#7DF9FF
);


-webkit-background-clip:text;

-webkit-text-fill-color:transparent;


margin-bottom:35px;


text-shadow:

0 0 25px rgba(0,217,213,.4);

}



.menu a{

display:block;

font-family:'Poppins',sans-serif;

text-decoration:none;


color:#D8F6FF;


padding:14px 16px;

border-radius:12px;

margin-bottom:14px;


background:

linear-gradient(
145deg,
#102A43,
#0B2035
);


border:

1px solid rgba(0,217,213,.25);


box-shadow:

inset 0 0 15px rgba(255,255,255,.02);


transition:.25s;

}


.menu a:hover{


background:

linear-gradient(
90deg,
#00D9D5,
#118AB2
);


color:#001219;


box-shadow:

0 0 20px rgba(0,217,213,.5);


transform:

translateX(5px);

}

.menu a i{

font-size:18px;

width:22px;

text-align:center;

color:#D8F6FF;

transition:.3s;

}

.menu a:hover i{

color:#001219;

transform:scale(1.1);

}


/* CONTENT */

.content{

margin-left:250px;

padding:25px;

}



.header{


background:

linear-gradient(
90deg,
#118AB2,
#06D6A0
);


padding:25px;


border-radius:20px;


color:white;


box-shadow:
0 8px 20px #0004;


}



.card-box{


background:

linear-gradient(
145deg,
#0E2238,
#123957
);


border:

1px solid #1D5C78;


border-radius:10px;


padding:25px;


color:white;


box-shadow:

0 8px 20px #0007;


transition:.3s;


}

.card-box:hover{


border-color:#00D9D5;


box-shadow:
0 0 18px #00D9D555;


}



.card-box h5{


font-family:'Rajdhani',sans-serif;


font-size:18px;


font-weight:600;


letter-spacing:1px;


text-transform:uppercase;


color:#8FE9FF;


margin-bottom:18px;


}



.card-box h2{


font-family:'Orbitron',sans-serif;


font-size:20px;


font-weight:400;


letter-spacing:1px;


color:#00F5D4;


text-shadow:

0 0 15px rgba(0,245,212,.35);


margin-bottom:12px;


}

.card-box span,
.card-box p{


font-family:'Poppins',sans-serif;


font-size:13px;


letter-spacing:.8px;


color:#B7DCE8;


}

.analytics-card{

height:430px;

display:flex;


flex-direction:column;


overflow:hidden;

}

.country-card{


height:430px;

overflow:hidden;


}

.analytics-card canvas{

max-height:300px !important;

}


.analytics-card #map{

height:300px;

}
.module-header{

height:105px;

padding:22px 30px;

border-radius:10px;


background:

linear-gradient(
120deg,
#123957,
#0E7490
);


border:

1px solid #00D9D5;


box-shadow:

0 8px 30px #0008;


margin-bottom:25px;


display:flex;

flex-direction:column;

justify-content:center;

}

.module-header h2{


font-family:'Orbitron',sans-serif;

font-size:25px;

font-weight:800;

color:white;

letter-spacing:.5px;

}


.module-header p{


font-family:'Poppins',sans-serif;

font-size:14px;

color:#9BE8F0;

}

.alert-box{


height:430px;


overflow:hidden;


}


.alert-list{


margin-top:20px;


height:330px;


overflow-y:auto;


padding-right:8px;


}



/* hide scrollbar */

.alert-list::-webkit-scrollbar{

display:none;

}


.alert-item{


padding:15px 18px;


margin-bottom:12px;


border-radius:14px;


background:

linear-gradient(
145deg,
#102A43,
#123957
);


border:

1px solid rgba(0,217,213,.3);


transition:.3s;


}




.alert-item:hover{


background:

linear-gradient(
90deg,
#00D9D5,
#118AB2
);


transform:

translateX(8px);


box-shadow:

0 0 25px rgba(0,217,213,.5);


}





.alert-item h6{


font-size:16px;


line-height:1.3;


margin-bottom:8px;


}



.alert-item span{


font-family:'Poppins',sans-serif;

font-size:13px;

color:#B8EAF5;


}




.alert-item:hover h6,
.alert-item:hover span{


color:#061826;


}



.arrow{

font-size:35px;

color:#00F5D4;

opacity:0;


transition:.3s;

}



.alert-item:hover .arrow{

opacity:1;

transform:translateX(5px);

}

</style>


@yield('style')


</head>




<body>


<!-- SIDEBAR -->

<div class="sidebar">


<div class="logo">

🌐 ChainPulse

</div>

<div class="menu">

<a href="{{ route('dashboard') }}">
    <i class="bi bi-grid-1x2-fill"></i>
    Dashboard
</a>

<a href="{{ route('risk') }}">
    <i class="bi bi-speedometer2"></i>
    Risk Scoring
</a>

<a href="{{ route('weather') }}">
    <i class="bi bi-cloud-rain"></i>
    Weather Risk
</a>

<a href="{{ route('currency') }}">
    <i class="bi bi-currency-exchange"></i>
    Currency Impact
</a>

<a href="{{ route('news') }}">
    <i class="bi bi-newspaper"></i>
    News Intelligence
</a>

<a href="{{ route('ports') }}">
    <i class="bi bi-geo-alt"></i>
    Port Monitoring
</a>

<a href="{{ route('visualization') }}">
    <i class="bi bi-bar-chart-line"></i>
    Data Visualization
</a>

<a href="{{ route('compare') }}">
    <i class="bi bi-globe-americas"></i>
    Country Compare
</a>

<a href="{{ route('watchlist') }}">
    <i class="bi bi-star"></i>
    Watchlist
</a>

<a href="{{ route('admin') }}">
    <i class="bi bi-person-gear"></i>
    Admin
</a>

</div>


</div>






<!-- CONTENT -->

<div class="content">


@yield('content')


</div>



@yield('script')

<script>

document.addEventListener(
"DOMContentLoaded",
function(){


var map =
L.map('map')
.setView(
[-2,118],
4
);



L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png',

{

maxZoom:19

}

).addTo(map);




L.marker(
[-6.2,106.8]
)

.addTo(map)

.bindPopup(

"Indonesia - Supply Risk Monitoring"

);



});

.country-monitor{


height:100%;


display:flex;


flex-direction:column;


justify-content:space-between;


}



.country-header{

display:flex;

align-items:center;

gap:10px;

margin:15px 0;

}

.country-flag{

    width:30px !important;
    height:20px !important;

    min-width:30px;
    max-width:30px;

    min-height:20px;
    max-height:20px;

    object-fit:cover;

    border-radius:2px;

    border:1px solid rgba(255,255,255,.2);

    display:block;

    flex-shrink:0;

}

.country-header h2{

    margin:0;

    font-family:'Orbitron', sans-serif;

    font-size:10px;

    font-weight:100;

    color:#00F5D4;

    letter-spacing:1px;

    text-shadow:0 0 6px rgba(0,245,212,.25);


}

.country-header small{

color:#9CCAD5;

font-size:10px;

}




.country-monitor{


flex:1;


display:flex;

flex-direction:column;


justify-content:space-between;

}


.country-grid{

display:grid;

grid-template-columns:repeat(2,1fr);

gap:12px;

margin-top:20px;

}

.info-card{

background:rgba(255,255,255,.05);

border:1px solid rgba(0,245,212,.15);

border-radius:12px;

padding:12px;

transition:.3s;

}

.info-card:hover{

border-color:#00F5D4;

box-shadow:0 0 15px rgba(0,245,212,.2);

}

.info-card span{

display:block;

font-size:11px;

font-family:'Rajdhani',sans-serif;

letter-spacing:1px;

color:#7FD8FF;

margin-bottom:5px;

}

.info-card h4{

margin:0;

font-size:5px;

font-family:'Poppins',sans-serif;

font-weight:300;

color:white;

}

.risk-score-box{

margin-top:15px;

padding:14px;

border-radius:12px;

background:linear-gradient(90deg,#00D9D5,#118AB2);

text-align:center;

}

.risk-score-box span{

font-size:12px;

letter-spacing:1px;

text-transform:uppercase;

color:#062033;

font-weight:600;

}

.risk-score-box h2{

margin:5px 0 0;

font-family:'Orbitron',sans-serif;

font-size:30px;

color:white;

}

#portMap{

height:550px;

border-radius:18px;

margin-top:15px;

}



.port-list{

max-height:260px;

overflow-y:auto;

}



.port-list::-webkit-scrollbar{

display:none;

}



.port-item{

display:flex;

justify-content:space-between;

align-items:center;

padding:15px 18px;

margin-bottom:12px;

border-radius:12px;

background:

linear-gradient(
145deg,
#102A43,
#123957
);

border:

1px solid rgba(0,217,213,.2);

transition:.3s;

}



.port-item:hover{

transform:translateX(5px);

background:

linear-gradient(
90deg,
#00D9D5,
#118AB2
);

color:#061826;

}

</script>

<script
src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>

@yield('script')

</body>



</html>
