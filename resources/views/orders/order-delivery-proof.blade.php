@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Delivery Proof For Order: # {{ $record->order_id }}</h1>
    <div class="card" style="width: 18rem;">
        <div class="card-img-top ratio ratio-1x1 rounded">
            <img src="{{ asset('storage/delivery/images/' . $record->image_link) }}" class="object-fit-cover" alt="Card Image">
        </div>
        <div class="card-body">
            <h5 class="card-title">Date & Time of Delivery</h5>
            <p class="card-text">{{ $record->delivery_time }}</p>
        </div>
    </div>

    <a href="{{ route('deliveries_success') }}" class="mt-4 btn btn-secondary">Back</a>
</div>
@endsection