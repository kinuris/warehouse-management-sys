@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Issue Order</h1>
    <form action="{{ route('order_store') }}" method="post">
        @csrf
        <div class="d-flex">
            <div class="border rounded p-3 pt-2" style="flex: 2;">
                <div class="d-flex mb-2" style="place-items: center;">
                    <p class="m-0">Client Selection</p>
                    <input class="ms-3 me-1" type="checkbox" name="walk_in" id="walk-in">
                    <label for="walk-in">Walk-in Order?</label>
                </div>
                <div class="d-flex">
                    <div class="form-floating" style="flex: 1">
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" value="{{ old('name') }}" name="name" id="name">
                        <label class="form-label" for="name">Client Name:</label>
                        @if ($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="mx-2"></div>
                    <div class="form-floating" style="flex: 1">
                        <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="tel" value="{{ old('phone') }}" name="phone" id="tel">
                        <label class="form-label" for="tel">Client Phone:</label>
                        @if ($errors->has('phone'))
                        <div class="invalid-feedback">
                            {{ $errors->first('phone') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="form-floating my-3">
                    <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" value="{{ old('address') }}" name="address" id="address">
                    <label class="form-label" for="address">Client Address:</label>
                    @if ($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                    @endif
                </div>

                <div class="form-floating">
                    <input class="form-control {{ $errors->has('delivery_time') ? 'is-invalid' : '' }}" type="datetime-local" value="{{ old('delivery_time') }}" name="delivery_time" id="time">
                    <label for="time">Delivery Time (Deadline): </label>
                    @if ($errors->has('delivery_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('delivery_time') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="border rounded p-3 pt-2 ms-4" style="flex: 1;">

                <p>Items Added (Total: {{ $totalPrice }} PHP)</p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </thead>
                        <tbody>
                            @php($stage = Session::get('orderStage') ?? [])
                            @foreach ($products as $product)
                            @php($quantity = $stage[$product->id] ?? 0)
                            @if($quantity > 0)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->price }}</td>
                                <td>x{{ $quantity }}</td>
                                <td>{{ $product->price * $quantity }} PHP</td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <input class="btn btn-primary my-3" type="submit" value="Issue Order">

        <div class="border rounded p-3 pt-2">
            <p>Product Selection (Total: {{ $totalPrice }} PHP)</p>
            <div class="d-flex">
                <div class="form-floating">
                    <input value="{{ request()->query('search') }}" class="form-control" type="text" name="search" id="search">
                    <label class="form-label" for="search">Search</label>
                </div>

                <div class="form-floating mx-2">
                    <select class="form-select" name="category" id="category">
                        <option value="-1">All Categories</option>
                        @foreach (App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    <label class="form-label" for="category">Category Filter</label>
                </div>

                <button class="btn btn-primary" type="button" id="filter-btn">Filter</button>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock Qty.</th>
                        <th>Actions</th>
                        <th>
                            <div class="form-floating">
                                <input value="1" class="form-control" style="max-width: 128px; min-width: 128px;" type="number" step="1" min="1" name="quantity" id="quantity" placeholder="Quantity">
                                <label class="form-label" for="quantity">Quantity:</label>
                            </div>
                        </th>
                    </thead>
                    <tbody>
                        @php($stage = Session::get('orderStage') ?? [])
                        @foreach ($products as $product)
                        @php($quantity = $stage[$product->id] ?? 0)
                        <tr>
                            <td>{{ $product->internal_id }}</td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->price }} PHP</td>
                            <td>{{ $product->stock_qty }}<b class="text-danger" style="font-size: 12px;">{{ isset($stage[$product->id]) ? ' - ' . $stage[$product->id] : '' }}</b></td>
                            <td>
                                <div class="d-flex">
                                    <div class="btn-group mx-2">
                                        <button type="submit" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}" class="btn btn-primary">Add</button>
                                        <button type="submit" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}" class="btn btn-danger">Sub</button>
                                    </div>
                                    <p class="text-secondary">x{{ $quantity }} ({{ $quantity * $product->price }} PHP)</p>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </form>
</div>
@endsection

@section('script')
<script>
    const search = document.getElementById('search')
    const category = document.getElementById('category')
    const filterBtn = document.getElementById('filter-btn')

    filterBtn.addEventListener('click', function() {
        window.location.href = "{{ route('order_add') }}?search=" + encodeURI(search.value) + '&category=' + encodeURI(category.value)
    });
</script>
<script>
    const params = new URLSearchParams(window.location.search)

    const delivery = document.getElementById('time')
    const address = document.getElementById('address')
    const walkInChk = document.getElementById('walk-in')

    if (params.has('walkin')) {
        walkInChk.checked = true
        delivery.disabled = true
        address.disabled = true
    }

    walkInChk.addEventListener('change', function() {
        delivery.disabled = this.checked
        address.disabled = this.checked

        if (this.checked) {
            if (!params.has('walkin')) {
                params.append('walkin', true)
            }

            window.location.href = "{{ route('order_add') }}" + '?' + params.toString()
        } else {
            if (params.has('walkin')) {
                params.delete('walkin')
            }

            window.location.href = "{{ route('order_add') }}" + '?' + params.toString()
        }
    })
</script>
@endsection