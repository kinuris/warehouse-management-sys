@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <h1 class="text-3xl font-bold">Sales Management</h1>
    <div class="m-5"></div>
    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow" href="{{ route('order_add') }}" class="btn btn-primary my-3">Go to POS</a>
    <a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow" href="{{ route('order_walkin_add') }}" class="btn btn-primary my-3">Go to Walkin POS</a>
    <div class="m-5"></div>

    <div class="container mx-auto">
        <table class="min-w-full border border-gray-700">
            <thead>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Order ID</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Client Name / Phone</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Address</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Status</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Delivery Time (Deadline)</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Actions</th>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr class="border border-gray-700">
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $order->id }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $order->client_name }} / {{ $order->client_phone }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $order->address }}</td>
                    @if ($order->isWalkIn())
                    <td class="border border-gray-700 py-2 px-4 text-sm text-green-600"><b>Walk-in</b></td>
                    @elseif ($order->isLateNotDelivered())
                    <td class="border border-gray-700 py-2 px-4 text-sm text-yellow-600"><b>Late (Not Delivered)</b></td>
                    @elseif ($order->isLateDelivered())
                    <td class="border border-gray-700 py-2 px-4 text-sm text-blue-600"><b>Late (Delivered)</b></td>
                    @elseif ($order->isOnTimeDelivered())
                    <td class="border border-gray-700 py-2 px-4 text-sm text-blue-600"><b>Delivered</b></td>
                    @elseif ($order->isFailed())
                    <td class="border border-gray-700 py-2 px-4 text-sm text-red-600"><b>Failed (Cancelled)</b></td>
                    @elseif ($order->isPending())
                    <td class="border border-gray-700 py-2 px-4 text-sm text-orange-400"><b>Pending</b></td>
                    @endif
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $order->delivery_time }}</td>
                    <td class="flex p-3 text-sm">
                        <a class="p-1.5 rounded-l-lg bg-blue-400 text-white" href="{{ route('item_view', ['order' => $order->id]) }}">Items</a>
                        <a class="p-1.5 rounded-r-lg bg-green-600 text-white" href="{{ route('order_receipt', ['order' => $order->id]) }}">Receipt</a>
                        @if (!$order->isDelivered() && !$order->isFailed() && !$order->isWalkIn())
                        <a class="ml-2 p-1.5 rounded-lg bg-red-600 text-white" href="{{ route('order_delete', ['order' => $order->id]) }}">Cancel</a>
                        @endif
                        @if ($order->isDelivered())
                        <a class="ml-2 p-1.5 rounded-lg bg-purple-600 text-white" href="{{ route('delivery_proof', ['order' => $order->id]) }}">Proof</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection