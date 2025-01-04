@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    @if ($inventory->is_suspended)
    <h1 class="text-xl font-bold text-blue-600">Allow Item</h1>
    <h3 class="mt-5 text-lg font-semibold">{{ $inventory->internal_id }} {{ $inventory->name }}</h3>
    <h6 class="mb-5 text-gray-500 font-semibold">Stock: {{ $inventory->stock_qty }}</h6>
    <a href="{{ route('inventory') }}" class="p-1.5 text-white bg-gray-400 rounded">Back</a>
    <a href="{{ route('inventory_destroy', ['inventory' => $inventory->id]) }}" class="p-1.5 text-white bg-blue-600 rounded mt-3">Allow</a>
    @else
    <h1 class="text-xl font-bold text-red-500">Suspend Item</h1>
    <h3 class="mt-5 text-lg font-semibold">{{ $inventory->internal_id }} {{ $inventory->name }}</h3>
    <h6 class="mb-5 text-gray-500 font-semibold">Stock: {{ $inventory->stock_qty }}</h6>
    <a href="{{ route('inventory') }}" class="p-1.5 text-white bg-gray-400 rounded">Back</a>
    <a href="{{ route('inventory_destroy', ['inventory' => $inventory->id]) }}" class="p-1.5 text-white bg-red-500 rounded mt-3">Suspend</a>
    @endif
</div>
@endsection
