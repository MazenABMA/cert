@extends('layouts.master')
@section('title', 'User Registration')
@section('content')

<div class="container mt-5">
    <h2>Register</h2>

    {{-- Display validation errors --}}
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Display session error --}}
    @if(session('error'))
        <div class="alert alert-danger">
            <strong>Error!</strong> {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('do_register') }}" method="POST">
        @csrf

        <div class="form-group mb-2">
            <label class="form-label">Name:</label>
            <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Email:</label>
            <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Role:</label>
            <input type="text" class="form-control" value="{{ ucfirst($user->role ?? 'User') }}" disabled>
            <input type="hidden" name="role" value="{{ $user->role ?? 'user' }}">
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Security Question:</label>
            <select name="security_question" class="form-control">
                <option value="">-- Select a Security Question --</option>
                <option value="What is your pet's name?" {{ old('security_question') == "What is your pet's name?" ? 'selected' : '' }}>What is your pet's name?</option>
                <option value="What is your mother's maiden name?" {{ old("security_question") == "What is your mother's maiden name?" ? 'selected' : '' }}>What is your mother's maiden name?</option>
                <option value="What city were you born in?" {{ old('security_question') == "What city were you born in?" ? 'selected' : '' }}>What city were you born in?</option>
            </select>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Security Answer:</label>
            <input type="text" class="form-control" name="security_answer" value="{{ old('security_answer') }}">
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Password:</label>
            <input type="password" class="form-control" name="password" required>
        </div>

        <div class="form-group mb-2">
            <label class="form-label">Confirm Password:</label>
            <input type="password" class="form-control" name="password_confirmation" required>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>

@endsection
