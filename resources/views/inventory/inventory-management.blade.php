@extends('layouts.app')

@section('content')
<div class="container" style="position: relative;">
    <img src="{{ asset('assets/gradient.jpg') }}" style="position: fixed; left: 0; z-index: -1; top: 0; width: 100%; height: 100vh; opacity: 0.2; object-fit: cover;" alt="Background">
    <div class="d-lg-flex justify-content-between">
        <h1>Inventory Managment</h1>
        <form class="d-flex" action="{{ route('inventory') }}">
            <input type="text" value="{{ request()->query('search') }}" name="search" id="search" placeholder="Search" class="form-control" style="min-width: 200px;">

            <input type="submit" value="Filter" class="btn btn-primary ms-2">
        </form>
    </div>
    <a href="{{ route('inventory_add') }}" class="btn btn-primary my-3">
        Add Inventory Item
    </a>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Stock Qty.</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->internal_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }} PHP</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->stock_qty }}</td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('inventory_edit', ['inventory' => $product->id]) }}" class="btn btn-primary">Edit</a>
                            @if ($product->is_suspended)
                            <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}" class="btn btn-info">Allow</a> 
                            @else
                            <a href="{{ route('inventory_delete', ['inventory' => $product->id]) }}" class="btn btn-danger">Suspend</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection