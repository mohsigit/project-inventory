@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Inventory</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('inventories.update', $inventory->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Inventory Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $inventory->name }}" required>
        </div>

        <div class="form-group">
            <label for="quantity">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" value="{{ $inventory->quantity }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Inventory</button>
        <a href="{{ route('inventories.index') }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
