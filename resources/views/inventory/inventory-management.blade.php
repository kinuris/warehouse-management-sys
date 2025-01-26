@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6 min-h-screen" style="position: relative;">
    <!-- Header Section with improved spacing and grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        <div class="lg:col-span-2">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Inventory Management</h1>
            <form class="flex items-center max-w-xl" action="{{ route('inventory') }}">
                <input class="w-full px-4 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-blue-500"
                    type="text"
                    value="{{ request()->query('search') }}"
                    name="search"
                    id="search"
                    placeholder="Search inventory...">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-r transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Search
                </button>
            </form>
        </div>

        <!-- Stats Card with improved styling -->
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <?php
            // Existing PHP code remains the same
            use App\Models\Order;

            $orders = Order::query()
                ->where('created_at', '>=', now()->subDay())
                ->get();

            $totalItemsAndQuantity = [];

            foreach ($orders as $order) {
                $itemsAndQuantity = $order->getItemsAndQuantity();
                foreach ($itemsAndQuantity as [$item, $quantity]) {
                    if (!isset($totalItemsAndQuantity[$item]))
                        $totalItemsAndQuantity[$item] = 0;
                    $totalItemsAndQuantity[$item] += $quantity;
                }
            }
            ?>
            <h2 class="font-semibold text-gray-800 mb-3 text-lg">Today's Outgoing Items</h2>
            <hr class="border-gray-200 mb-4">
            <div class="max-h-16 overflow-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300">
                @foreach ($totalItemsAndQuantity as $item => $quantity)
                @php($item = App\Models\Product::find($item))
                <div class="flex justify-between items-center mb-3 pb-2 border-b border-gray-100 last:border-0">
                    <span class="text-gray-700">{{ $item->name }}</span>
                    <span class="font-bold text-red-600 bg-red-50 px-3 py-1 rounded-full">{{ $quantity }}</span>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Action Button with improved styling -->
    <div class="mb-8 flex justify-between items-center">
        <a href="{{ route('inventory_add') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-200 shadow-md">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Inventory Item
        </a>
    </div>

    <!-- Inventory Table with improved styling -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Qty</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($products as $product)
                    <tr class="hover:bg-gray-50 transition duration-150">
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $product->internal_id }}</td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ $product->name }}</td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ number_format($product->price, 2) }}</td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $product->category->name }}</td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ $product->stock_qty }}</td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm text-gray-700">{{ number_format($product->stock_qty * $product->price, 2) }}</td>
                        <td class="px-3 py-3 whitespace-nowrap text-sm">
                            <div class="flex space-x-1">
                                <a href="{{ route('inventory_edit', ['inventory' => $product->id]) }}"
                                    class="px-2 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs">Edit</a>
                                @if ($product->is_suspended)
                                <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}"
                                    class="px-2 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs">Allow</a>
                                @else
                                <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}"
                                    class="px-2 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs">Suspend</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <div class="p-2">
            {{ $products->links('vendor.pagination.tailwind') }}
        </div>
    </div>
</div>
@endsection