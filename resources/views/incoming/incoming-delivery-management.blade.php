@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-5">Incoming Delivery Management</h1>
    <a href="{{ route('incoming_add') }}" class="p-2 bg-blue-500 text-white rounded">Add Incoming Delivery</a>

    <div class="mt-5">
        <table class="min-w-full">
            <thead>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">ID</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Distributor</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Product</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Quantity</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Price</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Delivery Schedule</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Actions</th>
            </thead>
            <tbody>
                @php
                $deliveries = App\Models\IncomingDelivery::all()->groupBy('batch_id');
                @endphp

                @foreach ($deliveries as $batchId => $batchDeliveries)
                <!-- <tr class="bg-gray-100">
                        <td colspan="7" class="border border-gray-700 py-2 px-4 text-sm font-bold bg-gray-200 flex justify-between items-center">
                            <span>Batch #{{ $batchId ?: 'Unassigned' }}</span>
                            <div class="flex gap-2">
                                @if ($batchDeliveries->first()->status() === 'pending')
                                    <a class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors" href="{{ route('incoming_deliver', ['delivery' => $batchDeliveries->first()->id]) }}">Deliver All</a>
                                    <a class="p-2 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" href="{{ route('incoming_cancel', ['delivery' => $batchDeliveries->first()->id]) }}">Cancel All</a>
                                @endif
                            </div>
                        </td>
                    </tr> -->
                <tr>
                    <td colspan="7" class="border border-gray-700 py-2 px-4 text-sm font-bold bg-gray-200">
                        <div class="flex items-center justify-between">
                            Batch #{{ $batchId ?: 'Unassigned' }}
                            <div class="flex gap-2">
                                @if ($batchDeliveries->first()->status() === 'pending')
                                <a class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors" href="{{ route('incoming_deliver_batch', ['batchId' => $batchDeliveries->first()->batch_id]) }}">Deliver All</a>
                                <a class="p-2 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" href="{{ route('incoming_cancel_batch', ['batchId' => $batchDeliveries->first()->batch_id]) }}">Cancel All</a>
                                @elseif ($batchDeliveries->first()->status() === 'delivered')
                                <a class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded transition-colors" href="{{ route('incoming_receipt', ['batchId' => $batchDeliveries->first()->batch_id]) }}">Receipt</a>
                                <div class="w-full p-2 bg-green-500 text-white text-center rounded">Delivered</div>
                                @elseif ($batchDeliveries->first()->status() === 'cancelled')
                                <div class="p-2 bg-gray-500 text-white text-center rounded">Canceled</div>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                @foreach ($batchDeliveries as $delivery)
                <tr class="hover:bg-gray-50">
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->id }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->distributor->name }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">
                        <a class="text-blue-600 hover:text-blue-800 underline" href="/inventory/edit/{{ $delivery->product->id }}">
                            {{ $delivery->product->name }}
                        </a>
                    </td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->quantity }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ number_format($delivery->quantity * $delivery->product->price, 2) }} PHP</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->delivery }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">
                    {{--<div class="flex gap-2">
                            @if ($delivery->status() === 'pending')
                            <a class="p-2 bg-blue-600 hover:bg-blue-700 text-white rounded transition-colors" href="{{ route('incoming_deliver', ['delivery' => $delivery->id]) }}">Delivered</a>
                            <a class="p-2 bg-red-600 hover:bg-red-700 text-white rounded transition-colors" href="{{ route('incoming_cancel', ['delivery' => $delivery->id]) }}">Cancel</a>
                            @elseif ($delivery->status() === 'delivered')
                            <a class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition-colors" href="{{ route('receipt', ['delivery' => $delivery->id]) }}">Receipt</a>
                            @elseif ($delivery->status() === 'cancelled')
                            <div class="p-2 bg-gray-500 text-white text-center rounded">Canceled</div>
                            @endif
                        </div>--}}
                    </td>
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection