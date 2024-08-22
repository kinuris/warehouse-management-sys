@extends('layouts.app')

@section('content')
<div class="container">
    <h1>
        <b><i>{{ $item->name }} ({{ $item->internal_id }})</i></b> can be found in {{ count($sections) }} section(s):
    </h1>
    <div class="d-flex flex-wrap">
        @foreach ($sections as $section)
        @php($section = $section->getWarehouseSection())
        <div class="card m-3" style="width: 18rem; min-width: 18rem;">
            <div class="card-img-top ratio ratio-1x1 rounded">
                <img src="{{ asset('storage/section/images/' . $section->image_link) }}" class="object-fit-cover rounded" alt="Warehouse Thumbnail">
            </div>
            <div class="card-body">
                <h5 class="card-title">Warehouse: <b><i>{{ $section->getWarehouse()->name }}</i></b></h5>
                <p class="card-text">Description: {{ $section->description }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection