@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $inventory->name }}</h1>
    
    <p>Quantity: {{ $inventory->quantity }}</p>

    <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Back to List</a>

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-warning">Edit</a>
        <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" style="display:inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
    @endif
</div>
@endsection
