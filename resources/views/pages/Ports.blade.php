@extends('layouts.app')

@section('content')

<style>
#map{
    border-radius:12px;
}

.card{
    border:none;
    border-radius:12px;
}

.table-hover tbody tr:hover{
    background:#eef7ff;
    cursor:pointer;
}

#searchPort,
#searchCountry{
    height:48px;
}
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">🌍 World Port Monitoring</h2>
            <p class="text-muted">Global Port Intelligence Dashboard</p>
        </div>

        <div class="card shadow-sm">
            <div class="card-body text-center">
                <h6>Total Ports</h6>
                <h3>{{ $totalPorts }}</h3>
            </div>
        </div>
    </div>

    <div class="row mb-4">

        <div class="col-md-6">

            <input
                type="text"
                id="searchPort"
                class="form-control"
                placeholder="🔍 Search Port..."
            >

        </div>

        <div class="col-md-6">

            <select
                id="searchCountry"
                class="form-select"
            >
                <option value="">🌍 All Countries</option>

                @foreach($countries as $country)

                    <option value="{{ $country->name }}">
                        {{ $country->name }}
                    </option>

                @endforeach

            </select>

        </div>

    </div>

    <div class="card shadow mb-4">

        <div class="card-body">

            <div
                id="map"
                style="height:600px;border-radius:10px;"
            ></div>

        </div>

    </div>

    <div class="card shadow">

        <div class="card-header">

            <strong>Port List</strong>

        </div>

        <div class="card-body table-responsive">

            <table class="table table-bordered table-hover">

                <thead>

                    <tr>

                        <th>Port</th>
                        <th>Country</th>
                        <th>Latitude</th>
                        <th>Longitude</th>

                    </tr>

                </thead>

                <tbody id="portTable">

                @foreach($ports as $port)

                    <tr
                        data-port="{{ strtolower($port->name) }}"
                        data-country="{{ strtolower($port->country->name ?? '') }}"
                    >

                        <td>{{ $port->name }}</td>

                        <td>{{ $port->country->name ?? '-' }}</td>

                        <td>{{ $port->latitude }}</td>

                        <td>{{ $port->longitude }}</td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

<script>

const map = L.map('map').setView([20,0],2);

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
{
maxZoom:18
}
).addTo(map);

const markers=[];

@foreach($ports as $port)

let marker=L.marker([
{{ $port->latitude }},
{{ $port->longitude }}
]).addTo(map);

marker.bindPopup(`
<div style="min-width:220px">
    <h6><b>{{ addslashes($port->name) }}</b></h6>
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
        Active Port
    </span>
</div>
`);

marker.port="{{ strtolower($port->name) }}";

marker.country="{{ strtolower($port->country->name ?? '') }}";

markers.push(marker);

@endforeach

document.getElementById('searchPort').addEventListener('keyup',function(){

let keyword=this.value.toLowerCase();

markers.forEach(function(marker){

if(marker.port.includes(keyword)||keyword===""){

marker.addTo(map);

}else{

map.removeLayer(marker);

}

});

document.querySelectorAll('#portTable tr').forEach(function(row){

row.style.display=row.dataset.port.includes(keyword)?'':'none';

});

});

document.getElementById('searchCountry').addEventListener('change',function(){

let keyword=this.value.toLowerCase();

markers.forEach(function(marker){

if(keyword===""||marker.country===keyword){

marker.addTo(map);

}else{

map.removeLayer(marker);

}

});

document.querySelectorAll('#portTable tr').forEach(function(row){

    row.style.cursor = "pointer";

    row.addEventListener('click',function(){

        const lat = parseFloat(
            this.children[2].innerText
        );

        const lng = parseFloat(
            this.children[3].innerText
        );

        map.setView([lat,lng],8);

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

document.querySelectorAll('#portTable tr').forEach(function(row){

if(keyword===""){

row.style.display='';

}else{

row.style.display=row.dataset.country===keyword?'':'none';

}

});

});

</script>

@endsection
