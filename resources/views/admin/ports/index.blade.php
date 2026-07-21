@extends('layouts.admin')

@section('content')

<div class="container">

<div class="d-flex justify-content-between align-items-center mb-4">

<h2>Port Dataset</h2>

<div>

<a href="{{ route('ports.create') }}"
class="btn btn-primary">

+ Add Port

</a>



</div>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<div class="card shadow">

<div class="card-body table-responsive">

<table class="table table-hover">

<thead>

<tr>
    <th>ID</th>
    <th>Port</th>
    <th>City</th>
    <th>Country</th>
    <th>Status</th>
    <th>Risk</th>
    <th>Latitude</th>
    <th>Longitude</th>
    <th>Action</th>
</tr>

</thead>

<tbody>

@foreach($ports as $port)

<tr>

<td>{{ $port->id }}</td>

<td>{{ $port->name }}</td>

<td>{{ $port->city }}</td>

<td>{{ $port->country->name ?? '-' }}</td>

<td>

@if($port->status=='Active')

<span class="badge bg-success">
Active
</span>

@else

<span class="badge bg-secondary">
Inactive
</span>

@endif

</td>

<td>

@if($port->risk_level=='High')

<span class="badge bg-danger">
High
</span>

@elseif($port->risk_level=='Medium')

<span class="badge bg-warning text-dark">
Medium
</span>

@else

<span class="badge bg-success">
Low
</span>

@endif

</td>

<td>{{ $port->latitude }}</td>

<td>{{ $port->longitude }}</td>

<td>

<a
href="{{ route('ports.edit',$port) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<form
action="{{ route('ports.destroy',$port) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

{{ $ports->links() }}

</div>

</div>

</div>

@endsection
