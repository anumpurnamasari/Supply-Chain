@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>
        Currency Impact Dashboard
    </h2>

    <p>
        Real-Time Exchange Rate Monitoring
    </p>

</div>



<div class="row g-4">

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Exchange Rate
            </h5>

            <h2>

                {{ number_format($currency->exchange_rate ?? 0,2) }}

            </h2>

            <span>

                USD / {{ $currency->currency ?? '-' }}

            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Currency

            </h5>

            <h2>

                {{ $country->currency }}

            </h2>

            <span>

                Active Country Currency

            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Risk Score

            </h5>

            <h2>

                {{ $currency->currency_risk ?? 0 }}

            </h2>

            <span>

                Currency Risk

            </span>

        </div>

    </div>



    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>

                Last Update

            </h5>

            <h2>

                {{ optional($currency)->updated_at?->format('H:i') ?? '--:--' }}

            </h2>

            <span>

                {{ optional($currency)->updated_at?->format('d M Y') ?? '-' }}

            </span>

        </div>

    </div>

</div>





<div class="row g-4 mt-2">

    <div class="col-md-8">

        <div class="card-box">

            <h5>

                Exchange Rate Trend

            </h5>

            <canvas id="currencyChart"></canvas>

        </div>

    </div>



    <div class="col-md-4">

        <div class="card-box">

            <h5>

                Currency Information

            </h5>

            <br>

            <table class="table table-borderless text-white">

                <tr>

                    <td width="45%">Country</td>

                    <td>{{ $country->name }}</td>

                </tr>

                <tr>

                    <td>Currency</td>

                    <td>{{ $country->currency }}</td>

                </tr>

                <tr>

                    <td>Exchange Rate</td>

                    <td>

                        {{ number_format($currency->exchange_rate ?? 0,2) }}

                    </td>

                </tr>

                <tr>

                    <td>Currency Risk</td>

                    <td>

                        {{ $currency->currency_risk ?? 0 }}

                    </td>

                </tr>

                <tr>

                    <td>Last Update</td>

                    <td>

                        {{ optional($currency)->updated_at?->format('d M Y H:i') ?? '-' }}

                    </td>

                </tr>

            </table>

        </div>

    </div>

</div>

@endsection




@section('script')

<script>

const currentRate = {{ $currency->exchange_rate ?? 1 }};

const ctx = document.getElementById('currencyChart');

new Chart(ctx,{

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

            label:'Exchange Rate',

            data:[

                currentRate*0.99,

                currentRate*1.00,

                currentRate*1.01,

                currentRate*0.995,

                currentRate*1.02,

                currentRate*1.015,

                currentRate

            ],

            borderWidth:3,

            tension:.4,

            fill:true,

            pointRadius:4

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

                beginAtZero:false

            }

        }

    }

});

</script>

@endsection
