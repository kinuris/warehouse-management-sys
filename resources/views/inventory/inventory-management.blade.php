@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 min-h-screen">
    <!-- Header Section -->
    <div class="mb-6">
        <h1 class="text-4xl font-bold text-gray-800">Inventory Management</h1>
    </div>

    <!-- Action Bar: Search and Add Button -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <!-- Search Form -->
        <div class="flex-grow">
            <form class="flex items-center w-full" action="{{ route('inventory') }}">
                <label for="search" class="sr-only">Search inventory</label>
                <input class="flex-grow px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out"
                    type="text"
                    value="{{ request()->query('search') }}"
                    name="search"
                    id="search"
                    placeholder="Search by name or ID...">
                <button type="submit" class="inline-flex items-center px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-r-md border border-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
            </form>
        </div>

        <!-- Add New Item Button -->
        <div class="flex-shrink-0">
            <a href="{{ route('inventory_add') }}" class="w-full md:w-auto inline-flex items-center justify-center px-5 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Item
            </a>
        </div>
    </div>

    <!-- Summary Section: Today's Outgoing Items -->
    <div class="mb-8">
        <div class="bg-white rounded-lg shadow-md p-5 border border-gray-200">
            <?php
            // Existing PHP code remains the same
            use App\Models\Order;
            use App\Models\Product;

            $orders = Order::query()
                ->where('created_at', '>=', now()->subDay())
                ->get();

            $totalItemsAndQuantity = [];

            foreach ($orders as $order) {
                $itemsAndQuantity = $order->getItemsAndQuantity();
                foreach ($itemsAndQuantity as [$itemId, $quantity]) {
                    if (!isset($totalItemsAndQuantity[$itemId]))
                        $totalItemsAndQuantity[$itemId] = 0;
                    $totalItemsAndQuantity[$itemId] += $quantity;
                }
            }
            // Fetch product names efficiently
            $productIds = array_keys($totalItemsAndQuantity);
            $productsInfo = Product::whereIn('id', $productIds)->pluck('name', 'id');
            ?>
            <h2 class="text-lg font-semibold text-gray-700 mb-3">Today's Outgoing Items</h2>
            <hr class="border-gray-200 mb-4">
            @if (empty($totalItemsAndQuantity))
                <p class="text-sm text-gray-500">No items shipped today.</p>
            @else
                <div class="max-h-24 overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
                    @foreach ($totalItemsAndQuantity as $itemId => $quantity)
                    <div class="flex justify-between items-center mb-2 pb-2 border-b border-gray-100 last:border-0 last:pb-0 last:mb-0">
                        <span class="text-sm text-gray-600 truncate pr-2">{{ $productsInfo[$itemId] ?? 'Unknown Item' }}</span>
                        <span class="text-sm font-medium text-red-600 bg-red-100 px-2.5 py-0.5 rounded-full">{{ $quantity }}</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Price</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Quantity</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Total Value</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Barcode</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $product->internal_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($product->price, 2) }} PHP</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->category->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $product->stock_qty }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ number_format($product->stock_qty * $product->price, 2) }} PHP</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="bg-white p-1 border border-gray-200 rounded">
                                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->barcode, 'C128', 1.5, 30, [255, 255, 255], [0, 0, 0]) }}" alt="Barcode">
                                </div>
                                <a href="data:image/png;base64,{{ DNS1D::getBarcodePNG($product->barcode, 'C128', 1.5, 30, [255, 255, 255], [0, 0, 0]) }}" 
                                   download="barcode-{{ $product->internal_id }}.png"
                                   class="text-xs text-blue-600 hover:text-blue-800 font-medium">
                                    Download
                                </a>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                             @if ($product->is_suspended)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Suspended
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('inventory_edit', ['inventory' => $product->id]) }}"
                                   title="Edit"
                                   class="text-indigo-600 hover:text-indigo-900 transition duration-150 ease-in-out">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}"
                                   title="{{ $product->is_suspended ? 'Activate' : 'Suspend' }}"
                                   class="{{ $product->is_suspended ? 'text-green-600 hover:text-green-900' : 'text-red-600 hover:text-red-900' }} transition duration-150 ease-in-out">
                                    @if ($product->is_suspended)
                                        {{-- Activate Icon --}}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    @else
                                        {{-- Suspend Icon --}}
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    @endif
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-6 py-10 text-center text-sm text-gray-500">
                            No inventory items found matching your search criteria.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
        @endif
    </div>
</div>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);
        
        // Don't stop scanner immediately to allow continuous scanning
        // Instead, temporarily disable scanning while processing
        html5QrCode.pause();

        // Find product by barcode via AJAX
        fetch(`{{ route('order_find_by_barcode') }}?barcode=${encodeURIComponent(decodedText)}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    return response.json().then(err => { throw new Error(err.error || 'Product not found'); });
                }
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(product => {
            console.log('Product found:', product);
            // Add product to stage by submitting the form with a specific action
            const addUrl = `/order/stage/${product.id}/add`;
            const tempForm = document.createElement('form');
            tempForm.method = 'post';
            tempForm.action = addUrl;

            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}'; // Add CSRF token
            tempForm.appendChild(csrfInput);

            const quantityInput = document.createElement('input');
            quantityInput.type = 'hidden';
            quantityInput.name = 'quantity';
            quantityInput.value = '1'; // Add quantity 1 by default
            tempForm.appendChild(quantityInput);

            // Add a flag to keep scanner open after redirect
            const keepScannerOpenInput = document.createElement('input');
            keepScannerOpenInput.type = 'hidden';
            keepScannerOpenInput.name = 'keep_scanner_open';
            keepScannerOpenInput.value = '1';
            tempForm.appendChild(keepScannerOpenInput);

            document.body.appendChild(tempForm);
            tempForm.submit();
        })
        .catch(error => {
            console.error('Error finding product:', error);
            alert(`Error: ${error.message}`);
            // Resume scanning if there was an error
            html5QrCode.resume();
        });
    }
</script>
@endsection