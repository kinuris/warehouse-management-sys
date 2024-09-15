@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pending Deliveries</h1>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>Order ID</th>
                <th>Client Name / Phone</th>
                <th>Address</th>
                <th>Status</th>
                <th>Delivery Time (Deadline)</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @if(count($pending) === 0)
                <tr>
                    <td>
                        <p>(No Pending Deliveries)</p>
                    </td>
                    <td>-</td>
                    <td>-</td>
                    <td>_</td>
                    <td>-</td>
                    <td>-</td>
                </tr>
                @else
                @foreach(array_filter($pending, fn($order) => !$order->isWalkIn()) as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client_name }} / {{ $order->client_phone }}</td>
                    <td>{{ $order->address }}</td>
                    @if ($order->isLateNotDelivered())
                    <td class="text-warning"><b>Late (Not Delivered)</b></td>
                    @elseif ($order->isLateDelivered())
                    <td class="text-warning"><b>Late (Delivered)</b></td>
                    @elseif ($order->isOnTimeDelivered())
                    <td class="text-success"><b>Delivered</b></td>
                    @elseif ($order->isFailed())
                    <td class="text-danger"><b>Failed (Cancelled)</b></td>
                    @elseif ($order->isPending())
                    <td class="text-info"><b>Pending</b></td>
                    @endif
                    <td>{{ $order->delivery_time }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary" href="{{ route('delivery_add', ['order' => $order->id]) }}">Delivered</a>
                            <a class="btn btn-info" href="{{ route('item_view', ['order' => $order->id]) }}">View Items</a>
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