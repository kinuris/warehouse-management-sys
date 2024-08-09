@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Warehouse</h1>
    <form enctype="multipart/form-data" action="{{ route('warehouse_store') }}" method="POST">
        @csrf
        <div class="form-floating">
            <input class="form-control" type="text" name="name" id="name">
            <label class="form-label" for="name">Warehouse Name</label>
        </div>

        <div class="form-floating my-3">
            <textarea style="height: 96px; resize: none;" class="form-control" name="description" id="description"></textarea>
            <label for="description">Description (Optional):</label>
        </div>

        <div class="form-floating mb-4">
            <input class="form-control" type="file" name="image" id="image">
            <label class="form-label" for="image">Image:</label>
        </div>

        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
</div>
@endsection