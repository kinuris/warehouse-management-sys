@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-3">Issue Delivery Order</h1>
    <form class="flex" action="{{ route('order_store') }}" method="post" autocomplete="off" id="order-form">
        @csrf
        <input type="hidden" name="quantity" value="1">
        {{-- Product Selection Section --}}
        <div class="border border-gray-300 rounded p-4 bg-white shadow-sm mr-4 flex-1 flex flex-col">
            <div class="flex justify-between items-center mb-4">
                <p class="text-xl font-semibold text-gray-800">Product Selection (Total: {{ number_format($totalPrice, 2) }} PHP)</p>
                <button type="button" id="scan-barcode-btn" class="py-2 px-4 bg-green-600 text-white font-semibold rounded-md shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75 transition-colors">
                    Scan Barcode
                </button>
            </div>

            {{-- Barcode Scanner Placeholder --}}
            <div id="barcode-scanner-container" class="mb-4 hidden">
                <div id="reader" class="w-full max-w-md mx-auto"></div>
                <button type="button" id="close-scanner-btn" class="mt-2 py-1 px-3 bg-red-500 text-white rounded hover:bg-red-600">Close Scanner</button>
            </div>

            {{-- Filters --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 items-end">
                {{-- Search Input --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="search">Search Products</label>
                    <input value="{{ request()->query('search') }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm {{ $errors->has('search') ? 'border-red-500' : '' }}" type="text" name="search" id="search" placeholder="Search by name or ID...">
                    @if ($errors->has('search'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('search') }}</p>
                    @endif
                </div>

                {{-- Category Filter --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="category">Category</label>
                    <select class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm {{ $errors->has('category') ? 'border-red-500' : '' }}" name="category" id="category">
                        <option value="">All Categories</option>
                        @foreach (App\Models\Category::orderBy('name')->get() as $category)
                        <option value="{{ $category->id }}" {{ request()->query('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('category'))
                    <p class="mt-1 text-sm text-red-600">{{ $errors->first('category') }}</p>
                    @endif
                </div>

                {{-- Filter Button --}}
                <div class="md:col-start-3">
                    <button class="w-full py-2 px-4 bg-indigo-600 text-white font-semibold rounded-md shadow-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-75 transition-colors" type="button" id="filter-btn">
                        Apply Filters
                    </button>
                </div>
            </div>

            {{-- Product Table --}}
            <div class="flex-1 overflow-y-auto border border-gray-200 rounded mb-4">
                <div class="text-sm text-gray-600 italic px-4 py-2 bg-gray-50 border-b border-gray-200">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">ID</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Name</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Price</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Stock (Added)</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $stage = Session::get('orderStage') ?? []; @endphp
                            @forelse ($products as $product)
                            @php $quantityInStage = $stage[$product->id] ?? 0; @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700">{{ $product->internal_id }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-900 font-medium">{{ Str::limit($product->name, 40) }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-right">{{ number_format($product->price, 2) }} PHP</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-700 text-center">
                                    {{ $product->stock_qty }}
                                    @if($quantityInStage > 0)
                                    <span class="{{ ($product->stock_qty - $quantityInStage < 0) ? 'text-red-600' : 'text-blue-600' }} font-semibold ml-1">
                                        ({{ $quantityInStage }})
                                    </span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-center">
                                    <div class="flex items-center justify-center gap-1">
                                        {{-- Add Button --}}
                                        <button type="submit" title="Add one" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}"
                                            class="px-2 py-1 bg-blue-500 text-white rounded-l hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors text-xs"
                                            {{ $product->stock_qty <= $quantityInStage ? 'disabled' : '' }}>+</button>
                                        {{-- Subtract Button --}}
                                        <button type="submit" title="Subtract one" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}"
                                            class="px-2 py-1 bg-gray-400 text-white rounded-r hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors text-xs"
                                            {{ $quantityInStage <= 0 ? 'disabled' : '' }}>-</button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-sm text-gray-500 italic">
                                    No products found matching your criteria.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            @if ($products->hasPages())
            <div class="mt-auto pt-4 border-t border-gray-200">
                {{ $products->withQueryString()->links('vendor.pagination.simple-tailwind') }}
            </div>
            @endif
        </div>

        <div class="flex flex-col min-w-96 max-w-96">
            {{-- Customer Selection & Delivery Time Section --}}
            <div class="border border-gray-300 rounded p-4 bg-white shadow-sm mb-4">
                <div class="mb-4">
                    <p class="text-lg font-semibold text-gray-900">Order Details</p>
                    <p class="text-sm text-gray-600 mt-1">Select the customer and specify the delivery deadline.</p>
                </div>
                {{-- Customer Selection --}}
                <div class="flex flex-col w-full relative mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="customer_id">
                        Customer <span class="text-red-600">*</span>
                    </label>
                    <select
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm {{ $errors->has('customer_id') ? 'border-red-500' : '' }}"
                        name="customer_id"
                        id="customer_id">
                        <option value="">-- Select Customer --</option>
                        @foreach ($customers as $customer)
                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                            {{ $customer->name }} ({{ $customer->phone ?? 'N/A' }})
                        </option>
                        @endforeach
                    </select>
                    @if ($errors->has('customer_id'))
                    <p class="mt-1 text-sm text-red-600">
                        {{ $errors->first('customer_id') }}
                    </p>
                    @endif
                    <div class="mt-2 text-sm">
                        <a href="{{ route('customer.create') }}?redirect_url={{ urlencode(request()->fullUrl()) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900 hover:underline">
                            Add New Customer
                        </a>
                    </div>
                </div>
                {{-- Delivery Time --}}
                <div class="flex flex-col w-full relative">
                    <label class="block text-sm font-medium text-gray-700 mb-1" for="delivery_time">
                        Delivery Time (Deadline) <span class="text-red-600">*</span>
                    </label>
                    <input
                        class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm {{ $errors->has('delivery_time') ? 'border-red-500' : '' }}"
                        type="datetime-local"
                        value="{{ old('delivery_time') }}"
                        name="delivery_time"
                        id="delivery_time">
                    @if ($errors->has('delivery_time'))
                    <p class="mt-1 text-sm text-red-600">
                        {{ $errors->first('delivery_time') }}
                    </p>
                    @endif
                </div>
            </div>

            {{-- Products Added Section --}}
            <div class="border border-gray-300 rounded p-4 bg-gray-50 shadow-sm flex-1 flex flex-col">
                <div class="flex justify-between items-center mb-3">
                    <p class="text-lg font-semibold text-gray-800">Order Summary</p>
                    <span class="text-lg font-bold text-blue-600">{{ number_format($totalPrice, 2) }} PHP</span>
                </div>

                {{-- Table for Added Products --}}
                <div class="overflow-x-auto mb-4 border border-gray-200 rounded max-h-96 overflow-y-auto flex-1">
                    <table class="w-full bg-white text-sm">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="px-2 py-1 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200">Product</th>
                                <th class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 w-12">Qty</th>
                                <th class="px-2 py-1 text-right text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 w-20">Total</th>
                                <th class="px-1 py-1 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-200 w-24">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                            $stage = Session::get('orderStage') ?? [];
                            // Fetch only the products that are actually in the stage for efficiency
                            $stagedProductIds = array_keys($stage);
                            $stagedProducts = \App\Models\Product::whereIn('id', $stagedProductIds)->get()->keyBy('id');
                            @endphp

                            @if(empty($stage))
                            <tr>
                                <td colspan="4" class="px-3 py-4 text-center text-sm text-gray-500 italic">No products added yet.</td>
                            </tr>
                            @else
                            @foreach ($stage as $productId => $quantity)
                            @php
                            // Get the product details from the pre-fetched collection
                            $product = $stagedProducts->get($productId);
                            @endphp
                            {{-- Ensure product exists and quantity is positive --}}
                            @if($product && $quantity > 0)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-3 py-2 whitespace-nowrap text-sm text-gray-700">{{ Str::limit($product->name, 25) }}</td>
                                <td class="px-3 py-2 text-center text-sm text-gray-700">{{ $quantity }}</td>
                                <td class="px-3 py-2 text-right text-sm text-gray-700">{{ number_format($product->price * $quantity, 2) }}</td>
                                <td class="px-3 py-2 text-center text-sm text-gray-700">
                                    <div class="flex items-center justify-center gap-1">
                                        {{-- Add/Subtract Buttons --}}
                                        <div class="flex">
                                            <button type="submit" title="Add one" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}"
                                                class="px-2 py-1 bg-blue-500 text-white rounded-l hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors text-xs"
                                                {{ $product->stock_qty <= ($stage[$product->id] ?? 0) ? 'disabled' : '' }}>+</button>
                                            <button type="submit" title="Subtract one" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}"
                                                class="px-2 py-1 bg-gray-400 text-white rounded-r hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors text-xs">-</button>
                                        </div>
                                        {{-- Remove Button --}}
                                        <button type="submit" title="Remove item" formaction="{{ route('order_stage_remove', ['product' => $product->id]) }}"
                                            class="p-1 bg-red-500 text-white rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V5a1 1 0 00-1-1H9a1 1 0 00-1 1v2M5 7h14" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>

                {{-- Issue Order Button --}}
                <div class="mt-auto">
                    @if(!empty($stage))
                    <button type="submit" class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 transition-colors">
                        Issue Order ({{ number_format($totalPrice, 2) }} PHP)
                    </button>
                    @else
                    <button type="button" disabled class="w-full py-2 px-4 bg-gray-400 text-white font-semibold rounded cursor-not-allowed opacity-75">
                        Add Products to Order
                    </button>
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
{{-- Include html5-qrcode library --}}
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    const search = document.getElementById('search')
    const category = document.getElementById('category')
    const filterBtn = document.getElementById('filter-btn')
    filterBtn.addEventListener('click', function() {
        // Use the correct route name 'order_add' and encodeURIComponent
        window.location.href = "{{ route('order_add') }}?search=" + encodeURIComponent(search.value) + '&category=' + encodeURIComponent(category.value)
    });

    search.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            filterBtn.click();
        }
    });

    // Barcode Scanner Logic
    const scanBtn = document.getElementById('scan-barcode-btn');
    const scannerContainer = document.getElementById('barcode-scanner-container');
    const closeScannerBtn = document.getElementById('close-scanner-btn');
    const readerElement = document.getElementById('reader');
    const orderForm = document.getElementById('order-form');
    let html5QrCode = null;

    scanBtn.addEventListener('click', () => {
        scannerContainer.classList.remove('hidden');
        startScanner();
    });

    closeScannerBtn.addEventListener('click', () => {
        stopScanner();
    });

    function startScanner() {
        // Ensure the reader element is clean and recreate the instance
        readerElement.innerHTML = '';
        // Check if an instance already exists, if so, clear it first.
        // This helps prevent issues if startScanner is called multiple times without stopping.
        if (html5QrCode) {
             try {
                 if (html5QrCode.isScanning) {
                     html5QrCode.stop();
                 }
                 html5QrCode.clear(); // Clear previous instance resources
             } catch (e) {
                 console.error("Error clearing previous scanner instance:", e);
             }
        }
        html5QrCode = new Html5Qrcode("reader");

        const config = {
            fps: 10,
            qrbox: {
                width: 180,
                height: 180
            }
        };

        html5QrCode.start({
                facingMode: "environment"
            }, config, onScanSuccess, onScanFailure)
            .catch(err => {
                console.error(`Unable to start scanning, error: ${err}`);
                alert('Error starting scanner. Please ensure camera permissions are granted and try refreshing the page.');
                stopScanner(); // Ensure scanner UI is hidden if start fails
            });

        // Ensure container is visible after attempting to start
        scannerContainer.classList.remove('hidden');
    }

    function stopScanner() {
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.stop().then(ignore => {
                console.log("QR Code scanning stopped.");
                // Optionally clear the instance after stopping
                // html5QrCode.clear();
                // html5QrCode = null; // Reset the variable if you want a completely new instance next time
            }).catch(err => {
                console.error("Failed to stop scanning.", err);
            });
        } else {
             console.log("Scanner not running or already stopped.");
        }
        scannerContainer.classList.add('hidden');
        readerElement.innerHTML = ''; // Clear the reader element content
    }

    function onScanSuccess(decodedText, decodedResult) {
        // handle the scanned code as you like, for example:
        console.log(`Code matched = ${decodedText}`, decodedResult);

        // Don't stop scanner immediately to allow continuous scanning
        // Instead, temporarily disable scanning while processing
        if (html5QrCode && html5QrCode.isScanning) {
            html5QrCode.pause(); // Pause scanning
        }

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
                        return response.json().then(err => {
                            throw new Error(err.error || 'Product not found');
                        });
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

                // Note: The page will reload due to form submission.
                // The 'keep_scanner_open' logic in DOMContentLoaded will handle reopening.
            })
            .catch(error => {
                console.error('Error finding product:', error);
                alert(`Error: ${error.message}`);
                // Resume scanning if there was an error and scanner is paused
                if (html5QrCode && !html5QrCode.isScanning) {
                    try {
                        html5QrCode.resume();
                    } catch (e) {
                        console.error("Error resuming scanner:", e);
                        // If resuming fails, might need to stop/start again
                        stopScanner();
                        // Optionally try restarting
                        // startScanner();
                    }
                }
            });
    }

    function onScanFailure(error) {
        // handle scan failure, usually better to ignore and keep scanning.
        // console.warn(`Code scan error = ${error}`);
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Check if we should keep the scanner open (from a previous scan)
        // Use Blade directive to safely output boolean
        const keepScannerOpen = @json(Session::has('keep_scanner_open'));

        if (keepScannerOpen) {
            // Don't automatically call startScanner here if the container is already visible
            // The user might have closed it manually before the page fully loaded.
            // Instead, just ensure the container is visible. The user can click "Scan" again if needed.
            // Or, if the intention is to always restart scanning after adding, call startScanner.
             scannerContainer.classList.remove('hidden');
             startScanner(); // Re-initialize and start scanning

            // Forget the session key after using it so it doesn't persist across unrelated page loads
            @php Session::forget('keep_scanner_open'); @endphp
        }
    });
</script>
@endsection