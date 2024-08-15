@extends('layouts.app')

@section('content')
<div class="container">
    @if ($inventory->is_suspended)
    <h1 class="text-info">Allow Item</h1>
    <h3 class="m-0 mt-5">{{ $inventory->internal_id }} ({{ $inventory->name }})</h3>
    <h6 class="text-secondary">Stock: {{ $inventory->stock_qty }}</h6>
    <a href="{{ route('inventory') }}" class="btn btn-secondary mt-3">Back</a>
    <a href="{{ route('inventory_destroy', ['inventory' => $inventory->id]) }}" class="btn btn-info mt-3">Allow</a>
    @else
    <h1 class="text-danger">Suspend Item</h1>
    <h3 class="m-0 mt-5">{{ $inventory->internal_id }} ({{ $inventory->name }})</h3>
    <h6 class="text-secondary">Stock: {{ $inventory->stock_qty }}</h6>
    <a href="{{ route('inventory') }}" class="btn btn-secondary mt-3">Back</a>
    <a href="{{ route('inventory_destroy', ['inventory' => $inventory->id]) }}" class="btn btn-danger mt-3">Suspend</a>
    @endif
</div>
@endsection
