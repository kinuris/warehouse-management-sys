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
                @foreach (App\Models\IncomingDelivery::all() as $delivery)
                <tr>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->id }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->distributor->name }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800"><a class="underline" href="/inventory/edit/{{ $delivery->product->id }}">{{ $delivery->product->name }}</a></td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->quantity }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ number_format($delivery->quantity * $delivery->product->price, 2) }} PHP</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $delivery->delivery }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">
                        <div class="flex gap-2">
                            @if ($delivery->status() === 'pending')
                            <a class="p-2 bg-blue-600 text-white rounded" href="{{ route('incoming_deliver', ['delivery' => $delivery->id]) }}">Delivered</a>
                            <a class="p-2 bg-red-600 text-white rounded" href="{{ route('incoming_cancel', ['delivery' => $delivery->id]) }}">Cancel</a>
                            @elseif ($delivery->status() === 'delivered')
                            <div class="w-full p-2 bg-green-500 text-white text-center">Delivered</div>
                            @elseif ($delivery->status() === 'cancelled')
                            <div class="p-2 bg-gray-500 text-white text-center">Canceled</div>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection