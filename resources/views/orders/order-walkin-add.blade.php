@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-3">Issue Walk-in Order</h1>
    <form class="flex" action="{{ route('order_store') }}" method="post">
        @csrf
        <div class="border border-black rounded p-3 pt-2 mr-3">
            <p class="text-xl font-bold">Product Selection (Total: {{ $totalPrice }} PHP)</p>
            <div class="d-flex">
                <div class="flex flex-col">
                    <label class="form-label" for="search">Search</label>
                    <input value="{{ request()->query('search') }}" class="border border-gray-500 p-1 rounded {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="search" id="search">
                </div>

                <div class="flex flex-col mt-2">
                    <label class="form-label" for="category">Category Filter</label>
                    <select class="border border-gray-500 p-1 rounded {{ $errors->has('name') ? 'is-invalid' : '' }}" name="category" id="category">
                        <option value="-1">All Categories</option>
                        @foreach (App\Models\Category::all() as $category)
                        <option {{ request()->query('category') == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button class="rounded bg-blue-600 text-white p-2 mt-2" type="button" id="filter-btn">Filter</button>
            </div>
            <div class="table-responsive mt-10">
                <table class="table">
                    <div class="flex mb-3 flex-col">
                        <label class="form-label" for="quantity">Quantity:</label>
                        <input value="1" class="border border-gray-500 p-1 rounded {{ $errors->has('name') ? 'is-invalid' : '' }}" style="max-width: 128px; min-width: 128px;" type="number" step="1" min="1" name="quantity" id="quantity" placeholder="Quantity">
                    </div>
                    <thead>
                        <th class="border border-gray-700 py-1 text-sm text-gray-800">ID</th>
                        <th class="border border-gray-700 py-1 text-sm text-gray-800">Name</th>
                        <th class="border border-gray-700 py-1 text-sm text-gray-800">Price</th>
                        <th class="border border-gray-700 py-1 text-sm text-gray-800">Stock Qty.</th>
                        <th class="border border-gray-700 py-1 text-sm text-gray-800">Actions</th>
                    </thead>
                    <tbody>
                        @php($stage = Session::get('orderStage') ?? [])
                        @foreach ($products as $product)
                        @php($quantity = $stage[$product->id] ?? 0)
                        <tr>
                            <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->internal_id }}</td>
                            <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->name }}</td>
                            <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ number_format($product->price, 2) }} PHP</td>
                            @if ($product->stock_qty - $quantity < 0)
                                <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->stock_qty }}<b class="text-danger" style="font-size: 12px;">{{ isset($stage[$product->id]) ? ' - ' . $stage[$product->id] : '' }}</b></td>
                                @else
                                <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->stock_qty }}<b class="text-danger" style="font-size: 12px;">{{ isset($stage[$product->id]) ? ' - ' . $stage[$product->id] : '' }}</b></td>
                                @endif
                                <td class="border border-gray-700 py-1 text-sm text-gray-800">
                                    <div class="flex">
                                        <div class="flex mx-2">
                                            <button type="submit" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}" class="p-1.5 bg-blue-600 rounded-l text-white">Add</button>
                                            <button type="submit" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}" class="p-1.5 bg-red-500 rounded-r text-white">Sub</button>
                                        </div>
                                        <p class="text-secondary">x{{ $quantity }} ({{ $quantity * $product->price }} PHP)</p>
                                    </div>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-col min-w-[450px]">
            <div class="border border-black bg-blue-200 rounded p-3 pt-2 mb-3">
                <div class="mb-2">
                    <p class="m-0 text-lg font-bold">Client Selection</p>
                    <input class="mr-1 hidden" checked type="checkbox" name="walk_in" id="walk-in">
                    <label class="hidden" for="walk-in">Walk-in Order?</label>
                </div>
                <div class="justify-between">
                    <div class="flex flex-col w-full">
                        <label class="form-label" for="name">Client Name:</label>
                        <input class="border border-gray-500 p-1 rounded {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" value="{{ old('name') }}" name="name" id="name">
                        @if ($errors->has('name'))
                        <div class="mt-0 text-sm text-red-600">
                            {{ $errors->first('name') }}
                        </div>
                        @endif
                    </div>
                    <div class="mx-2"></div>
                    <div class="flex flex-col w-full">
                        <label class="form-label" for="tel">Client Phone:</label>
                        <input class="border border-gray-500 p-1 rounded {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="tel" value="{{ old('phone') }}" name="phone" id="tel">
                        @if ($errors->has('phone'))
                        <div class="mt-0 text-sm text-red-600">
                            {{ $errors->first('phone') }}
                        </div>
                        @endif
                    </div>
                </div>

                <div class="hidden flex-col my-3">
                    <label class="form-label" for="address">Client Address:</label>
                    <input class="border border-gray-500 p-1 rounded {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" value="{{ old('address') }}" name="address" id="address">
                    @if ($errors->has('address'))
                    <div class="mt-0 text-sm text-red-600">
                        {{ $errors->first('address') }}
                    </div>
                    @endif
                </div>

                <div class="hidden flex-col my-3">
                    <label for="time">Delivery Time (Deadline): </label>
                    <input class="border border-gray-500 p-1 rounded {{ $errors->has('delivery_time') ? 'is-invalid' : '' }}" type="datetime-local" value="{{ old('delivery_time') }}" name="delivery_time" id="time">
                    @if ($errors->has('delivery_time'))
                    <div class="mt-0 text-sm text-red-600">
                        {{ $errors->first('delivery_time') }}
                    </div>
                    @endif
                </div>
            </div>
            <div class="border border-black rounded p-3 pt-2 bg-blue-200" style="flex: 2;">
                <p class="text-lg font-bold">Products Added (Total: {{ $totalPrice }} PHP)</p>
                <input class="shadow p-1.5 rounded bg-blue-600 text-white my-3" type="submit" value="Issue Order">
                <div class="table-responsive">
                    <table class="min-w-full">
                        <thead>
                            <th class="border border-gray-700 py-1 text-sm text-gray-800">Name</th>
                            <th class="border border-gray-700 py-1 text-sm text-gray-800">Price</th>
                            <th class="border border-gray-700 py-1 text-sm text-gray-800">Qty</th>
                            <th class="border border-gray-700 py-1 text-sm text-gray-800">Total</th>
                            <th class="border border-gray-700 py-1 text-sm text-gray-800">Action</th>
                        </thead>
                        <tbody>
                            @php($stage = Session::get('orderStage') ?? [])
                            @foreach (App\Models\Product::all() as $product)
                            @php($quantity = $stage[$product->id] ?? 0)
                            @if($quantity > 0)
                            <tr>
                                <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->name }}</td>
                                <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->price }}</td>
                                @if ($product->stock_qty - $quantity < 0)
                                    <td class="border border-gray-700 py-1 text-sm text-gray-800">x{{ $quantity }}</td>
                                    @else
                                    <td class="border border-gray-700 py-1 text-sm text-gray-800">x{{ $quantity }}</td>
                                    @endif
                                    <td class="border border-gray-700 py-1 text-sm text-gray-800">{{ $product->price * $quantity }} PHP</td>
                                    <td class="border border-gray-700 py-1 text-sm text-gray-800">
                                        <div class="flex">
                                            <form method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <div class="btn-group">
                                                    <button type="submit" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}" class="btn btn-primary">+</button>
                                                    <button type="submit" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}" class="btn btn-secondary">-</button>
                                                </div>
                                            </form>
                                            <form class="ms-2" method="POST">
                                                @csrf
                                                <input type="hidden" name="quantity" value="{{ $quantity }}">
                                                <button type="submit" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}" class="btn btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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