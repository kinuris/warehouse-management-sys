@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <h1 class="text-3xl font-bold mb-8 text-gray-800 border-b pb-4">Add Incoming Delivery</h1>

    <div class="bg-white shadow-md rounded-lg p-6 border border-gray-200">
        <form action="{{ route('incoming_store') }}" method="POST">
            @csrf
            <div class="flex flex-col md:flex-row gap-6 mb-6">
                <div class="flex-1">
                    <label for="distributor" class="block text-sm font-medium text-gray-700 mb-2">Distributor Name</label>
                    <select class="w-full rounded-md shadow-sm  p-1.5 border rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('distributor') border-red-500 @enderror"
                        name="distributor" id="distributor">
                        @php($distributors = App\Models\Distributor::all())
                        @if ($distributors->isEmpty())
                        <option value="" disabled selected>No distributors available</option>
                        @endif
                        @foreach ($distributors as $distributor)
                        <option value="{{ $distributor->id }}" {{ old('distributor') == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
                        @endforeach
                    </select>
                    @error('distributor')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex-1">
                    <label for="delivery" class="block text-sm font-medium text-gray-700 mb-2">Delivery Time</label>
                    <input class="w-full shadow-sm  p-1 border rounded border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('delivery') border-red-500 @enderror"
                        type="datetime-local" name="delivery" id="delivery" value="{{ old('delivery') }}">
                    @error('delivery')
                    <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div id="product-list" class="space-y-4">
                <div class="flex flex-col md:flex-row gap-6">
                    <div class="flex-1">
                        <label for="products[]" class="block text-sm font-medium text-gray-700 mb-2">(1) Product</label>
                        <select class="w-full rounded-md p-1.5 border shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('products.0') border-red-500 @enderror"
                            name="products[]">
                            @foreach (App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}" {{ old('products.0') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                            @endforeach
                        </select>
                        @error('products.0')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex-1">
                        <label for="quantities[]" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input class="w-full rounded-md shadow-sm border border-gray-300 p-1 focus:border-blue-500 focus:ring focus:ring-blue-200 transition @error('quantities.0') border-red-500 @enderror"
                            type="number" step="1" name="quantities[]" value="{{ old('quantities.0') }}"
                            oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);"
                            onkeydown="if(event.key === 'e' || event.key === 'E' || event.key === 'p' || event.key === 'i') event.preventDefault();">
                        @error('quantities.0')
                        <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mt-6 flex gap-4">
                <button type="button" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-md transition shadow-sm flex items-center"
                    onclick="addProductRow()">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Another Product
                </button>
                <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition shadow-sm flex items-center"
                    type="submit">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    Add Incoming Delivery
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addProductRow() {
        const productList = document.getElementById('product-list');
        const newRow = document.createElement('div');
        newRow.className = 'flex mt-3';
        newRow.innerHTML = `
        <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1">
            <label for="products[]" class="block text-sm font-medium text-gray-700 mb-2">(${productList.children.length + 1}) Product</label>
            <select class="p-1.5 border w-full rounded-md shadow-sm border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition" name="products[]">
                @foreach (App\Models\Product::all() as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
            </div>

            <div class="flex-1">
            <label for="quantities[]" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
            <input class="w-full rounded-md shadow-sm border-gray-300 p-1 border focus:border-blue-500 focus:ring focus:ring-blue-200 transition"
                   type="number" step="1" name="quantities[]"
                   oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);"
                   onkeydown="if(event.key === 'e' || event.key === 'E' || event.key === 'p' || event.key === 'i') event.preventDefault();">
            </div>

            <div class="flex items-end">
            <button type="button" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-md transition shadow-sm"
                onclick="removeProductRow(this)">Remove</button>
            </div>
        </div>
    `;
        productList.appendChild(newRow);
    }

    function removeProductRow(button) {
        const row = button.closest('.flex.mt-3');
        row.remove();
        updateProductLabels();
    }

    function updateProductLabels() {
        const productList = document.getElementById('product-list');
        const rows = productList.children;
        for (let i = 0; i < rows.length; i++) {
            const label = rows[i].querySelector('label');
            label.textContent = `(${i + 1}) Product:`;
        }
    }
</script>
@endsection