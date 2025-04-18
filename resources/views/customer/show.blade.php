@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Customer Details</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Name:</strong>
            <p class="text-gray-700">{{ $customer->name }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Email:</strong>
            <p class="text-gray-700">{{ $customer->email ?? 'N/A' }}</p>
        </div>
        <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Phone:</strong>
            <p class="text-gray-700">{{ $customer->phone ?? 'N/A' }}</p>
        </div>
        <div class="mb-6">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Address:</strong>
            <p class="text-gray-700">{{ $customer->address ?? 'N/A' }}</p>
        </div>
         <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Created At:</strong>
            <p class="text-gray-700">{{ $customer->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
         <div class="mb-4">
            <strong class="block text-gray-700 text-sm font-bold mb-2">Updated At:</strong>
            <p class="text-gray-700">{{ $customer->updated_at->format('Y-m-d H:i:s') }}</p>
        </div>
        <div class="flex items-center justify-start mt-6">
            <a href="{{ route('customer.edit', $customer) }}" class="bg-indigo-500 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded mr-2">
                Edit
            </a>
            <a href="{{ route('customer.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                Back to List
            </a>
        </div>
    </div>
</div>
@endsection
