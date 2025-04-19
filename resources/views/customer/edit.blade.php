@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h1 class="text-xl font-semibold text-gray-700">Edit Customer: <span class="text-gray-900">{{ $customer->name }}</span></h1>
        </div>

        @if ($errors->any())
            <div class="m-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
                <p class="font-bold mb-2">Please correct the errors below:</p>
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customer.update', $customer) }}" method="POST" class="px-6 py-6">
            @csrf
            @method('PUT')

            {{-- Name Field --}}
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="name">
                    Name <span class="text-red-500">*</span>
                </label>
                <input class="shadow-sm appearance-none border @error('name') border-red-500 @else border-gray-300 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="name" name="name" type="text" placeholder="Customer Name" value="{{ old('name', $customer->name) }}" required>
                @error('name')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Field --}}
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="email">
                    Email
                </label>
                <input class="shadow-sm appearance-none border @error('email') border-red-500 @else border-gray-300 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="email" name="email" type="email" placeholder="customer@example.com" value="{{ old('email', $customer->email) }}">
                @error('email')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Phone Field --}}
            <div class="mb-5">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="phone">
                    Phone
                </label>
                <input class="shadow-sm appearance-none border @error('phone') border-red-500 @else border-gray-300 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="phone" name="phone" type="text" placeholder="Phone Number" value="{{ old('phone', $customer->phone) }}">
                @error('phone')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Address Field --}}
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-medium mb-1" for="address">
                    Address
                </label>
                <textarea class="shadow-sm appearance-none border @error('address') border-red-500 @else border-gray-300 @enderror rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" id="address" name="address" placeholder="Customer Address" rows="3">{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center justify-end space-x-4 pt-4 border-t border-gray-200">
                <a href="{{ route('customer.index') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-50 transition ease-in-out duration-150">
                    Cancel
                </a>
                <button class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 transition ease-in-out duration-150" type="submit">
                    Update Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
