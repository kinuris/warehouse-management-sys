@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Warehouse</h1>
    <form enctype="multipart/form-data" action="{{ route('warehouse_store') }}" method="POST">
        @csrf
        <div class="form-floating">
            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}">
            <label class="form-label" for="name">Warehouse Name</label>
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating my-3">
            <textarea style="height: 96px; resize: none;" class="form-control @error('description') is-invalid @enderror" name="description" id="description">{{ old('description') }}</textarea>
            <label for="description">Description (Optional):</label>
            @error('description')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-floating mb-4">
            <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image">
            <label class="form-label" for="image">Image:</label>
            @error('image')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <a href="{{ route('warehouse') }}" class="btn btn-secondary">Back</a>
        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
</div>
@endsection