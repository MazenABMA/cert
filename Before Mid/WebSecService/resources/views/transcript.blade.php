@extends('layouts.master')
@section('title', 'Student Transcript')

@section('content')
<div class="container mt-5">
    <div class="card">
        <div class="card-header text-center">
            <h2>Student Transcript</h2>
        </div>
        <div class="card-body">
            <p><strong>Student Name:</strong> {{ $student_name }}</p>
            <p><strong>Student ID:</strong> {{ $student_id }}</p>
            <p><strong>Semester:</strong> {{ $semester }}</p>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Course Name</th>
                        <th>Course Code</th>
                        <th>Credits</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $index => $course)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $course['course'] }}</td>
                            <td>{{ $course['code'] }}</td>
                            <td>{{ $course['credits'] }}</td>
                            <td>{{ $course['grade'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
