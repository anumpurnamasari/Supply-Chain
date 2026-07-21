@extends('layouts.app')

@section('content')

<div class="module-header">
    <h2>Data Visualization Dashboard</h2>
    <p>Global Supply Chain Analytics</p>
</div>

<div class="row">

    <div class="col-lg-6 mb-4">
        <div class="card-box">
            <h5>GDP Trend</h5>
            <canvas id="gdpChart"></canvas>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card-box">
            <h5>Inflation Trend</h5>
            <canvas id="inflationChart"></canvas>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card-box">
            <h5>Currency Risk Trend</h5>
            <canvas id="currencyChart"></canvas>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card-box">
            <h5>Supply Chain Risk Trend</h5>
            <canvas id="riskChart"></canvas>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const labels = @json($labels);

new Chart(document.getElementById('gdpChart'),{

    type:'bar',

    data:{

        labels:labels,

        datasets:[{

            label:'GDP',

            data:@json($gdpData),

            borderWidth:2

        }]

    },

    options:{

        responsive:true,

        plugins:{
            legend:{
                display:true
            }
        }

    }

});

new Chart(document.getElementById('inflationChart'),{

    type:'line',

    data:{

        labels:labels,

        datasets:[{

            label:'Inflation',

            data:@json($inflationData),

            tension:.4,

            fill:false

        }]

    },

    options:{

        responsive:true

    }

});

new Chart(document.getElementById('currencyChart'),{

    type:'line',

    data:{

        labels:labels,

        datasets:[{

            label:'Currency Risk',

            data:@json($currencyData),

            tension:.4,

            fill:false

        }]

    },

    options:{

        responsive:true

    }

});

new Chart(document.getElementById('riskChart'),{

    type:'bar',

    data:{

        labels:labels,

        datasets:[{

            label:'Total Risk Score',

            data:@json($riskData),

            borderWidth:2

        }]

    },

    options:{

        responsive:true

    }

});

</script>

@endsection
