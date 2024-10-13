@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <h1>Edit Item</h1>
    <form action="{{ route('inventory_update', ['inventory' => $inventory->id]) }}" method="POST">
        @csrf
        <div class="d-flex">
            <div class="form-floating" style="flex: 1">
                <input class="form-control" value="{{ $inventory->name }}" id="name" name="name" type="text">
                <label class="form-label" for="name">Product name</label>
            </div>
            <div class="mx-2"></div>
            <div class="form-floating" style="flex: 1">
                <select class="form-select" name="category" id="category">
                    @foreach (App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" {{ $inventory->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="category">Category</label>
            </div>
        </div>

        <div class="d-flex my-3">
            <div class="form-floating" style="flex: 1">
                <input readonly disabled class="form-control" value="{{ $inventory->overhead->profit }}" id="price" name="price" step="0.01" type="number">
                <label class="form-label" for="price">Profit (In PHP)</label>
            </div>
            <div class="mx-2"></div>
            <div class="form-floating">
                <input class="form-control" value="{{ $inventory->overhead->base }}" id="base" name="base" step="0.01" type="number">
                <label for="base">Base Price (In PHP)</label>
            </div>
            <div class="mx-2"></div>
            <div class="form-floating">
                <input class="form-control" value="{{ number_format($inventory->price, 2) }}" id="profit" name="profit" step="0.01" type="number">
                <label for="profit">Selling Price (In PHP)</label>
            </div>
            <div class="mx-2"></div>
            <div class="form-floating" style="flex: 1">
                <input class="form-control" value="{{ $inventory->stock_qty }}" id="stock_qty" name="stock_qty" step="1" type="number">
                <label class="form-label" for="name">Stock Qty.</label>
            </div>
        </div>

        <input type="submit" value="Submit" class="btn btn-primary">
    </form>
</div>
@endsection