@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Inventories</h1>

    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if(auth()->user()->role === 'admin')
        <a href="{{ route('inventories.create') }}" class="btn btn-primary mb-3">Add New Inventory</a>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($inventories as $inventory)
                <tr>
                    <td>{{ $inventory->name }}</td>
                    <td>{{ $inventory->quantity }}</td>
                    <td>
                        <a href="{{ route('inventories.show', $inventory->id) }}" class="btn btn-info">View</a>
                        
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('inventories.edit', $inventory->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('inventories.destroy', $inventory->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        @endif
                        
                        @if(auth()->user()->role === 'user')
                            <form action="{{ url('inventories/request') }}" method="POST" style="display:inline-block;">
                                @csrf
                                <input type="hidden" name="inventory_id" value="{{ $inventory->id }}">
                                <button type="submit" class="btn btn-primary">Request</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
