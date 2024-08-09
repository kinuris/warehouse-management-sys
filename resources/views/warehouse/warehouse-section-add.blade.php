@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Add Section: <b class="fst-italic">{{ $warehouse->name }}</b></h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('warehouse_section_store', ['warehouse' => $warehouse->id]) }}">
        @csrf
        <input type="hidden" name="warehouse_id" value="{{ $warehouse->id }}">

        <div class="form-floating">
            <textarea style="height: 96px; resize: none;" class="form-control" name="description" id="description"></textarea>
            <label for="description">Location Description:</label>
        </div>

        <div class="form-floating mb-4 mt-3">
            <input class="form-control" type="file" name="image" id="image">
            <label class="form-label" for="image">Section Image:</label>
        </div>

        <input class="btn btn-primary" type="submit" value="Submit">
    </form>
</div>
@endsection