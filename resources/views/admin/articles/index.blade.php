@extends('layouts.admin')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>Manage Analysis Articles</h2>

        <a href="{{ route('articles.create') }}" class="btn btn-primary">
            + New Article
        </a>

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
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th width="180">Action</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($articles as $article)

                    <tr>

                        <td>{{ $article->id }}</td>

                        <td>{{ $article->title }}</td>

                        <td>{{ $article->author }}</td>

                        <td>

                            @if($article->published)

                                <span class="badge bg-success">
                                    Published
                                </span>

                            @else

                                <span class="badge bg-secondary">
                                    Draft
                                </span>

                            @endif

                        </td>

                        <td>{{ $article->created_at->format('d M Y') }}</td>

                        <td>

                            <a
                                href="{{ route('articles.edit',$article) }}"
                                class="btn btn-warning btn-sm"
                            >
                                Edit
                            </a>

                            <form
                                action="{{ route('articles.destroy',$article) }}"
                                method="POST"
                                class="d-inline"
                            >

                                @csrf
                                @method('DELETE')

                                <button
                                    class="btn btn-danger btn-sm"
                                    onclick="return confirm('Delete this article?')"
                                >
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center">

                            No Articles

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

            {{ $articles->links() }}

        </div>

    </div>

</div>

@endsection
