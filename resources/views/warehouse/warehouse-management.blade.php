@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Warehouse Management</h1>
    <a href="{{ route('warehouse_add') }}" class="btn btn-primary my-3">
        Add Warehouse
    </a>

    <p class="text-secondary mb-1">Warehouses</p>
    <div class="d-flex flex-wrap">
        @foreach ($warehouses as $warehouse)
        <div class="card m-3" style="width: 18rem; min-width: 18rem;">
            <div class="card-img-top ratio ratio-1x1 rounded">
                <img src="{{ asset('storage/warehouse/images/' . $warehouse->image_link) }}" class="object-fit-cover rounded" alt="Warehouse Thumbnail">
            </div>
            <div class="card-body">
                <h5 class="card-title">{{ $warehouse->name }}</h5>
                <p class="card-text">Description: {{ $warehouse->description }}</p>
                <p class="card-text text-secondary">No. of Sections: {{ count($warehouse->sections()) }}</p>

                <div class="btn-group">
                    <a href="{{ route('warehouse_section', ['warehouse' => $warehouse->id]) }}" class="btn btn-primary">Sections</a>
                    <a href="#" class="btn btn-secondary">Edit</a>
                    <a href="#" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection