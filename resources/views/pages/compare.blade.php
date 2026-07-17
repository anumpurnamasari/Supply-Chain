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

                    <option value="">Choose Country</option>

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

                    <option value="">Choose Country</option>

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

            <p><strong>Region :</strong> {{ $countryA->region }}</p>

            <p><strong>Currency :</strong> {{ $countryA->currency }}</p>

            <p><strong>Population :</strong>
                {{ number_format($economicA->population ?? 0) }}
            </p>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card-box">

            <h4>{{ $countryB->name }}</h4>

            <hr>

            <p><strong>Region :</strong> {{ $countryB->region }}</p>

            <p><strong>Currency :</strong> {{ $countryB->currency }}</p>

            <p><strong>Population :</strong>
                {{ number_format($economicB->population ?? 0) }}
            </p>

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

                <td class="{{ ($weatherA->storm_risk ?? 999) < ($weatherB->storm_risk ?? 999) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ $weatherA->storm_risk ?? '-' }}
                </td>

                <td class="{{ ($weatherB->storm_risk ?? 999) < ($weatherA->storm_risk ?? 999) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ $weatherB->storm_risk ?? '-' }}
                </td>
            </tr>

            <tr>

                <td>Inflation</td>

                <td class="{{ ($economicA->inflation ?? 999) < ($economicB->inflation ?? 999) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ $economicA->inflation ?? '-' }}
                </td>

                <td class="{{ ($economicB->inflation ?? 999) < ($economicA->inflation ?? 999) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ $economicB->inflation ?? '-' }}
                </td>

            </tr>

            <tr>

                <td>GDP</td>

                <td class="{{ ($economicA->gdp ?? 0) > ($economicB->gdp ?? 0) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ number_format($economicA->gdp ?? 0) }}
                </td>

                <td class="{{ ($economicB->gdp ?? 0) > ($economicA->gdp ?? 0) ? 'text-success fw-bold' : 'text-danger' }}">
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

                <td class="{{ ($currencyA->currency_risk ?? 999) < ($currencyB->currency_risk ?? 999) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ $currencyA->currency_risk ?? '-' }}
                </td>

                <td class="{{ ($currencyB->currency_risk ?? 999) < ($currencyA->currency_risk ?? 999) ? 'text-success fw-bold' : 'text-danger' }}">
                    {{ $currencyB->currency_risk ?? '-' }}
                </td>

            </tr>

            <tr>

                <td>News Score</td>

                <td>{{ $riskA->news_score ?? '-' }}</td>

                <td>{{ $riskB->news_score ?? '-' }}</td>

            </tr>

            <tr>

                <td><strong>Total Risk Score</strong></td>

                <td>

                    <strong>

                        {{ $riskA->total_score ?? '-' }}

                    </strong>

                </td>

                <td>

                    <strong>

                        {{ $riskB->total_score ?? '-' }}

                    </strong>

                </td>

            </tr>

            <tr>

                <td><strong>Risk Level</strong></td>

                <td class="{{ ($riskA->total_score ?? 999) < ($riskB->total_score ?? 999) ? 'text-success fw-bold fs-5' : 'text-danger fs-5' }}">
                    {{ $riskA->total_score ?? '-' }}
                </td>

                <td class="{{ ($riskB->total_score ?? 999) < ($riskA->total_score ?? 999) ? 'text-success fw-bold fs-5' : 'text-danger fs-5' }}">
                    {{ $riskB->total_score ?? '-' }}
                </td>

            </tr>

        </tbody>

    </table>

@php

    $winner = null;

    if(($riskA->total_score ?? 999) < ($riskB->total_score ?? 999)){

        $winner = $countryA;

    }elseif(($riskA->total_score ?? 999) > ($riskB->total_score ?? 999)){

        $winner = $countryB;

    }

@endphp

<div class="row mt-4">

    <div class="col-md-6">

        <div class="card-box text-center">

            <h4>

                🏆 Safer Country

            </h4>

            <hr>

            @if($winner)

                <h2 class="text-success">

                    {{ $winner->name }}

                </h2>

                <p>

                    This country has the lower overall supply chain risk score.

                </p>

            @else

                <h2 class="text-warning">

                    Draw

                </h2>

                <p>

                    Both countries have the same total risk score.

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

                <p>

                    Based on the weighted risk analysis, <strong>{{ $winner->name }}</strong>
                    is currently the safer country for supply chain activities.

                </p>

                <ul>

                    <li>Lower overall risk score.</li>

                    <li>Better supply chain stability.</li>

                    <li>Recommended for import/export operations.</li>

                </ul>

            @else

                <p>

                    Both countries have similar supply chain risks.

                    Additional monitoring of weather, economy,
                    and global news is recommended before making decisions.

                </p>

            @endif

        </div>

    </div>

</div>

<div class="card-box mt-4">

    <h4>

        Comparison Summary

    </h4>

    <hr>

    <div class="card-box mt-4 text-center">

    <h3>

        Overall Comparison Result

    </h3>

    <hr>

    @if($winner)

        <h1 class="text-success">

            {{ $winner->name }}

        </h1>

        <p>

            Selected as the preferred country based on GDP,
            Inflation, Weather, Currency, News and Overall Risk.

        </p>

    @else

        <h3 class="text-warning">

            Both Countries Are Comparable

        </h3>

    @endif

</div>

    <table class="table table-bordered">

        <tr>

            <th width="250">

                Lower Risk Score

            </th>

            <td>

                @if($winner)

                    {{ $winner->name }}

                @else

                    Equal

                @endif

            </td>

        </tr>

        <tr>

            <th>

                Better Supply Chain Condition

            </th>

            <td>

                @if($winner)

                    {{ $winner->name }}

                @else

                    Similar

                @endif

            </td>

        </tr>

        <tr>

            <th>

                Recommendation

            </th>

            <td>

                @if($winner)

                    Prioritize logistics operations in
                    {{ $winner->name }}.

                @else

                    Continue monitoring both countries.

                @endif

            </td>

        </tr>

    </table>

</div>

@endif

@endsection
