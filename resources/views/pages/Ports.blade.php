@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>⚓ Port Monitoring Dashboard</h2>

    <p>
        Global Maritime Logistics Intelligence
    </p>

</div>


<div class="row g-4">

    <div class="col-md-6">

        <div class="card-box">

            <label class="form-label">
                Search Port
            </label>

            <input
                type="text"
                class="form-control"
                id="searchPort"
                placeholder="Search port..."
            >

        </div>

    </div>



    <div class="col-md-6">

        <div class="card-box">

            <label class="form-label">
                Search Country
            </label>

            <input
                type="text"
                class="form-control"
                id="searchCountry"
                placeholder="Search country..."
            >

        </div>

    </div>

</div>




<div class="row g-4 mt-2">


    <div class="col-md-12">

        <div class="card-box">

            <h5>
                🌍 Global Port Map
            </h5>

            <div id="portMap"></div>

        </div>

    </div>

</div>




<div class="row g-4 mt-2">

    <div class="col-md-12">

        <div class="card-box">

            <h5>
                ⚓ Recent Port Activity
            </h5>

            <div class="port-list">

                @foreach($ports as $port)

                    <div class="port-item">

                        <div>

                            <h6>{{ $port->name }}</h6>

                            <span>

                                {{ $port->country }}

                            </span>

                        </div>

                        <div>

                            {{ $port->status }}

                        </div>

                    </div>

                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection

@section('script')

<script>

var map =
L.map('portMap')
.setView([20,0],2);

L.tileLayer(

'https://tile.openstreetmap.org/{z}/{x}/{y}.png'

).addTo(map);

let ports = @json($ports);

ports.forEach(function(port){

    let marker = L.circleMarker(

        [

            port.latitude,

            port.longitude

        ],

        {

            radius:8,

            color:'#00D9D5',

            fillColor:'#00D9D5',

            fillOpacity:.9

        }

    ).addTo(map);



    marker.bindPopup(

        `<b>${port.name}</b>

        <br>

        Country :

        ${port.country}

        <br>

        Status :

        ${port.status}

        <br>

        Risk :

        ${port.risk_level}`

    );

});

</script>

@endsection
