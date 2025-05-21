@extends('layouts.master')

@section('title', 'Books List')

@section('content')
<div class="container mt-5">
    <h2>Books List</h2>

    <a href="{{ route('books.create') }}" class="btn btn-success mb-3">Add Book</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Published Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->title }}</td>
                    <td>{{ $book->author }}</td>
                    <td>{{ $book->published_year }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
