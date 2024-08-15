@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Successful Deliveries</h1>

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
                @if(count($success) === 0)
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
                @foreach($success as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client_name }} / {{ $order->client_phone }}</td>
                    <td>{{ $order->address }}</td>
                    <td>{{ $order->delivery_time }}</td>
                    <td><a href="{{ route('delivery_proof', ['order' => $order->id]) }}" class="btn btn-info">View Proof</a></td>
                </tr>
                @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection