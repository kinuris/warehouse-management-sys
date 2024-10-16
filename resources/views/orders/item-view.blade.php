@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <h1 class="m-0">Order For: </h1>
    <h5 class="m-0 ms-1 text-secondary">{{ $order->client_name }} / {{ $order->client_phone }}</h5>
    <h5 class="ms-1 mb-3 text-secondary">Delivery: {{ $order->delivery_time }}</h5>

    <h2>Items (Total: {{ $totalPrice }} PHP)</h2>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>Item ID</th>
                <th>Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach($orderItems as [$item, $quantity])
                <tr>
                    <td>{{ $item->internal_id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $quantity }}</td>
                    <td>{{ $item->price }} PHP</td>
                    <td>{{ $item->price * $quantity }} PHP</td>
                    <td>
                        <a class="btn btn-info" href="{{ route('item_sections', ['product' => $item->id]) }}">View In Warehouse</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('orders') }}" class="btn btn-secondary mt-3">Back</a>
</div>
@endsection