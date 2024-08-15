@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Warehouse Section(s): <b class="fst-italic">{{ $warehouse->name }}</b></h1>
    <a href="{{ route('warehouse_section_add', ['warehouse' => $warehouse->id]) }}" class="btn btn-primary">Add Section</a>
    <div class="d-flex flex-wrap">
        @foreach ($sections as $section)
        <div class="card m-3" style="width: 18rem; min-width: 18rem;">
            <div class="card-img-top ratio ratio-1x1 rounded">
                <img src="{{ asset('storage/section/images/' . $section->image_link) }}" class="object-fit-cover rounded" alt="Warehouse Thumbnail">
            </div>
            <div class="card-body">
                <p class="card-text">Description: {{ $section->description }}</p>

                <div class="btn-group">
                    <a href="#" class="btn btn-secondary">Edit</a>
                    <a href="{{ route('warehouse_section_delete', ['warehouse' => $warehouse->id, 'warehouseSection' => $section->id]) }}" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection