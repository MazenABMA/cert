@extends('layouts.master') 
@section('title', 'welcome') 
@section('content')
    <script>
    function doSomething() {
        alert("welcome to our website");
    }
    </script>
    <div class="card m-4">
    <div class="card-body">
        welcome to home page
        <button type="button" class="btn btn-success" onclick="doSomething()">Press here</button>
    </div>
    </div>
@endsection



