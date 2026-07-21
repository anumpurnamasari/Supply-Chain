@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">

Create User

</div>

<div class="card-body">

<form action="{{ route('users.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Password</label>

<input
type="password"
name="password"
class="form-control"
required>

</div>

<button class="btn btn-primary">

Save

</button>

</form>

</div>

</div>

</div>

@endsection
