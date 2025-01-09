@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Delivery Proof For Order: # {{ $record->order_id }}</h1>
    <div class="card" style="width: 18rem;">
        <img src="{{ asset('storage/delivery/images/' . $record->image_link) }}" class="object-fit-cover rounded shadow-lg" alt="Card Image">
        <div class="my-4">
            <h5 class="text-xl font-bold">Date & Time of Delivery</h5>
            <p class="card-text">{{ \Carbon\Carbon::parse($record->delivery_time)->format('F j, Y, g:i a') }}</p>
        </div>
    </div>

    @if (auth()->user()->isSysRole('manager'))
    <a href="{{ route('orders') }}">
        <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</button>
    </a>
    @else
    <a href="{{ route('deliveries_success') }}">
        <button type="button" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Back</button>
    </a>
    @endif
</div>
@endsection