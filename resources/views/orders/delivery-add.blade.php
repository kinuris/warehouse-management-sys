@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-4">Register Delivery</h1>
    <form enctype="multipart/form-data" action="{{ route('order_deliver', ['order' => $order->id]) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="time" class="block text-gray-700 text-sm font-bold mb-2">Delivery Time:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('delivery_time') border-red-500 @enderror" type="datetime-local" value="{{ old('delivery_time') ?? now() }}" required name="delivery_time" id="time">
            @error('delivery_time')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="proof" class="block text-gray-700 text-sm font-bold mb-2">Proof of Delivery:</label>
            <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('proof') border-red-500 @enderror" type="file" name="proof" id="proof" required>
            @error('proof')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <a class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-1" href="{{ route('deliveries') }}">Back</a>
        <input class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-4 rounded cursor-pointer" type="submit" value="Register Delivery">
    </form>
</div>
@endsection