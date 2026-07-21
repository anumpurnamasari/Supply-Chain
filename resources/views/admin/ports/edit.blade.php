@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

Edit Port

</div>

<div class="card-body">

<form
action="{{ route('ports.update',$port) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Port Name</label>

<input
type="text"
name="name"
value="{{ $port->name }}"
class="form-control">

</div>

<div class="mb-3">

<label>Country</label>

<select
name="country_id"
class="form-select">

@foreach($countries as $country)

<option
value="{{ $country->id }}"
{{ $country->id==$port->country_id ? 'selected' : '' }}>

{{ $country->name }}

</option>

<div class="mb-3">

<label>City</label>

<input
type="text"
name="city"
value="{{ $port->city }}"
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
value="{{ $port->latitude }}"
class="form-control">

</div>

<div class="mb-3">

<label>Longitude</label>

<input
type="text"
name="longitude"
value="{{ $port->longitude }}"
class="form-control">

</div>

<div class="mb-3">

<label>Status</label>

<select
name="status"
class="form-select">

<option
value="Active"
{{ $port->status=='Active' ? 'selected' : '' }}>

Active

</option>

<option
value="Inactive"
{{ $port->status=='Inactive' ? 'selected' : '' }}>

Inactive

</option>

</select>

</div>

<div class="mb-3">

<label>Risk Level</label>

<select
name="risk_level"
class="form-select">

<option
value="Low"
{{ $port->risk_level=='Low' ? 'selected' : '' }}>

Low

</option>

<option
value="Medium"
{{ $port->risk_level=='Medium' ? 'selected' : '' }}>

Medium

</option>

<option
value="High"
{{ $port->risk_level=='High' ? 'selected' : '' }}>

High

</option>

</select>

</div>

<button class="btn btn-success">

Update

</button>

</form>

</div>

</div>

</div>

@endsection
