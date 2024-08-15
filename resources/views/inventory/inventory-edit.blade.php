@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Item</h1>
    <form action="{{ route('inventory_update', ['inventory' => $inventory->id]) }}" method="POST">
        @csrf
        <div class="form-floating">
            <input class="form-control" value="{{ $inventory->name }}" id="name" name="name" type="text">
            <label class="form-label" for="name">Product name</label>
        </div>

        <div class="d-flex my-3">
            <div class="form-floating" style="flex: 1">
                <input class="form-control" value="{{ $inventory->price }}" id="price" name="price" step="0.01" type="number">
                <label class="form-label" for="price">Price</label>
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