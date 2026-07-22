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

{{-- SUMMARY CARD --}}
<div class="row g-4">

    {{-- Exchange Rate --}}
    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Exchange Rate
            </h5>

            <h2>
                {{ number_format($currency->exchange_rate ?? 0, 2) }}
            </h2>

            <span>
                USD / {{ $country->currency }}
            </span>

        </div>

    </div>

    {{-- Currency --}}
    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Currency
            </h5>

            <h2>
                {{ $country->currency }}
            </h2>

            <span>
                Country Currency
            </span>

        </div>

    </div>

    {{-- Risk Score --}}
    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>
                Risk Score
            </h5>

            <h2>
                {{ $risk->currency_score ?? 0 }}
            </h2>

            <span>
                Currency Risk
            </span>

        </div>

    </div>

    {{-- Last Update --}}
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

{{-- CHART + INFORMATION --}}
<div class="row g-4 mt-2">

    {{-- Trend Chart --}}
    <div class="col-md-8">

        <div class="card-box">

            <h5>
                Exchange Rate Trend
            </h5>

            <canvas id="currencyChart"></canvas>

        </div>

    </div>

    {{-- Currency Information --}}
    <div class="col-md-4">

        <div class="card-box">

            <h5>
                Currency Information
            </h5>

            <br>

                    <div class="mt-3">

                <div class="d-flex justify-content-between mb-3">
                    <span>Country</span>
                    <strong>{{ $country->name }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Currency</span>
                    <strong>{{ $country->currency }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Exchange Rate</span>
                    <strong>{{ number_format($currency->exchange_rate ?? 0,2) }}</strong>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span>Currency Risk</span>

                    <span class="badge
                        @if(($risk->currency_score ?? 0) >= 70)
                            bg-danger
                        @elseif(($risk->currency_score ?? 0) >= 40)
                            bg-warning text-dark
                        @else
                            bg-success
                        @endif
                        px-3 py-2">

                        {{ $risk->currency_score ?? 0 }}

                    </span>

                </div>

                <div class="d-flex justify-content-between">
                    <span>Last Update</span>
                    <strong>
                        {{ optional($currency)->updated_at?->format('d M Y H:i') ?? '-' }}
                    </strong>
                </div>

            </div>

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
