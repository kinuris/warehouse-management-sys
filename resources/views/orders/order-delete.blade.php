@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Cancel Order: #{{ $order->id }}</h1>
    <a href="{{ route('orders') }}" class="btn btn-secondary me-3">Back</a>
    <a href="{{ route('order_destroy', ['order' => $order->id]) }}" class="btn btn-danger">Cancel</a>
</div>
@endsection
