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
                    <td>-</td>
                    <td>-</td>
                </tr>
                @else
                @foreach($pending as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client_name }} / {{ $order->client_phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->delivery_time }}</td>
                    <td><a href="{{ route('delivery_add', ['order' => $order->id]) }}" class="btn btn-primary">Delivered</td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection