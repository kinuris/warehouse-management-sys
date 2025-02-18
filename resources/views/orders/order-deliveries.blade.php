@extends('layouts.app')

@section('title', 'Pending Deliveries')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-4 mt-16 md:mt-0">Pending Deliveries</h1>

    <!-- Table view for larger screens -->
    <div class="hidden md:block overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200">
            <!-- Original table code -->
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b border-gray-200">Order ID</th>
                    <th class="py-2 px-4 border-b border-gray-200">Client Name</th>
                    <th class="py-2 px-4 border-b border-gray-200">Client Phone</th>
                    <th class="py-2 px-4 border-b border-gray-200">Address</th>
                    <th class="py-2 px-4 border-b border-gray-200">Status</th>
                    <th class="py-2 px-4 border-b border-gray-200">Delivery Time (Deadline)</th>
                    <th class="py-2 px-4 border-b border-gray-200">Actions</th>
                </tr>
            </thead>
            <tbody>
                @if(count($pending) === 0)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200" colspan="7">
                        <p class="text-center">(No Pending Deliveries)</p>
                    </td>
                </tr>
                @else
                @foreach(array_filter($pending, fn($order) => !$order->isWalkIn()) as $order)
                <tr class="hover:bg-gray-50">
                    <td class="py-3 px-4 border-b border-gray-200 font-medium">#{{ $order->id }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $order->client_name }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">
                        <a href="tel:{{ $order->client_phone }}" class="text-blue-600 hover:text-blue-800 inline-flex items-center group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:text-blue-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $order->client_phone }}
                        </a>
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200">{{ $order->address }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">
                        @if ($order->isLateNotDelivered())
                        <span class="px-3 py-1 text-sm font-semibold text-yellow-700 bg-yellow-100 rounded-full">Late (Not Delivered)</span>
                        @elseif ($order->isLateDelivered())
                        <span class="px-3 py-1 text-sm font-semibold text-yellow-700 bg-yellow-100 rounded-full">Late (Delivered)</span>
                        @elseif ($order->isOnTimeDelivered())
                        <span class="px-3 py-1 text-sm font-semibold text-green-700 bg-green-100 rounded-full">Delivered</span>
                        @elseif ($order->isFailed())
                        <span class="px-3 py-1 text-sm font-semibold text-red-700 bg-red-100 rounded-full">Failed</span>
                        @elseif ($order->isPending())
                        <span class="px-3 py-1 text-sm font-semibold text-blue-700 bg-blue-100 rounded-full">Pending</span>
                        @endif
                    </td>
                    <td class="py-3 px-4 border-b border-gray-200 font-medium">{{ $order->delivery_time }}</td>
                    <td class="py-3 px-4 border-b border-gray-200">
                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('delivery_add', ['order' => $order->id]) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-md transition-colors duration-150">Delivered</a>
                            <a href="{{ route('item_view', ['order' => $order->id]) }}" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md transition-colors duration-150">View Items</a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>

    <!-- Card view for mobile -->
    <div class="md:hidden space-y-4">
        @if(count($pending) === 0)
        <p class="text-center py-4">(No Pending Deliveries)</p>
        @else
        @foreach(array_filter($pending, fn($order) => !$order->isWalkIn()) as $order)
        <div class="bg-white p-4 rounded-lg shadow-md">
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="font-bold">Order ID:</span>
                    <span>#{{ $order->id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-bold">Client:</span>
                    <span>{{ $order->client_name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="font-bold">Phone:</span>
                    <a href="tel:{{ $order->client_phone }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        {{ $order->client_phone }}
                    </a>
                </div>
                <div class="flex justify-between">
                    <span class="font-bold">Address:</span>
                    <span class="text-right flex-1 ml-2">{{ $order->address }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-bold">Status:</span>
                    @if ($order->isLateNotDelivered())
                    <span class="text-yellow-500"><b>Late (Not Delivered)</b></span>
                    @elseif ($order->isLateDelivered())
                    <span class="text-yellow-500"><b>Late (Delivered)</b></span>
                    @elseif ($order->isOnTimeDelivered())
                    <span class="text-green-500"><b>Delivered</b></span>
                    @elseif ($order->isFailed())
                    <span class="text-red-500"><b>Failed (Cancelled)</b></span>
                    @elseif ($order->isPending())
                    <span class="text-blue-500"><b>Pending</b></span>
                    @endif
                </div>
                <div class="flex justify-between">
                    <span class="font-bold">Delivery Time:</span>
                    <span>{{ $order->delivery_time }}</span>
                </div>
                <div class="flex space-x-2 mt-4">
                    <a class="bg-blue-500 text-white py-2 px-4 rounded flex-1 text-center" href="{{ route('delivery_add', ['order' => $order->id]) }}">Delivered</a>
                    <a class="bg-blue-300 text-white py-2 px-4 rounded flex-1 text-center" href="{{ route('item_view', ['order' => $order->id]) }}">View Items</a>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>
@endsection