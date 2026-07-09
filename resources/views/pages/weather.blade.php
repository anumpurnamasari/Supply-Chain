@extends('layouts.app')


@section('content')


<div class="module-header">


<h2>
🌦 Weather Risk Monitoring
</h2>


<p>
Open-Meteo API Intelligence
</p>


</div>





<div class="row">


<div class="col-md-3">


<div class="card-box text-center">


<h5>
Temperature
</h5>


<h2>

{{ $weather->temperature ?? 0 }}°

</h2>


</div>


</div>





<div class="col-md-3">


<div class="card-box text-center">


<h5>
Rainfall
</h5>


<h2>

{{ $weather->rainfall ?? 0 }}

</h2>


</div>


</div>






<div class="col-md-3">


<div class="card-box text-center">


<h5>
Wind Speed
</h5>


<h2>

{{ $weather->wind_speed ?? 0 }}

</h2>


</div>


</div>






<div class="col-md-3">


<div class="card-box text-center">


<h5>
Storm Risk
</h5>


<h2>

{{ $risk->risk_level ?? 'LOW' }}

</h2>


</div>


</div>


</div>



@endsection
