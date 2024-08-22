@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Section: <b class="fst-italic">{{ $warehouse->name }}</b></h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('warehouse_section_store', ['warehouse' => $warehouse->id]) }}">
        @csrf
        <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">

        <div class="form-floating">
            <textarea style="height: 96px; resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
            <label for="description">Location Description:</label>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-4 mt-3">
            <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image">
            <label class="form-label" for="image">Section Image:</label>
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div id="applicable" class="form-group mb-3">
            <label for="choice">Products in Section:</label>
            <select class="form-select @error('products') is-invalid @enderror" multiple name="products[]" id="choice">
            </select>
            @error('products')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('warehouse_section', ['warehouse' => $warehouse->id]) }}" class="btn btn-secondary">Back</a>
        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
</div>
@endsection

@section('script')
<script>
    window.addEventListener('load', function() {
        const element = document.getElementById('choice');

        const choices = new Choices(element, {
            allowHTML: true,
            removeItemButton: true,
            searchResultLimit: 10,
            choices: [
                <?php

                use App\Models\Product;

                $products = Product::all();

                foreach ($products as $product) {
                    echo "{ value: '" . $product->id . "', label: '" . $product->name . "' },";
                }
                ?>
            ]
        });
    });
</script>
@endsection