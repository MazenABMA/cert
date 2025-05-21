@extends('layouts.master')
@section('title', 'Add/Edit User')
@section('content')

<div class="container mt-5">
<form action="{{ route('users_save') }}" method="POST">
    @csrf

    <div class="form-group mb-2">
        <label class="form-label">Name:</label>
        <input type="text" class="form-control" name="name" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Email:</label>
        <input type="email" class="form-control" name="email" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Role:</label>
        <select name="role" class="form-control" required>
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="Employee">Employee</option>
        </select>
    </div>

    <!-- Security Question Dropdown -->
    <div class="form-group mb-2">
        <label class="form-label">Security Question:</label>
        <select name="security_question" class="form-control">
            <option value="">-- Select a Security Question --</option>
            <option value="What is your pet's name?">What is your pet's name?</option>
            <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
            <option value="What city were you born in?">What city were you born in?</option>
        </select>
        
    </div>

    <!-- Security Answer Input -->
    <div class="form-group mb-2">
        <label class="form-label">Security Answer:</label>
        <input type="text" class="form-control" name="security_answer">
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Password:</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <div class="form-group mb-2">
        <label class="form-label">Confirm Password:</label>
        <input type="password" class="form-control" name="password_confirmation" required>
    </div>

    <button type="submit" class="btn btn-primary">Add User</button>
</form>

</div>

@endsection
