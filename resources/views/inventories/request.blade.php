@extends('layouts.app')

@section('content')
<h1>Request Inventory</h1>

<form action="{{ url('inventories/request') }}" method="POST">
  @csrf
  <label for="inventory">Select Inventory</label>
  <select name="inventory_id" id="inventory">
    @foreach ($inventories as $inventory)
      <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
    @endforeach
  </select>
  <button type="submit">Request</button>
</form>
@endsection
