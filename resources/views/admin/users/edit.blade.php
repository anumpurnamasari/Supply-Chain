@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card">

<div class="card-header">

Edit User

</div>

<div class="card-body">

<form
action="{{ route('users.update',$user) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Name</label>

<input
type="text"
name="name"
class="form-control"
value="{{ $user->name }}">

</div>

<div class="mb-3">

<label>Email</label>

<input
type="email"
name="email"
class="form-control"
value="{{ $user->email }}">

</div>

<div class="mb-3">

<label>New Password</label>

<input
type="password"
name="password"
class="form-control">

</div>

<button class="btn btn-success">

Update

</button>

</form>

</div>

</div>

</div>

@endsection
