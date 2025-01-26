@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Item</h1>
        
        <form action="{{ route('inventory_store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="name">Product Name</label>
                    <input class="w-full p-2.5 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           id="name" name="name" type="text" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="category">Category</label>
                    <select class="w-full p-2.5 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            name="category" id="category" required>
                        @foreach (App\Models\Category::all() as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-3 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="base">Base Price (PHP)</label>
                    <input class="w-full p-2.5 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           id="base" name="base" type="number" step="0.01" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="profit">Selling Price (PHP)</label>
                    <input class="w-full p-2.5 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           id="profit" name="profit" type="number" step="0.01" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2" for="stock_qty">Stock Quantity</label>
                    <input class="w-full p-2.5 rounded-md border-2 border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           id="stock_qty" name="stock_qty" type="number" step="1" required>
                </div>
            </div>

            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md shadow-sm transition-colors">
                Create Item
            </button>
        </form>
    </div>
</div>
@endsection