@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Incoming Delivery Management</h1>
        <a href="{{ route('incoming_add') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
            Add Incoming Delivery
        </a>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Distributor</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Schedule</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                // Consider moving this query to the Controller for better separation of concerns
                $deliveries = App\Models\IncomingDelivery::with(['distributor', 'product']) // Eager load relationships
                                ->orderBy('batch_id') // Optional: Order by batch_id
                                ->get()
                                ->groupBy('batch_id');
                @endphp

                @forelse ($deliveries as $batchId => $batchDeliveries)
                <tr class="bg-gray-100">
                    <td colspan="7" class="px-6 py-3 whitespace-nowrap text-sm font-semibold text-gray-700">
                        <div class="flex items-center justify-between">
                            <span>Batch #{{ $batchId ?: 'Unassigned' }}</span>
                            <div class="flex items-center space-x-2">
                                @php $firstDelivery = $batchDeliveries->first(); @endphp
                                @if ($firstDelivery && $firstDelivery->status() === 'pending')
                                    <a href="{{ route('incoming_deliver_batch', ['batchId' => $firstDelivery->batch_id]) }}" class="px-3 py-1 bg-green-500 text-white text-xs font-medium rounded hover:bg-green-600 transition-colors">Deliver All</a>
                                    <a href="{{ route('incoming_cancel_batch', ['batchId' => $firstDelivery->batch_id]) }}" class="px-3 py-1 bg-red-500 text-white text-xs font-medium rounded hover:bg-red-600 transition-colors">Cancel All</a>
                                @elseif ($firstDelivery && $firstDelivery->status() === 'delivered')
                                    <a href="{{ route('incoming_receipt', ['batchId' => $firstDelivery->batch_id]) }}" class="px-3 py-1 bg-blue-500 text-white text-xs font-medium rounded hover:bg-blue-600 transition-colors">Receipt</a>
                                    <span class="px-3 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Delivered</span>
                                @elseif ($firstDelivery && $firstDelivery->status() === 'cancelled')
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 text-xs font-medium rounded-full">Canceled</span>
                                @endif
                            </div>
                        </div>
                    </td>
                </tr>
                    @foreach ($batchDeliveries as $delivery)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $delivery->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $delivery->distributor->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <a class="text-blue-600 hover:text-blue-800 hover:underline" href="{{ route('inventory_edit', ['inventory' => $delivery->product->id]) }}">
                                {{ $delivery->product->name ?? 'N/A' }}
                            </a>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $delivery->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $delivery->product ? number_format($delivery->quantity * $delivery->product->price, 2) . ' PHP' : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ \Carbon\Carbon::parse($delivery->delivery)->format('Y-m-d') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{-- Individual row actions can be placed here if needed in the future --}}
                            {{-- Example:
                            <div class="flex space-x-2">
                                @if ($delivery->status() === 'pending')
                                <a href="{{ route('incoming_deliver', ['delivery' => $delivery->id]) }}" class="text-green-600 hover:text-green-900">Deliver</a>
                                <a href="{{ route('incoming_cancel', ['delivery' => $delivery->id]) }}" class="text-red-600 hover:text-red-900">Cancel</a>
                                @elseif ($delivery->status() === 'delivered')
                                <a href="{{ route('receipt', ['delivery' => $delivery->id]) }}" class="text-yellow-600 hover:text-yellow-900">Receipt</a>
                                @endif
                            </div>
                            --}}
                        </td>
                    </tr>
                    @endforeach
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">No incoming deliveries found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection