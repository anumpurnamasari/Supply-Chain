@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

Add Port

</div>

<div class="card-body">

<form action="{{ route('ports.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Port Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Country</label>

<select
name="country_id"
class="form-select">

@foreach($countries as $country)

<option value="{{ $country->id }}">

{{ $country->name }}

</option>

<div class="mb-3">

<label>City</label>

<input
type="text"
name="city"
class="form-control">

</div>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Latitude</label>

<input
type="text"
name="latitude"
class="form-control">

</div>

<div class="mb-3">

<label>Longitude</label>

<input
type="text"
name="longitude"
class="form-control">

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option value="Active">Active</option>

<option value="Inactive">Inactive</option>

</select>

</div>

<div class="mb-3">

<label>Risk Level</label>

<select
name="risk_level"
class="form-select">

<option value="Low">Low</option>

<option value="Medium">Medium</option>

<option value="High">High</option>

</select>

</div>

<button class="btn btn-primary">

Save

</button>

</form>

</div>

</div>

</div>

@endsection
