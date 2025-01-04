@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold">Add Incoming Delivery</h1>

    <div class="my-8"></div>

    <div class="border border-black rounded p-3">
        <form action="{{ route('incoming_store') }}" method="POST">
            @csrf
            <div class="flex">
                <div class="flex flex-col" style="flex: 1">
                    <label for="distributor">Distributor Name:</label>
                    <input class="p-1.5 border border-black rounded" type="text" name="distributor" id="distributor">
                </div>
                <div class="mx-2"></div>
                <div class="flex flex-col flex-1">
                    <label for="product">Product:</label>
                    <select class="p-1.5 border border-black rounded" name="product" id="product">
                        @foreach (App\Models\Product::all() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option> 
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="flex mt-3">
                <div class="flex flex-col flex-1">
                    <label for="quantity">Quantity:</label>
                    <input class="p-1.5 border border-black rounded" type="text" id="quantity" name="quantity">
                </div>
                <div class="mx-2"></div>
                <div class="flex flex-col flex-1">
                    <label for="delivery">Delivery Time:</label>
                    <input class="p-1.5 border border-black rounded" type="datetime-local" name="delivery" id="delivery">
                </div>
            </div>

            <button class="p-2 bg-blue-600 text-white rounded mt-5" type="submit">Add Incoming Delivery</button>
        </form>
    </div>
</div>
@endsection