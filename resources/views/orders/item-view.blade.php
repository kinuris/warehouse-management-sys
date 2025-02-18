@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <!-- Header Section -->
        <div class="mb-6 border-b pb-4">
            <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
            <div class="mt-2">
                <p class="text-gray-600">Customer: <span class="font-medium">{{ $order->client_name }}</span></p>
                <p class="text-gray-600">Phone: <span class="font-medium">{{ $order->client_phone }}</span></p>
                <p class="text-gray-600">Delivery Time: <span class="font-medium">{{ $order->delivery_time }}</span></p>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Order Items</h2>
            <p class="text-gray-600">Total Amount: <span class="font-bold text-green-600">{{ number_format($totalPrice, 2) }} PHP</span></p>
        </div>

        <!-- Table Section -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($orderItems as [$item, $quantity])
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->internal_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">x{{ $quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $item->price }} PHP</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $item->price * $quantity }} PHP</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                                href="{{ route('item_sections', ['product' => $item->id]) }}">
                                View In Warehouse
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Back Button -->
        <div class="mt-6">
            @if (Auth::user()->employee_role_id === 1)
            <a href="{{ route('orders') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                ← Back to Orders
            </a>
            @else
            <a href="{{ route('deliveries') }}"
                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                ← Back to Orders
            </a>
            @endif
        </div>
    </div>
</div>
@endsection