@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" class="blur-sm" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.4; object-fit: cover;" alt="Background">
    <h1 class="text-xl font-bold">Order For: </h1>
    <h5 class="text-gray-600">{{ $order->client_name }} / {{ $order->client_phone }}</h5>
    <h5 class="mb-3 text-gray-600">Delivery: {{ $order->delivery_time }}</h5>

    <h2 class="text-lg">Items (Total: {{ number_format($totalPrice, 2) }} PHP)</h2>
    <div class="w-full">
        <table class="min-w-full">
            <thead>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">ITEM ID</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Name</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Quantity</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Price</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Total</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Actions</th>
            </thead>
            <tbody>
                @foreach($orderItems as [$item, $quantity])
                <tr>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $item->internal_id }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $item->name }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">x{{ $quantity }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $item->price }} PHP</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $item->price * $quantity }} PHP</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">
                        <a class="p-1.5 rounded bg-blue-400 text-white" href="{{ route('item_sections', ['product' => $item->id]) }}">View In Warehouse</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="my-3"></div>
    <a href="{{ route('orders') }}" class="bg-gray-400 rounded p-1.5 text-white">Back</a>
</div>
@endsection