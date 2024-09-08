@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Incoming Delivery Management</h1>
    <a href="{{ route('incoming_add') }}" class="btn btn-primary mt-3">Add Incoming Delivery</a>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>ID</th>
                <th>Distributor</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Delivery Schedule</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach (App\Models\IncomingDelivery::all() as $delivery)
                <tr>
                    <td>{{ $delivery->id }}</td>
                    <td>{{ $delivery->distributor }}</td>
                    <td><a href="/inventory/edit/{{ $delivery->product->id }}">{{ $delivery->product->name }}</a></td>
                    <td>{{ $delivery->quantity }}</td>
                    <td>{{ $delivery->delivery }}</td>
                    <td>
                        <div class="btn-group">
                            @if ($delivery->status() === 'pending')
                            <a class="btn btn-primary" href="{{ route('incoming_deliver', ['delivery' => $delivery->id]) }}">Delivered</a>
                            <a class="btn btn-danger" href="{{ route('incoming_cancel', ['delivery' => $delivery->id]) }}">Cancel</a>
                            @elseif ($delivery->status() === 'delivered')
                            <div class="btn btn-success">Delivered</div>
                            @elseif ($delivery->status() === 'cancelled')
                            <div class="btn btn-secondary">Canceled</div>
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