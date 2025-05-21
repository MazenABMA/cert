@extends('layouts.master') 
@section('title', 'Prime Numbers') 
@section('content')
<div class="container">
    <h2>To-Do List</h2>
    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Task Name" required>
        <button type="submit">Add Task</button>
    </form>

    <ul>
        @foreach ($tasks as $task)
            <li>
                {{ $task->name }} - {{ $task->status ? 'Completed' : 'Pending' }}
                @if (!$task->status)
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Complete</button>
                    </form>
                @endif
                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
