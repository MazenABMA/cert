@extends('layouts.master')
@section('title', 'User Profile')
@section('content')

<div class="container mt-5">
    <h2>User Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-center">
        <div class="m-6 col-sm-12">
            <table class="table table-striped">
                <tr>
                    <th>Name</th><td>{{$user->name}}</td>
                </tr>
                <tr>
                    <th>Email</th><td>{{$user->email}}</td>
                </tr>
                <tr>
                    <th>Roles</th>
                    <td>
                        @foreach($user->roles as $role)
                            <span class="badge bg-primary">{{$role->name}}</span>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>Permissions</th>
                    <td>
                        @foreach($permissions as $permission)
                        <span class="badge bg-success">{{$permission->display_name}}</span>
                        @endforeach
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col col-10">
                </div>
                <div class="col col-2">
                    @if(auth()->user()->hasPermissionTo('edit_users')||auth()->id()==$user->id)
                    <a href="{{ route('users_edit', $user->id) }}" class="btn btn-success">Edit</a> 
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
