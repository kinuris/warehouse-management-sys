@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Order Management</h1>
    <a href="{{ route('order_add') }}" class="btn btn-primary mt-3">Issue Order</a>

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
                    @if ($order->isFailed())
                    <td class="text-danger"><b>Failed</b></td>
                    @elseif ($order->isDelivered())
                    <td class="text-success"><b>Delivered</b></td>
                    @elseif ($order->isPending())
                    <td class="text-warning">Pending</td>
                    @endif
                    <td>{{ $order->delivery_time }}</td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-info" href="{{ route('item_view', ['order' => $order->id]) }}">View Items</a>
                            <a class="btn btn-danger" href="">Cancel</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection