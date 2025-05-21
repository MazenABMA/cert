@extends('layouts.master')
@section('title', 'Forgot Password')
@section('content')

<div class="container mt-4">
    <h4>Forgot Your Password?</h4>
    <form method="POST" action="{{ route('send_temp_password') }}">
        @csrf
        <div class="form-group mt-2">
            <label>Email address:</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Send Temporary Password</button>
    </form>
</div>

@endsection