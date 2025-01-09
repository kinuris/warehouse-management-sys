@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-6">Successful Deliveries</h1>

    <div class="table-responsive">
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
</div>
@endsection