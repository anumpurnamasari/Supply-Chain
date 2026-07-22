@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>
        Country Comparison
    </h2>

    <p>
        Compare Supply Chain Risk Between Countries
    </p>

</div>

<div class="card-box mb-4">

    <form method="GET" action="{{ route('compare') }}">

        <div class="row">

            <div class="col-md-5">

                <label class="form-label">
                    Country A
                </label>

                <select
                    name="country_a"
                    class="form-select"
                    required>

                    <option value="">
                        Choose Country
                    </option>

                    @foreach($countries as $country)

                        <option
                            value="{{ $country->id }}"
                            {{ request('country_a')==$country->id ? 'selected':'' }}>

                            {{ $country->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-5">

                <label class="form-label">
                    Country B
                </label>

                <select
                    name="country_b"
                    class="form-select"
                    required>

                    <option value="">
                        Choose Country
                    </option>

                    @foreach($countries as $country)

                        <option
                            value="{{ $country->id }}"
                            {{ request('country_b')==$country->id ? 'selected':'' }}>

                            {{ $country->name }}

                        </option>

                    @endforeach

                </select>

            </div>

            <div class="col-md-2 d-flex align-items-end">

                <button class="btn btn-info w-100">
                    Compare
                </button>

            </div>

        </div>

    </form>

</div>

@if($countryA && $countryB)

<div class="row mb-4">

    <div class="col-md-6">

        <div class="card-box">

            <h4>{{ $countryA->name }}</h4>

            <hr>

            <div class="d-flex justify-content-between mb-3">
                <span>Region</span>
                <strong>{{ $countryA->region }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Currency</span>
                <strong>{{ $countryA->currency }}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Population</span>
                <strong>{{ number_format($economicA->population ?? 0) }}</strong>
            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card-box">

            <h4>{{ $countryB->name }}</h4>

            <hr>

            <div class="d-flex justify-content-between mb-3">
                <span>Region</span>
                <strong>{{ $countryB->region }}</strong>
            </div>

            <div class="d-flex justify-content-between mb-3">
                <span>Currency</span>
                <strong>{{ $countryB->currency }}</strong>
            </div>

            <div class="d-flex justify-content-between">
                <span>Population</span>
                <strong>{{ number_format($economicB->population ?? 0) }}</strong>
            </div>

        </div>

    </div>

</div>

<div class="card-box">

    <table class="table table-dark table-hover align-middle">

        <thead>

        <tr>

            <th>Metric</th>

            <th>{{ $countryA->name }}</th>

            <th>{{ $countryB->name }}</th>

        </tr>

        </thead>

        <tbody>

        <tr>

            <td>Weather Risk</td>

            <td class="{{ ($weatherA->storm_risk ?? 999) < ($weatherB->storm_risk ?? 999) ? 'text-success fw-bold':'text-danger' }}">
                {{ $weatherA->storm_risk ?? '-' }} %
            </td>

            <td class="{{ ($weatherB->storm_risk ?? 999) < ($weatherA->storm_risk ?? 999) ? 'text-success fw-bold':'text-danger' }}">
                {{ $weatherB->storm_risk ?? '-' }} %
            </td>

        </tr>

        <tr>

            <td>Inflation</td>

            <td class="{{ ($economicA->inflation ?? 999) < ($economicB->inflation ?? 999) ? 'text-success fw-bold':'text-danger' }}">
                {{ $economicA->inflation ?? '-' }} %
            </td>

            <td class="{{ ($economicB->inflation ?? 999) < ($economicA->inflation ?? 999) ? 'text-success fw-bold':'text-danger' }}">
                {{ $economicB->inflation ?? '-' }} %
            </td>

        </tr>

        <tr>

            <td>GDP</td>

            <td class="{{ ($economicA->gdp ?? 0) > ($economicB->gdp ?? 0) ? 'text-success fw-bold':'text-danger' }}">
                {{ number_format($economicA->gdp ?? 0) }}
            </td>

            <td class="{{ ($economicB->gdp ?? 0) > ($economicA->gdp ?? 0) ? 'text-success fw-bold':'text-danger' }}">
                {{ number_format($economicB->gdp ?? 0) }}
            </td>

        </tr>

        <tr>

            <td>Population</td>

            <td>{{ number_format($economicA->population ?? 0) }}</td>

            <td>{{ number_format($economicB->population ?? 0) }}</td>

        </tr>

                <tr>

            <td>Exchange Rate Risk</td>

            <td class="{{ ($riskA->currency_score ?? 999) < ($riskB->currency_score ?? 999) ? 'text-success fw-bold':'text-danger' }}">
                {{ $riskA->currency_score ?? '-' }}
            </td>

            <td class="{{ ($riskB->currency_score ?? 999) < ($riskA->currency_score ?? 999) ? 'text-success fw-bold':'text-danger' }}">
                {{ $riskB->currency_score ?? '-' }}
            </td>

        </tr>

        <tr>

            <td>News Score</td>

            <td>{{ $riskA->news_score ?? '-' }}</td>

            <td>{{ $riskB->news_score ?? '-' }}</td>

        </tr>

        <tr>

            <td><strong>Total Risk Score</strong></td>

            <td class="fw-bold">
                {{ $riskA->total_score ?? '-' }}
            </td>

            <td class="fw-bold">
                {{ $riskB->total_score ?? '-' }}
            </td>

        </tr>

        <tr>

            <td><strong>Risk Level</strong></td>

            <td class="{{ ($riskA->total_score ?? 999) < ($riskB->total_score ?? 999)
                ? 'text-success fw-bold'
                : 'text-danger fw-bold' }}">

                {{ strtoupper($riskA->risk_level ?? '-') }}

            </td>

            <td class="{{ ($riskB->total_score ?? 999) < ($riskA->total_score ?? 999)
                ? 'text-success fw-bold'
                : 'text-danger fw-bold' }}">

                {{ strtoupper($riskB->risk_level ?? '-') }}

            </td>

        </tr>

        </tbody>

    </table>

</div>

@php

$winner = null;

if(($riskA->total_score ?? 999) < ($riskB->total_score ?? 999)){

    $winner = $countryA;

}
elseif(($riskA->total_score ?? 999) > ($riskB->total_score ?? 999)){

    $winner = $countryB;

}

@endphp

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card-box text-center">

            <h4>
                🏆 Recommended Country
            </h4>

            <hr>

            @if($winner)

                <h2 class="text-success">

                    {{ $winner->name }}

                </h2>

                <p class="mb-0">

                    Lowest overall supply chain risk.

                </p>

            @else

                <h2 class="text-warning">

                    DRAW

                </h2>

                <p class="mb-0">

                    Both countries have similar risk levels.

                </p>

            @endif

        </div>

    </div>

    <div class="col-md-6">

        <div class="card-box">

            <h4>

                Recommendation

            </h4>

            <hr>

            @if($winner)

                <ul class="mb-0">

                    <li>Lower overall risk score.</li>

                    <li>Better weather stability.</li>

                    <li>More favorable economic indicators.</li>

                    <li>Recommended for import and export activities.</li>

                </ul>

            @else

                <p class="mb-0">

                    Continue monitoring both countries before making logistics decisions.

                </p>

            @endif

        </div>

    </div>

</div>

@endif

@endsection
