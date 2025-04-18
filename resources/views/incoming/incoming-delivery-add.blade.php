@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-10 max-w-5xl">
    <header class="mb-10">
        <h1 class="text-4xl font-bold text-gray-800 border-b border-gray-300 pb-4">Add New Incoming Delivery</h1>
        <p class="mt-2 text-sm text-gray-600">Fill in the details below to record a new delivery.</p>
    </header>

    <div class="bg-white shadow-xl rounded-lg p-8 border border-gray-200">
        <form action="{{ route('incoming_store') }}" method="POST">
            @csrf
            {{-- Distributor and Delivery Time Section --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <label for="distributor" class="block text-sm font-semibold text-gray-700 mb-2">Distributor Name</label>
                    <select id="distributor" name="distributor" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('distributor') border-red-500 @enderror">
                        @php($distributors = App\Models\Distributor::all())
                        @if ($distributors->isEmpty())
                            <option value="" disabled selected>No distributors available</option>
                        @else
                            <option value="" disabled {{ old('distributor') ? '' : 'selected' }}>Select a distributor</option>
                            @foreach ($distributors as $distributor)
                                <option value="{{ $distributor->id }}" {{ old('distributor') == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
                            @endforeach
                        @endif
                    </select>
                    @error('distributor')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="delivery" class="block text-sm font-semibold text-gray-700 mb-2">Delivery Date & Time</label>
                    <input id="delivery" name="delivery" type="datetime-local" value="{{ old('delivery') }}" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('delivery') border-red-500 @enderror">
                    @error('delivery')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Product List Section --}}
            <h2 class="text-xl font-semibold text-gray-700 mb-4 border-t pt-6">Products</h2>
            <div id="product-list" class="space-y-6">
                {{-- Initial Product Row --}}
                <div class="product-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end border p-4 rounded-md bg-gray-50">
                    <div class="md:col-span-6">
                        <label for="products[]" class="block text-sm font-semibold text-gray-700 mb-2 product-label">(1) Product</label>
                        <select name="products[]" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('products.0') border-red-500 @enderror">
                            <option value="" disabled {{ old('products.0') ? '' : 'selected' }}>Select a product</option>
                            @foreach (App\Models\Product::all() as $product)
                                <option value="{{ $product->id }}" {{ old('products.0') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('products.0')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-5">
                        <label for="quantities[]" class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                        <input type="number" step="1" name="quantities[]" value="{{ old('quantities.0') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out @error('quantities.0') border-red-500 @enderror"
                               oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);"
                               onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();"
                               min="1">
                        @error('quantities.0')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    {{-- Placeholder for alignment, no remove button on the first row --}}
                    <div class="md:col-span-1"></div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-4">
                <button type="button" onclick="addProductRow()" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Another Product
                </button>
                <button type="submit" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2 -ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                    </svg>
                    Save Incoming Delivery
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let productIndex = 1; // Start index for dynamically added rows

    function addProductRow() {
        productIndex++;
        const productList = document.getElementById('product-list');
        const newRow = document.createElement('div');
        newRow.className = 'product-row grid grid-cols-1 md:grid-cols-12 gap-4 items-end border p-4 rounded-md bg-gray-50 animate-fade-in'; // Added animation class
        newRow.innerHTML = `
            <div class="md:col-span-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2 product-label">(${productIndex}) Product</label>
                <select name="products[]" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                    <option value="" disabled selected>Select a product</option>
                    @foreach (App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
                {{-- Placeholder for potential error message --}}
            </div>

            <div class="md:col-span-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                <input type="number" step="1" name="quantities[]"
                       class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                       oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);"
                       onkeydown="if(['e', 'E', '+', '-'].includes(event.key)) event.preventDefault();"
                       min="1">
                {{-- Placeholder for potential error message --}}
            </div>

            <div class="md:col-span-1 flex justify-end">
                <button type="button" onclick="removeProductRow(this)" class="inline-flex items-center justify-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        `;
        productList.appendChild(newRow);
        // Optional: Scroll the new row into view
        newRow.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function removeProductRow(button) {
        const rowToRemove = button.closest('.product-row');
        rowToRemove.classList.add('animate-fade-out'); // Add fade-out animation class
        // Wait for animation to finish before removing
        rowToRemove.addEventListener('animationend', () => {
            rowToRemove.remove();
            updateProductLabels();
            productIndex--; // Decrement index after removal
        });
    }

    function updateProductLabels() {
        const productList = document.getElementById('product-list');
        const rows = productList.querySelectorAll('.product-row');
        rows.forEach((row, index) => {
            const label = row.querySelector('.product-label');
            if (label) {
                label.textContent = `(${index + 1}) Product`;
            }
        });
        // Reset productIndex if all dynamic rows are removed
        if (rows.length === 1) {
            productIndex = 1;
        } else {
             // Ensure productIndex reflects the current highest number
            productIndex = rows.length;
        }
    }
</script>

{{-- Add simple fade-in/out animation styles --}}
<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeOut {
        from { opacity: 1; transform: translateY(0); }
        to { opacity: 0; transform: translateY(-10px); }
    }
    .animate-fade-in {
        animation: fadeIn 0.3s ease-out forwards;
    }
    .animate-fade-out {
        animation: fadeOut 0.3s ease-out forwards;
    }
</style>
@endsection