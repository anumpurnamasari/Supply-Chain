@extends('layouts.admin')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

<h3>Edit Analysis Article</h3>

</div>

<div class="card-body">

<form
action="{{ route('articles.update',$article) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Title</label>

<input
type="text"
name="title"
class="form-control"
value="{{ $article->title }}"
required>

</div>

<div class="mb-3">

<label>Author</label>

<input
type="text"
name="author"
class="form-control"
value="{{ $article->author }}">

</div>

<div class="mb-3">

<label>Summary</label>

<textarea
name="summary"
class="form-control"
rows="3">{{ $article->summary }}</textarea>

</div>

<div class="mb-3">

<label>Content</label>

<textarea
name="content"
class="form-control"
rows="8"
required>{{ $article->content }}</textarea>

</div>

<div class="mb-3">

<label>Image URL</label>

<input
type="text"
name="image"
class="form-control"
value="{{ $article->image }}">

</div>

<div class="form-check mb-3">

<input
class="form-check-input"
type="checkbox"
name="published"
value="1"
{{ $article->published ? 'checked' : '' }}>

<label class="form-check-label">

Published

</label>

</div>

<button class="btn btn-success">

Update Article

</button>

<a
href="{{ route('articles.index') }}"
class="btn btn-secondary">

Back

</a>

</form>

</div>

</div>

</div>

@endsection
