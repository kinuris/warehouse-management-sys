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
                    <select class="p-1.5 border border-black rounded @error('distributor') border-red-500 @enderror" name="distributor" id="distributor">
                        @php($distributors = App\Models\Distributor::all())
                        @if ($distributors->isEmpty())
                            <option value="" disabled selected>No distributors available</option>
                        @endif
                        @foreach ($distributors as $distributor)
                        <option value="{{ $distributor->id }}" {{ old('distributor') == $distributor->id ? 'selected' : '' }}>{{ $distributor->name }}</option>
                        @endforeach
                    </select>
                    @error('distributor')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mx-2"></div>
                <div class="flex flex-col flex-1">
                    <label for="product">Product:</label>
                    <select class="p-1.5 border border-black rounded @error('product') border-red-500 @enderror" name="product" id="product">
                        @foreach (App\Models\Product::all() as $product)
                        <option value="{{ $product->id }}" {{ old('product') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                        @endforeach
                    </select>
                    @error('product')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex mt-3">
                <div class="flex flex-col flex-1">
                    <label for="quantity">Quantity:</label>
                    <input class="p-1.5 border border-black rounded @error('quantity') border-red-500 @enderror" type="number" step="1" id="quantity" name="quantity" value="{{ old('quantity') }}" oninput="if(this.value.length > 3) this.value = this.value.slice(0, 3);" onkeydown="if(event.key === 'e' || event.key === 'E' || event.key === 'p' || event.key === 'i') event.preventDefault();">
                    @error('quantity')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div class="mx-2"></div>
                <div class="flex flex-col flex-1">
                    <label for="delivery">Delivery Time:</label>
                    <input class="p-1.5 border border-black rounded @error('delivery') border-red-500 @enderror" type="datetime-local" name="delivery" id="delivery" value="{{ old('delivery') }}">
                    @error('delivery')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            </div>

            <button class="p-2 bg-blue-600 text-white rounded mt-5" type="submit">Add Incoming Delivery</button>
        </form>
    </div>
</div>
@endsection