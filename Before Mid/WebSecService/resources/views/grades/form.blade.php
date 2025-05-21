@extends('layouts.master')
@section('title', 'Add/Edit Grade')
@section('content')

<div class="container mt-5">
    <form action="{{ route('grades_save', $grade->id ?? null) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Course Name:</label>
            <input type="text" class="form-control" name="course_name" required value="{{ old('course_name', $grade->course_name ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Term:</label>
            <input type="text" class="form-control" name="term" required value="{{ old('term', $grade->term ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Credit Hours:</label>
            <input type="number" class="form-control" name="credit_hours" required value="{{ old('credit_hours', $grade->credit_hours ?? '') }}">
        </div>
        <div class="mb-3">
            <label class="form-label">Grade:</label>
            <input type="text" class="form-control" name="grade" required value="{{ old('grade', $grade->grade ?? '') }}">
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>

@endsection
