@extends('layouts.master')
@section('title', 'User Login')
@section('content')

<div class="container mt-5">
    <h2>Login</h2>

    {{-- Show authentication errors --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    {{-- Show validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <strong>Error!</strong> Please check your inputs.
        </div>
    @endif

    <form action="{{ route('do_login') }}" method="POST">
    @csrf

    <div class="form-group mb-2">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Password:</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <button type="submit" class="btn btn-primary">Login</button>

    <div class="mt-2">
        <a href="{{ route('forgot_password') }}">Forgot Password?</a>
    </div>
</form>

</div>

@endsection
