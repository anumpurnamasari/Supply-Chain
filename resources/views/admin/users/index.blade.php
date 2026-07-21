@extends('layouts.admin')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">

<h2>Manage Users</h2>

<a href="{{ route('users.create') }}" class="btn btn-primary">

+ New User

</a>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<div class="card shadow">

<div class="card-body">

<table class="table table-hover">

<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Action</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>

<a href="{{ route('users.edit',$user) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<form
action="{{ route('users.destroy',$user) }}"
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

{{ $users->links() }}

</div>

</div>

</div>

@endsection
