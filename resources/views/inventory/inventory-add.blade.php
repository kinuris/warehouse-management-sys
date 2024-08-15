@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Inventory Item</h1>
    <form action="{{ route('inventory_store') }}" method="POST">
        @csrf
        <div class="form-floating">
            <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" value="{{ old('name') }}">
            <label class="form-label" for="name">Product name</label>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex my-3">
            <div class="form-floating" style="flex: 1">
                <input class="form-control @error('price') is-invalid @enderror" id="price" name="price" step="0.01" type="number" value="{{ old('price') }}">
                <label class="form-label" for="price">Price</label>
                @error('price')
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