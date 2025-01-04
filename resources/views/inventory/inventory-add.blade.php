@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <h1 class="mb-5 text-3xl font-bold">Create Item</h1>
    <form action="{{ route('inventory_store') }}" method="POST">
        @csrf
        <div class="flex">
            <div class="flex flex-col flex-1">
                <label class="form-label" for="name">Product name:</label>
                <input class="rounded p-1 border" id="name" name="name" type="text">
            </div>
            <div class="mx-2"></div>
            <div class="flex flex-col flex-1">
                <label for="category">Category:</label>
                <select class="rounded p-1.5 border" name="category" id="category">
                    @foreach (App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="flex my-3">
            <!-- <div class="flex flex-col flex-1">
                <label class="form-label" for="price">Profit (In PHP)</label>
                <input readonly disabled class="p-1 border bg-gray-100 rounded" id="price" name="price" step="0.01" type="number">
            </div> -->
            <div class="flex flex-col">
                <label for="base">Base Price (In PHP)</label>
                <input class="p-1 border rounded"  id="base" name="base" step="0.01" type="number">
            </div>
            <div class="mx-2"></div>
            <div class="flex flex-col">
                <label for="profit">Selling Price (In PHP)</label>
                <input class="p-1 border rounded"  id="profit" name="profit" step="0.01" type="number">
            </div>
            <div class="mx-2"></div>
            <div class="flex flex-col flex-1">
                <label class="form-label" for="name">Stock Qty.</label>
                <input class="p-1 border rounded" id="stock_qty" name="stock_qty" step="1" type="number">
            </div>
        </div>

        <input type="submit" value="Submit" class="p-1.5 rounded bg-blue-600 text-white">
    </form>
</div>
@endsection