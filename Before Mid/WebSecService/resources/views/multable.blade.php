@extends('layouts.master') 
@section('title', 'Prime Numbers') 
@section('content')
<div class="container">
    <div class="row">
        @foreach (range(1, 100) as $j)
        <div class="card m-2 col-sm-2">
            <div class="card-header">{{$j}} Multiplication Table</div>
            <div class="card-body">
                <table class="table table-bordered">
                    @foreach (range(1, 10) as $i)
                    <tr><td>{{$j}} * {{$i}}</td><td>= {{ $i * $j }}</td></tr>
                    @endforeach
                </table>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
