@extends('layouts.master')
@section('title', 'Grades Management')
@section('content')

<div class="row mb-3">
    <div class="col col-10">
        <h1>Grades</h1>
    </div>
    <div class="col col-2">
        <a href="{{ route('grades_add') }}" class="btn btn-success form-control">Add Grade</a>
    </div>
</div>

@foreach($grades as $term => $term_grades)
    <div class="card mt-4">
        <div class="card-header">
            <h3>Term: {{ $term }}</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <tr><th>Course</th><th>CH</th><th>Grade</th><th>Actions</th></tr>
                @foreach($term_grades as $grade)
                    <tr>
                        <td>{{ $grade->course_name }}</td>
                        <td>{{ $grade->credit_hours }}</td>
                        <td>{{ $grade->grade }}</td>
                        <td>
                            <a href="{{ route('grades_edit', $grade->id) }}" class="btn btn-success">Edit</a>
                            <a href="{{ route('grades_delete', $grade->id) }}" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                @endforeach
            </table>
            <h5>Total CH: {{ $total_ch_per_term[$term] }} | GPA: {{ $gpa_per_term[$term] }}</h5>
        </div>
    </div>
@endforeach

<div class="card mt-4">
    <div class="card-header">
        <h3>Cumulative Summary</h3>
    </div>
    <div class="card-body">
        <h5>Total CCH: {{ $cumulative_ch }} | CGPA: {{ $cumulative_gpa }}</h5>
    </div>
</div>

@endsection
