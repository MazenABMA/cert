@extends('layouts.master')

@section('title', 'Add Book')

@section('content')
<div class="container mt-5">
    <h2>Add Book</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('books.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label class="form-label">Title:</label>
            <input type="text" class="form-control" name="title" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Author:</label>
            <input type="text" class="form-control" name="author" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Published Year:</label>
            <input type="number" class="form-control" name="published_year" required min="1000" max="9999">
        </div>

        <button type="submit" class="btn btn-primary">Add Book</button>
    </form>
</div>
@endsection
