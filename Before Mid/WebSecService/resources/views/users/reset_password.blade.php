@extends('layouts.master')
@section('title', 'Reset Password')
@section('content')

<form action="{{ route('reset_password') }}" method="POST">
    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">

    <div class="form-group mb-2">
        <label class="form-label">New Password:</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Confirm Password:</label>
        <input type="password" class="form-control" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn btn-primary">Reset Password</button>
</form>

@endsection
