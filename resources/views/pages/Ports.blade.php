@extends('layouts.app')

@section('content')

<style>

.port-header{
    background:linear-gradient(135deg,#123957,#0E7490);
    border:1px solid rgba(0,217,213,.25);
    border-radius:18px;
    padding:28px 32px;
    margin-bottom:25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 30px rgba(0,0,0,.35);
}

.port-title h2{
    margin:0;
    font-family:'Orbitron',sans-serif;
    color:white;
    font-size:30px;
    font-weight:700;
}

.port-title p{
    margin-top:6px;
    color:#BCEFFF;
    font-size:15px;
}

.summary-card{
    background:linear-gradient(145deg,#102A43,#123957);
    border:1px solid rgba(0,217,213,.25);
    border-radius:16px;
    padding:22px;
    text-align:center;
    height:100%;
    transition:.3s;
}

.summary-card:hover{
    transform:translateY(-5px);
    box-shadow:0 0 25px rgba(0,217,213,.35);
}

.summary-card h6{
    color:#8FE9FF;
    font-family:'Rajdhani',sans-serif;
    text-transform:uppercase;
    letter-spacing:1px;
    margin-bottom:12px;
}

.summary-card h2{
    color:#00F5D4;
    font-family:'Orbitron',sans-serif;
    font-size:34px;
}

.search-card{
    background:linear-gradient(145deg,#102A43,#123957);
    border:1px solid rgba(0,217,213,.25);
    border-radius:16px;
    padding:22px;
    margin-top:25px;
    margin-bottom:25px;
}

.search-card input,
.search-card select{
    height:52px;
    border-radius:12px;
}

.search-card input:focus,
.search-card select:focus{
    box-shadow:0 0 15px rgba(0,217,213,.35);
    border-color:#00D9D5;
}

</style>

<div class="port-header">

    <div class="port-title">

        <h2>
            Port Location Dashboard
        </h2>

        <p>
            Monitor global seaport locations, search ports, and explore
            international logistics routes in real time.
        </p>

    </div>

</div>

<div class="row g-4">

    <div class="col-lg-3">

        <div class="summary-card">

            <h6>Total Ports</h6>

            <h2>{{ $totalPorts }}</h2>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="summary-card">

            <h6>Countries</h6>

            <h2>{{ $countries->count() }}</h2>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="summary-card">

            <h6>Visible Ports</h6>

            <h2 id="visiblePorts">

                {{ $totalPorts }}

            </h2>

        </div>

    </div>

    <div class="col-lg-3">

        <div class="summary-card">

            <h6>Monitoring</h6>

            <h2 style="font-size:22px">

                LIVE

            </h2>

        </div>

    </div>

</div>

<div class="search-card">

    <div class="row">

        <div class="col-md-6">

            <input
                type="text"
                id="searchPort"
                class="form-control"
                placeholder="Search Port..."
            >

        </div>

        <div class="col-md-6">

            <select
                id="searchCountry"
                class="form-select"
            >

                <option value="">

                    All Countries

                </option>

                @foreach($countries as $country)

                    <option value="{{ strtolower($country->name) }}">

                        {{ $country->name }}

                    </option>

                @endforeach

            </select>

        </div>

    </div>

</div>

<div class="card-box">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="mb-1">
                Global Port Monitoring Map
            </h5>

            <small class="text-light opacity-75">
                Click a marker or select a port from the table below.
            </small>

        </div>

        <div class="text-end">

            <span class="badge bg-info text-dark px-3 py-2">
                {{ $totalPorts }} Ports Loaded
            </span>

        </div>

    </div>

    <div
        id="portMap"
        style="
            height:620px;
            border-radius:18px;
            overflow:hidden;
            border:1px solid rgba(0,217,213,.25);
        ">
    </div>

</div>


<div class="card-box mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="mb-1">
                World Port Directory
            </h5>

            <small class="text-light opacity-75">
                Click any row to zoom directly to the selected port.
            </small>

        </div>

        <div>

            <span class="badge bg-success">

                <span id="tableCount">

                    {{ $totalPorts }}

                </span>

                Ports

            </span>

        </div>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle mb-0">

            <thead>

                <tr>

                    <th style="width:60px;">#</th>

                    <th>Port</th>

                    <th>Country</th>

                    <th>Latitude</th>

                    <th>Longitude</th>

                    <th style="width:120px;">Status</th>

                </tr>

            </thead>

            <tbody id="portTable">

                @foreach($ports as $index=>$port)

                <tr

                    data-port="{{ strtolower($port->name) }}"

                    data-country="{{ strtolower($port->country->name ?? '') }}"

                    data-lat="{{ $port->latitude }}"

                    data-lng="{{ $port->longitude }}"

                >

                    <td>

                        {{ $index+1 }}

                    </td>

                    <td>

                        <strong>

                            {{ $port->name }}

                        </strong>

                    </td>

                    <td>

                        {{ $port->country->name ?? '-' }}

                    </td>

                    <td>

                        {{ $port->latitude }}

                    </td>

                    <td>

                        {{ $port->longitude }}

                    </td>

                    <td>

                        <span class="badge bg-success">

                            Active

                        </span>

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('script')

<script>

const map = L.map('portMap').setView([20,0],2);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
    maxZoom:18,
    attribution:'© OpenStreetMap'
}
).addTo(map);

const markers=[];

@foreach($ports as $port)

@if($port->latitude && $port->longitude)

var marker=L.marker([
{{ $port->latitude }},
{{ $port->longitude }}
]).addTo(map);

marker.port="{{ strtolower($port->name) }}";

marker.country="{{ strtolower($port->country->name ?? '') }}";

marker.bindPopup(`
<div style="min-width:230px">

<h5 style="margin-bottom:8px;">
 {{ addslashes($port->name) }}
</h5>

<hr>

<b>Country</b><br>

{{ addslashes($port->country->name ?? '-') }}

<br><br>

<b>Latitude</b><br>

{{ $port->latitude }}

<br><br>

<b>Longitude</b><br>

{{ $port->longitude }}

<br><br>

<span class="badge bg-success">
ACTIVE PORT
</span>

</div>
`);

markers.push(marker);

@endif

@endforeach

// ======================================
// AUTO FIT MAP
// ======================================

if(markers.length){

    const group=L.featureGroup(markers);

    map.fitBounds(group.getBounds(),{

        padding:[40,40]

    });

}

// ======================================
// FILTER
// ======================================

function filterPorts(){

    const portKeyword=
        document.getElementById('searchPort')
        .value.toLowerCase();

    const countryKeyword=
        document.getElementById('searchCountry')
        .value.toLowerCase();

    let visible=0;

    document
    .querySelectorAll('#portTable tr')
    .forEach(function(row){

        const port=row.dataset.port;

        const country=row.dataset.country;

        const showPort=
            port.includes(portKeyword);

        const showCountry=
            countryKeyword==="" ||
            country===countryKeyword;

        if(showPort && showCountry){

            row.style.display='';

            visible++;

        }else{

            row.style.display='none';

        }

    });

    markers.forEach(function(marker){

        const showPort=
            marker.port.includes(portKeyword);

        const showCountry=
            countryKeyword==="" ||
            marker.country===countryKeyword;

        if(showPort && showCountry){

            if(!map.hasLayer(marker)){

                marker.addTo(map);

            }

        }else{

            if(map.hasLayer(marker)){

                map.removeLayer(marker);

            }

        }

    });

    document.getElementById('visiblePorts').innerHTML=
        visible;

    document.getElementById('tableCount').innerHTML=
        visible;

}

document
.getElementById('searchPort')
.addEventListener('keyup',filterPorts);

document
.getElementById('searchCountry')
.addEventListener('change',filterPorts);

// ======================================
// CLICK TABLE
// ======================================

document
.querySelectorAll('#portTable tr')
.forEach(function(row){

    row.style.cursor='pointer';

    row.addEventListener('click',function(){

        const lat=parseFloat(
            this.dataset.lat
        );

        const lng=parseFloat(
            this.dataset.lng
        );

        map.flyTo([lat,lng],8,{

            duration:1.5

        });

        markers.forEach(function(marker){

            if(
                marker.getLatLng().lat===lat &&
                marker.getLatLng().lng===lng
            ){

                marker.openPopup();

            }

        });

    });

});

</script>

@endsection
