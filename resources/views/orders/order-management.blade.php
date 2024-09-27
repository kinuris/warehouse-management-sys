@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Management</h1>
    <a href="{{ route('order_add') }}" class="btn btn-primary mt-3">Issue Sale</a>

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
                @foreach($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client_name }} / {{ $order->client_phone }}</td>
                    <td>{{ $order->address }}</td>
                    @if ($order->isWalkIn())
                    <td class="text-success"><b>Walk-in</b></td>
                    @elseif ($order->isLateNotDelivered())
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
                            <a class="btn btn-info" href="{{ route('item_view', ['order' => $order->id]) }}">View Items</a>
                            <a class="btn btn-primary" href="{{ route('order_receipt', ['order' => $order->id]) }}">Receipt</a>
                            @if (!$order->isDelivered() && !$order->isFailed())
                            <a class="btn btn-danger" href="{{ route('order_delete', ['order' => $order->id]) }}">Cancel</a>
                            @endif
                            @if ($order->isDelivered())
                            <a class="btn btn-primary" href="{{ route('delivery_proof', ['order' => $order->id]) }}">Proof</a>
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