@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-800 mt-12 md:mt-0">Order Delivery Confirmation #{{ $record->order_id }}</h1>
        
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
            <div class="grid md:grid-cols-2 gap-8">
                <div>
                    <img src="{{ asset('storage/delivery/images/' . $record->image_link) }}" 
                         class="w-full h-auto rounded-lg shadow-md object-cover" 
                         alt="Delivery Confirmation Image">
                </div>
                <div class="flex flex-col justify-center">
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Delivery Details</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-600">Delivery Date & Time:</label>
                            <p class="text-lg font-medium">{{ \Carbon\Carbon::parse($record->delivery_time)->format('F j, Y, g:i a') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-start">
            @if (auth()->user()->isSysRole('manager'))
                <a href="{{ route('orders') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Back to Orders
                </a>
            @else
                <a href="{{ route('deliveries_success') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                    Back to Deliveries
                </a>
            @endif
        </div>
    </div>
</div>
@endsection