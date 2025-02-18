@extends('layouts.app')

@section('title', 'Successful Deliveries')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6 mt-16 md:mt-0">Successful Deliveries</h1>

    <!-- Desktop version (hidden on mobile) -->
    <div class="hidden md:block">
        <table class="min-w-full bg-white border border-gray-200">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200">Order ID</th>
                    <th class="py-2 px-4 border-b border-gray-200">Client Name / Phone</th>
                    <th class="py-2 px-4 border-b border-gray-200">Address</th>
                    <th class="py-2 px-4 border-b border-gray-200">Delivery Time (Deadline)</th>
                    <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($success) === 0)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200" colspan="5">
                        <p class="text-center">(No Pending Deliveries)</p>
                    </td>
                </tr>
                @else
                @foreach($success as $order)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->id }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->client_name }} / {{ $order->client_phone }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->address }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->delivery_time }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <a href="{{ route('delivery_proof', ['order' => $order->id]) }}" class="inline-block bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">View Proof</a>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Mobile version (hidden on desktop) -->
    <div class="md:hidden">
        @if(count($success) === 0)
            <p class="text-center py-4">(No Pending Deliveries)</p>
        @else
            @foreach($success as $order)
            <div class="bg-white border border-gray-200 rounded-lg mb-4 p-4">
                <div class="mb-2">
                    <span class="font-bold">Order ID:</span> {{ $order->id }}
                </div>
                <div class="mb-2">
                    <span class="font-bold">Client:</span> {{ $order->client_name }}
                    <br>
                    <span class="font-bold">Phone:</span> {{ $order->client_phone }}
                </div>
                <div class="mb-2">
                    <span class="font-bold">Address:</span>
                    <br>
                    {{ $order->address }}
                </div>
                <div class="mb-4">
                    <span class="font-bold">Delivery Time:</span>
                    <br>
                    {{ $order->delivery_time }}
                </div>
                <a href="{{ route('delivery_proof', ['order' => $order->id]) }}" class="block w-full text-center bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-700">View Proof</a>
            </div>
            @endforeach
        @endif
    </div>
</div>
@endsection