@extends('layouts.app')

@section('content')
<div class="container px-4 py-8">
    <!-- Header Section -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-6">Sales Management</h1>
        <div class="space-x-4">
            <a href="{{ route('order_add') }}" class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                POS System
            </a>
            <a href="{{ route('order_walkin_add') }}" class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-5 rounded-lg shadow-md transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/></svg>
                Walk-in POS
            </a>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
            @foreach($orders as $order)
            <tr class="hover:bg-gray-50">
                <td class="px-3 py-3 text-sm text-gray-900">{{ $order->id }}</td>
                <td class="px-3 py-3 text-sm text-gray-900">{{ $order->client_name }}</td>
                <td class="px-3 py-3 text-sm">
                <a href="tel:{{ $order->client_phone }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                    {{ $order->client_phone }}
                </a>
                </td>
                <td class="px-3 py-3 text-sm text-gray-900">{{ $order->address }}</td>
                <td class="px-3 py-3">
                @if ($order->isWalkIn())
                    <span class="px-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Walk-in</span>
                @elseif ($order->isLateNotDelivered())
                    <span class="px-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Late</span>
                @elseif ($order->isLateDelivered())
                    <span class="px-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Late-D</span>
                @elseif ($order->isOnTimeDelivered())
                    <span class="px-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Done</span>
                @elseif ($order->isFailed())
                    <span class="px-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Failed</span>
                @elseif ($order->isPending())
                    <span class="px-1.5 inline-flex text-xs leading-5 font-semibold rounded-full bg-orange-100 text-orange-800">Pending</span>
                @endif
                </td>
                <td class="px-3 py-3 text-sm text-gray-900">{{ $order->delivery_time }}</td>
                <td class="px-3 py-3 text-sm space-x-1">
                <a class="inline-flex items-center px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-xs transition" href="{{ route('item_view', ['order' => $order->id]) }}">Items</a>
                <a class="inline-flex items-center px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded-md text-xs transition" href="{{ route('order_receipt', ['order' => $order->id]) }}">Receipt</a>
                @if (!$order->isDelivered() && !$order->isFailed() && !$order->isWalkIn())
                    <a class="inline-flex items-center px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded-md text-xs transition" href="{{ route('order_delete', ['order' => $order->id]) }}">Cancel</a>
                @endif
                @if ($order->isDelivered())
                    <a class="inline-flex items-center px-2 py-1 bg-purple-600 hover:bg-purple-700 text-white rounded-md text-xs transition" href="{{ route('delivery_proof', ['order' => $order->id]) }}">Proof</a>
                @endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection