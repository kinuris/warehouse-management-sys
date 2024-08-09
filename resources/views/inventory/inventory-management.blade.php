@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-lg-flex justify-content-between">
        <h1>Inventory Managment</h1>
        <form class="d-flex" action="{{ route('employee_attendance') }}">
            <input type="text" value="{{ request()->query('search') }}" name="search" id="search" placeholder="Search" class="form-control" style="min-width: 200px;">

            <!-- <select class="ms-2 form-select" name="scope" id="scope">
                <option value="day" {{ request()->query('scope') === 'day' ? 'selected' : '' }}>Last Day</option>
                <option value="week" {{ request()->query('scope') === 'week' ? 'selected' : '' }}>Last Week</option>
                <option value="month" {{ request()->query('scope') === 'month' ? 'selected' : '' }}>Last Month</option>
            </select> -->

            <input type="submit" value="Filter" class="btn btn-primary ms-2">
        </form>
    </div>
    <a href="{{ route('inventory_add') }}" class="btn btn-primary mt-3">
        Add Inventory Item
    </a>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Stock Qty.</th>
            </thead>
            <tbody>
                @foreach ($products as $product)
                <tr>
                    <td>{{ $product->internal_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->stock_qty }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection