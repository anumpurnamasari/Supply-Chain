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


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js">
</script>


<style>


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


font-size:42px;


font-weight:800;


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
Dashboard
</a>


<a href="{{ route('weather') }}">
Weather Risk
</a>


<a href="{{ route('currency') }}">
Currency Impact
</a>


<a href="{{ route('ports') }}">
Port Monitoring
</a>


<a href="{{ route('news') }}">
News Intelligence
</a>


<a href="{{ route('compare') }}">
Country Compare
</a>


<a href="{{ route('watchlist') }}">
Watchlist
</a>


<a href="{{ route('admin') }}">
Admin
</a>


</div>


</div>






<!-- CONTENT -->

<div class="content">


@yield('content')


</div>



@yield('script')



</body>



</html>
