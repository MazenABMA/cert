@extends('layouts.master')
@section('title', 'Forgot Password')
@section('content')

<form action="{{ route('verify_security_question') }}" method="POST">
    @csrf

    <div class="form-group mb-2">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Security Answer:</label>
        <input type="text" class="form-control" name="security_answer" required>
    </div>

    <button type="submit" class="btn btn-primary">Verify</button>
</form>

@endsection
