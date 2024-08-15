@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-3">Delete this section?</h1>
    <h3>Section Thumbnail</h3>
    <div class="mb-4 card-img-top ratio ratio-1x1 rounded" style="width: 18rem; min-width: 18rem;">
        <img class="object-fit-cover rounded" src="{{ asset('storage/section/images/' . $section->image_link) }}" alt="Section Thumbnail">
    </div>
    <h3>Description:</h3>
    <p>{{ $section->description }}</p>

    <a href="{{ route('warehouse_section', ['warehouse' => $warehouse->id]) }}" class="btn btn-secondary">Back</a>
    <a href="{{ route('warehouse_section_destroy', ['warehouse' => $warehouse->id, 'warehouseSection' => $section->id]) }}" class="btn btn-danger">Delete</a>
</div>
@endsection