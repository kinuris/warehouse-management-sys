@extends('layouts.app')

@section('content')
<div class="container" style="position: relative;">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <div class="flex">
        <div>
            <h1 class="text-3xl font-bold">Inventory Management</h1>
            <form class="flex my-5" action="{{ route('inventory') }}">
                <input class="p-1 rounded" type="text" value="{{ request()->query('search') }}" name="search" id="search" placeholder="Search">
                <input type="submit" value="Filter" class="p-1.5 bg-blue-600 text-white rounded ms-2">
            </form>
        </div>
        <div class="flex-1"></div>
        <div class="bg-white/40 rounded-lg p-2 shadow-lg flex flex-col">
            <?php

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
            <p class="font-semibold">Outgoing today</p>
            <hr class="border-gray-400 my-2">
            <div class="flex justify-between max-h-32 overflow-auto">
                <div class="flex flex-col gap-2">
                    @foreach ($totalItemsAndQuantity as $item => $quantity)
                    @php($item = App\Models\Product::find($item))
                    <p class="text-red-600">{{ $item->name }} - <b>{{ $quantity }}</b></p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <a href="{{ route('inventory_add') }}" class="p-2 bg-blue-600 text-white rounded">
        Add Inventory Item
    </a>

    <div class="my-5"></div>

    <div>
        <table class="table">
            <thead>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">ID</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Name</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Price</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Category</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Stock Qty.</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Total</th>
                <th class="border border-gray-700 py-2 px-4 text-sm text-gray-800">Actions</th>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $product->internal_id }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $product->name }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ number_format($product->price, 2) }} PHP</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $product->category->name }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ $product->stock_qty }}</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">{{ number_format($product->stock_qty * $product->price, 2) }} PHP</td>
                    <td class="border border-gray-700 py-2 px-4 text-sm text-gray-800">
                        <div class="flex">
                            <a href="{{ route('inventory_edit', ['inventory' => $product->id]) }}" class="bg-green-600 rounded-l p-1.5 text-white">Edit</a>
                            @if ($product->is_suspended)
                            <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}" class="bg-blue-600 rounded-r p-1.5 text-white">Allow</a>
                            @else
                            <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}" class="bg-red-600 rounded-r p-1.5 text-white">Suspend</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection