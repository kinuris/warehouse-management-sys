@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Incoming Delivery</h1>

    <div class="border rounded p-3">
        <form action="{{ route('incoming_store') }}" method="POST">
            @csrf
            <div class="d-flex">
                <div class="form-floating" style="flex: 1">
                    <input class="form-control" type="text" name="distributor" id="distributor">
                    <label for="distributor">Distributor Name</label>
                </div>
                <div class="mx-2"></div>
                <div class="form-floating" style="flex: 1">
                    <select class="form-select" name="product" id="product">
                        @foreach (App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option> 
                        @endforeach
                    </select>
                    <label for="product">Product</label>
                </div>
            </div>

            <div class="d-flex mt-3">
                <div class="form-floating" style="flex: 1">
                    <input class="form-control" type="text" id="quantity" name="quantity">
                    <label for="quantity">Quantity</label>
                </div>
                <div class="mx-2"></div>
                <div class="form-floating" style="flex: 1">
                    <input class="form-control" type="datetime-local" name="delivery" id="delivery">
                    <label for="delivery">Delivery Time</label>
                </div>
            </div>

            <button class="btn btn-primary mt-3" type="submit">Add Incoming Delivery</button>
        </form>
    </div>
</div>
@endsection