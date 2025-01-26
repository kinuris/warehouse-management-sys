@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-5xl">
    <img src="{{ asset('assets/gradient.jpg') }}" class="fixed inset-0 w-full h-full object-cover opacity-20 -z-10" alt="Background">
    
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Item</h1>
        
        <form action="{{ route('inventory_update', ['inventory' => $inventory->id]) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="name">Product Name</label>
                    <input class="w-full rounded-md border-2 border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" 
                           value="{{ $inventory->name }}" id="name" name="name" type="text">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="category">Category</label>
                    <select class="w-full rounded-md border-2 border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            name="category" id="category">
                        @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}" {{ $inventory->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-4 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="price">Profit (PHP)</label>
                    <input readonly disabled class="w-full rounded-md border-2 border-gray-300 px-3 py-2 bg-gray-50 cursor-not-allowed"
                           value="{{ $inventory->overhead->profit }}" id="price" name="price" step="0.01" type="number">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="base">Base Price (PHP)</label>
                    <input class="w-full rounded-md border-2 border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                           value="{{ $inventory->overhead->base }}" id="base" name="base" step="0.01" type="number">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="profit">Selling Price (PHP)</label>
                    <input class="w-full rounded-md border-2 border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                           value="{{ $inventory->price }}" id="profit" name="profit" step="0.01" type="number">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="stock_qty">Stock Qty.</label>
                    <input class="w-full rounded-md border-2 border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                           value="{{ $inventory->stock_qty }}" id="stock_qty" name="stock_qty" step="1" type="number">
                </div>
            </div>

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                Save Changes
            </button>
        </form>
    </div>
</div>
@endsection