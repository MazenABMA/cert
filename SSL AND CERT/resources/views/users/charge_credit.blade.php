@extends('layouts.master')
@section('title', 'Charge Credit')
@section('content')

<h2>Charge Credit for {{ $user->name }}</h2>

<!-- Display current credit -->
<p><strong>Current Credit: </strong>{{ $user->credit }}</p>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        @foreach ($errors->all() as $err)
            <div>{{ $err }}</div>
        @endforeach
    </div>
@endif

<form action="{{ route('charge_credit', $user->id) }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="amount" class="form-label">Credit Amount</label>
        <input type="number" name="amount" id="amount" min="0.01" step="0.01" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Charge</button>
</form>

@endsection
