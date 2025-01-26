@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-4">Pending Deliveries</h1>

    <div class="table-responsive">
        <table class="min-w-full bg-white border border-gray-200">
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
                    <td class="py-2 px-4 border-b border-gray-200" colspan="6">
                        <p class="text-center">(No Pending Deliveries)</p>
                    </td>
                </tr>
                @else
                @foreach(array_filter($pending, fn($order) => !$order->isWalkIn()) as $order)
                <tr>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->id }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->client_name }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <a href="tel:{{ $order->client_phone }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $order->client_phone }}
                        </a>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->address }}</td>
                    @if ($order->isLateNotDelivered())
                    <td class="py-2 px-4 border-b border-gray-200 text-yellow-500"><b>Late (Not Delivered)</b></td>
                    @elseif ($order->isLateDelivered())
                    <td class="py-2 px-4 border-b border-gray-200 text-yellow-500"><b>Late (Delivered)</b></td>
                    @elseif ($order->isOnTimeDelivered())
                    <td class="py-2 px-4 border-b border-gray-200 text-green-500"><b>Delivered</b></td>
                    @elseif ($order->isFailed())
                    <td class="py-2 px-4 border-b border-gray-200 text-red-500"><b>Failed (Cancelled)</b></td>
                    @elseif ($order->isPending())
                    <td class="py-2 px-4 border-b border-gray-200 text-blue-500"><b>Pending</b></td>
                    @endif
                    <td class="py-2 px-4 border-b border-gray-200">{{ $order->delivery_time }}</td>
                    <td class="py-2 px-4 border-b border-gray-200">
                        <div class="flex space-x-2 justify-center">
                            <a class="btn btn-primary bg-blue-500 text-white py-1 px-3 rounded flex justify-center place-items-center w-full" href="{{ route('delivery_add', ['order' => $order->id]) }}">Delivered</a>
                            <a class="btn btn-info bg-blue-300 text-white py-1 px-3 rounded flex justify-center place-items-center w-full text-center" href="{{ route('item_view', ['order' => $order->id]) }}">View Items</a>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection