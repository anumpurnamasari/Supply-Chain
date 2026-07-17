@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>Supply Chain Risk Scoring</h2>

    <p>Weighted Risk Model</p>

</div>

<div class="card-box mb-4">

    <h4>

        Selected Country :
        <b>{{ $country->name }}</b>

    </h4>

</div>

<div class="row g-4">

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>Weather</h5>

            <h2>{{ $risk->weather_score ?? 0 }}</h2>

            <span>Weight 30%</span>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>Inflation</h5>

            <h2>{{ $risk->inflation_score ?? 0 }}</h2>

            <span>Weight 20%</span>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>Exchange Rate</h5>

            <h2>{{ $risk->currency_score ?? 0 }}</h2>

            <span>Weight 10%</span>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card-box text-center">

            <h5>News Sentiment</h5>

            <h2>{{ $risk->news_score ?? 0 }}</h2>

            <span>Weight 40%</span>

        </div>

    </div>

</div>

<div class="row g-4 mt-2">

    <div class="col-md-7">

        <div class="card-box">

            <h5>Weighted Risk Formula</h5>

            <br>

            <table class="table table-dark table-bordered align-middle">

                <thead>

                    <tr>

                        <th>Component</th>

                        <th>Score</th>

                        <th>Weight</th>

                    </tr>

                </thead>

                <tbody>

                    <tr>

                        <td>Weather</td>

                        <td>{{ $risk->weather_score ?? 0 }}</td>

                        <td>30%</td>

                    </tr>

                    <tr>

                        <td>Inflation</td>

                        <td>{{ $risk->inflation_score ?? 0 }}</td>

                        <td>20%</td>

                    </tr>

                    <tr>

                        <td>Exchange Rate</td>

                        <td>{{ $risk->currency_score ?? 0 }}</td>

                        <td>10%</td>

                    </tr>

                    <tr>

                        <td>News Sentiment</td>

                        <td>{{ $risk->news_score ?? 0 }}</td>

                        <td>40%</td>

                    </tr>

                </tbody>

            </table>

            <hr>

            <h6 class="mb-3">Risk Score Calculation</h6>

            <div class="alert alert-dark">

                ({{ $risk->weather_score ?? 0 }} × 30%)

                +

                ({{ $risk->inflation_score ?? 0 }} × 20%)

                +

                ({{ $risk->currency_score ?? 0 }} × 10%)

                +

                ({{ $risk->news_score ?? 0 }} × 40%)

                <hr>

                <strong>

                    Total Score = {{ $risk->total_score ?? 0 }}

                </strong>

            </div>

            <h6 class="mt-4 mb-3">

                Risk Component Progress

            </h6>

            <p>Weather</p>

            <div class="progress mb-3">

                <div class="progress-bar bg-info"

                     style="width:{{ $risk->weather_score ?? 0 }}%">

                    {{ $risk->weather_score ?? 0 }}

                </div>

            </div>

            <p>Inflation</p>

            <div class="progress mb-3">

                <div class="progress-bar bg-warning"

                     style="width:{{ $risk->inflation_score ?? 0 }}%">

                    {{ $risk->inflation_score ?? 0 }}

                </div>

            </div>

            <p>Exchange Rate</p>

            <div class="progress mb-3">

                <div class="progress-bar bg-primary"

                     style="width:{{ $risk->currency_score ?? 0 }}%">

                    {{ $risk->currency_score ?? 0 }}

                </div>

            </div>

            <p>News Sentiment</p>

            <div class="progress">

                <div class="progress-bar bg-danger"

                     style="width:{{ $risk->news_score ?? 0 }}%">

                    {{ $risk->news_score ?? 0 }}

                </div>

            </div>

        </div>

    </div>

    <div class="col-md-5">

        <div class="card-box text-center">

            <h5>Total Risk Score</h5>

            <br>

            <h1>

                {{ $risk->total_score ?? 0 }}

            </h1>

            <br>

            @php

                $color='#06D6A0';

                if(($risk->risk_level ?? '')=='MEDIUM'){

                    $color='#FFD166';

                }

                if(($risk->risk_level ?? '')=='HIGH'){

                    $color='#EF476F';

                }

            @endphp

            <h2 style="color:{{ $color }}">

                {{ $risk->risk_level ?? 'LOW' }}

            </h2>

            <hr>

            @if(($risk->risk_level ?? '')=='LOW')

                <div class="alert alert-success">

                    <strong>Risk Interpretation</strong>

                    <br><br>

                    Supply chain conditions are stable.

                    <br>

                    Routine monitoring is recommended.

                </div>

            @elseif(($risk->risk_level ?? '')=='MEDIUM')

                <div class="alert alert-warning">

                    <strong>Risk Interpretation</strong>

                    <br><br>

                    Moderate disruption detected.

                    <br>

                    Continuous monitoring is recommended.

                </div>

            @else

                <div class="alert alert-danger">

                    <strong>Risk Interpretation</strong>

                    <br><br>

                    High disruption risk detected.

                    <br>

                    Immediate mitigation is recommended.

                </div>

            @endif

            <hr>

            <small>

                Last Calculation

                <br>

                {{ optional($risk->updated_at)->format('d M Y H:i') }}

            </small>

        </div>

    </div>

</div>

<div class="card-box mt-4">

    <h5 class="mb-3">

        Top 5 Highest Risk Countries

    </h5>

    <table class="table table-dark table-hover align-middle">

        <thead>

            <tr>

                <th width="60">Rank</th>

                <th>Country</th>

                <th width="120">Score</th>

                <th width="120">Risk Level</th>

            </tr>

        </thead>

        <tbody>

            @forelse($topRisks as $index => $item)

                <tr>

                    <td>

                        @if($index==0)

                            🥇

                        @elseif($index==1)

                            🥈

                        @elseif($index==2)

                            🥉

                        @else

                            {{ $index+1 }}

                        @endif

                    </td>

                    <td>

                        {{ $item->country->name }}

                    </td>

                    <td>

                        <strong>

                            {{ $item->total_score }}

                        </strong>

                    </td>

                    <td>

                        @if($item->risk_level=="HIGH")

                            <span class="badge bg-danger">

                                HIGH

                            </span>

                        @elseif($item->risk_level=="MEDIUM")

                            <span class="badge bg-warning text-dark">

                                MEDIUM

                            </span>

                        @else

                            <span class="badge bg-success">

                                LOW

                            </span>

                        @endif

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="4" class="text-center">

                        No risk data available.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection
