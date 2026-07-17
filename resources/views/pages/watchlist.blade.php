@extends('layouts.app')

@section('content')

<div class="module-header">

    <h2>⭐ Favorite Monitoring</h2>

    <p>Monitor your selected countries</p>

</div>

@if(session('success'))

<div class="alert alert-success">

    {{ session('success') }}

</div>

@endif

<div class="card-box">

    <h4 class="mb-4">

        Favorite Countries

    </h4>

    @if($watchlists->count())

    <table class="table table-dark table-hover align-middle">

        <thead>

            <tr>

                <th>No</th>

                <th>Country</th>

                <th>Region</th>

                <th>Risk</th>

                <th width="120">Action</th>

            </tr>

        </thead>

        <tbody>

            @foreach($watchlists as $item)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td>

                    {{ $item->country->name }}

                </td>

                <td>

                    {{ $item->country->region }}

                </td>

                <td>

                    @php

                        $risk = \App\Models\RiskScore::where('country_id',$item->country_id)
                                ->latest()
                                ->first();

                    @endphp

                    @if($risk)

                        @if($risk->risk_level=="HIGH")

                            <span class="badge bg-danger">

                                HIGH

                            </span>

                        @elseif($risk->risk_level=="MEDIUM")

                            <span class="badge bg-warning text-dark">

                                MEDIUM

                            </span>

                        @else

                            <span class="badge bg-success">

                                LOW

                            </span>

                        @endif

                    @else

                        -

                    @endif

                </td>

                <td>

                    <form action="{{ route('watchlist.destroy',$item->country_id) }}"

                          method="POST">

                        @csrf

                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">

                            Remove

                        </button>

                    </form>

                </td>

            </tr>

            @endforeach

        </tbody>

    </table>

    @else

        <div class="text-center p-5">

            <h5>No favorite country yet.</h5>

            <p>Add countries from the Country Dashboard.</p>

        </div>

    @endif

</div>

@endsection
