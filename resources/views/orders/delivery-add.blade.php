@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Register Delivery</h1>
    <form enctype="multipart/form-data" action="{{ route('order_deliver', ['order' => $order->id]) }}" method="POST">
        @csrf
        <div class="form-floating">
            <input class="form-control @error('delivery_time') is-invalid @enderror" type="datetime-local" value="{{ old('delivery_time') ?? now() }}" required name="delivery_time" id="time">
            <label for="time">Delivery Time:</label>
            @error('delivery_time')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating my-3">
            <input class="form-control @error('proof') is-invalid @enderror" type="file" name="proof" id="proof" required>
            <label for="proof">Proof of Delivery:</label>
            @error('proof')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a class="btn btn-secondary" href="{{ route('deliveries') }}">Back</a>
        <input class="btn btn-primary" type="submit" value="Register Delivery">
    </form>
</div>
@endsection