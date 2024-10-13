@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <h1>Add Inventory Item</h1>
    <form action="{{ route('inventory_store') }}" method="POST">
        @csrf
        <div class="d-flex">
            <div class="form-floating" style="flex: 1">
                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}">
                <label class="form-label" for="name">Product name</label>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mx-2"></div>
            <div class="form-floating" style="flex: 1">
                <select class="form-select" name="category" id="category">
                    @foreach (App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <label for="category">Category</label>
            </div>
        </div>

        <div class="d-flex my-3">
            <div class="form-floating">
                <input class="form-control @error('price') is-invalid @enderror" id="base" name="base" step="0.01" type="number" value="{{ old('base') }}">
                <label class="form-label" for="base">Base Price (In PHP)</label>
                @error('base')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mx-2"></div>
            <div class="form-floating">
                <input class="form-control @error('price') is-invalid @enderror" id="profit" name="profit" step="0.01" type="number" value="{{ old('profit') }}">
                <label class="form-label" for="profit">Selling Price (In PHP)</label>
                @error('profit')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mx-2"></div>
            <div class="form-floating" style="flex: 1">
                <input class="form-control @error('stock_qty') is-invalid @enderror" id="stock_qty" name="stock_qty" step="1" type="number" value="{{ old('stock_qty') }}">
                <label class="form-label" for="stock_qty">Stock Qty.</label>
                @error('stock_qty')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>


        <input type="submit" value="Submit" class="btn btn-primary">
    </form>
</div>
@endsection