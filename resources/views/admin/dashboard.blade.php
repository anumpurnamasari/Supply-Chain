@extends('layouts.admin')

@section('content')

<div class="admin-header">

    <div class="admin-info">
        <div class="admin-icon">
            <i class="bi bi-person-gear"></i>
        </div>

        <div>
            <h2>Welcome, {{ Auth::user()->name }}</h2>
            <p>Administrator Access</p>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="logout-btn">
            <i class="bi bi-box-arrow-right"></i>
            Logout
        </button>
    </form>

</div>


<div class="row g-4 justify-content-center">

    <div class="col-lg-3 col-md-4">
        <div class="card-box text-center">
            <i class="bi bi-people-fill fs-1 text-info"></i>

            <h5 class="mt-3">Users</h5>

            <h2>{{ $users }}</h2>

            <a href="{{ route('users.index') }}" class="btn btn-info w-100 mt-3">
                Manage Users
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-4">
        <div class="card-box text-center">
            <i class="bi bi-geo-alt-fill fs-1 text-warning"></i>

            <h5 class="mt-3">Ports</h5>

            <h2>{{ $ports }}</h2>

            <a href="{{ route('ports.index') }}" class="btn btn-warning w-100 mt-3">
                Manage Ports
            </a>
        </div>
    </div>


    <div class="col-lg-3 col-md-4">
        <div class="card-box text-center">
            <i class="bi bi-newspaper fs-1 text-danger"></i>

            <h5 class="mt-3">Articles</h5>

            <h2>{{ $articles }}</h2>

            <a href="{{ route('articles.index') }}" class="btn btn-danger w-100 mt-3">
                Manage Articles
            </a>
        </div>
    </div>

</div>


@endsection
