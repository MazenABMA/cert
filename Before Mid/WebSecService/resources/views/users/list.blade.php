@extends('layouts.master')
@section('title', 'Users Management')
@section('content')



<div class="row mb-3">
    <div class="col col-10">
        <h1>Users</h1>
    </div>
    <div class="col col-2">
        <a href="{{ route('users_add') }}" class="btn btn-success form-control">Add User</a>
    </div>
</div>

<div class="container mt-4">
    <form method="GET" action="{{ route('users_list') }}">
        <div class="row mb-3">
            <div class="col col-sm-3">
                <input name="keywords" type="text" class="form-control" placeholder="Search by Name or Email" value="{{ request()->keywords }}" />
            </div>
            <div class="col col-sm-2">
                <select name="role" class="form-select">
                    <option value="" {{ request()->role == "" ? "selected" : "" }} disabled>Filter by Role</option>
                    <option value="admin" {{ request()->role == "admin" ? "selected" : "" }}>Admin</option>
                    <option value="user" {{ request()->role == "user" ? "selected" : "" }}>User</option>
                    <option value="Employee" {{ request()->role == "Employee" ? "selected" : "" }}>Employee</option>
                </select>
            </div>
            <div class="col col-sm-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
            <div class="col col-sm-2">
                <a href="{{ route('users_list') }}" class="btn btn-danger">Reset</a>
            </div>
        </div>
    </form>
</div>


@foreach($users as $user)
    <div class="card mt-4">
        <div class="card-body">
            <h3>{{ $user->name }}</h3>
            <table class="table table-striped">
                <tr><th width="20%">Name</th><td>{{ $user->name }}</td></tr>
                <tr><th>Email</th><td>{{ $user->email }}</td></tr>
                <tr><th>Role</th><td>@foreach($user->roles as $role)
            <span class="badge bg-primary">{{$role->name}}</span>
          @endforeach</td></tr>
            </table>
            <div class="text-end">
                <a href="{{ route('users_edit', $user->id) }}" class="btn btn-success">Edit</a>
                <a href="{{ route('users_delete', $user->id) }}" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
@endforeach

@endsection
