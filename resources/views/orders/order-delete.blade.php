@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold text-red-500 mb-5">Cancel Order: #{{ $order->id }}</h1>
    <a href="{{ route('orders') }}" class="p-1.5 rounded bg-gray-400 text-white mr-1">Back</a>
    <a href="{{ route('order_destroy', ['order' => $order->id]) }}" class="p-1.5 rounded bg-red-500 text-white">Cancel</a>
</div>
@endsection
