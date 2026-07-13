@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>💱 Currency Impact Dashboard</h2>

    <p>
        Real-Time Exchange Rate Intelligence
    </p>

</div>



<div class="row g-4">

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>USD / IDR</h5>

            <h2>

                {{ number_format($currency->rate ?? 0) }}

            </h2>

            <span>
                Exchange Rate
            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>Currency Risk</h5>

            <h2>LOW</h2>

            <span>
                Stable
            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>Daily Change</h5>

            <h2>

                +0.42%

            </h2>

            <span>
                Last 24 Hours
            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>Updated</h5>

            <h2>

                {{ optional($currency)->updated_at?->format('H:i') ?? '--:--' }}

            </h2>

            <span>

                Today

            </span>

        </div>

    </div>

</div>





<div class="row g-4 mt-2">

    <div class="col-md-8">

        <div class="card-box">

            <h5>
                📈 Currency Trend
            </h5>

            <canvas id="currencyChart"></canvas>

        </div>

    </div>



    <div class="col-md-4">

        <div class="card-box">

            <h5>
                📊 Currency Analysis
            </h5>

            <br>

            <p>

                <b>Exchange Rate</b><br>

                {{ number_format($currency->rate ?? 0) }} IDR

            </p>

            <hr>

            <p>

                <b>Import Cost</b><br>

                Stable

            </p>

            <hr>

            <p>

                <b>Recommendation</b><br>

                Suitable for Import

            </p>

        </div>

    </div>

</div>

@endsection



@section('script')

<script>

new Chart(

document.getElementById('currencyChart'),

{

type:'line',

data:{

labels:[

'Mon',
'Tue',
'Wed',
'Thu',
'Fri',
'Sat',
'Sun'

],

datasets:[{

label:'USD / IDR',

data:[

17880,
17920,
17910,
17950,
17930,
17960,
{{ $currency->rate ?? 17987 }}

],

borderWidth:3,

tension:.4

}]

}

});

</script>

@endsection
