@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-3xl font-bold mb-3">Issue Walk-in Order</h1>
    <form class="flex" action="{{ route('order_store') }}" method="post" autocomplete="off">
        @csrf
        <input type="hidden" name="walk_in" value="1">
        <input type="hidden" name="quantity" value="1">
        <div class="border border-black rounded p-3 pt-2 mr-3 flex-1">
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

            <div class="table-responsive mt-2">
                <div class="text-sm text-gray-600 italic my-3">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">ID</th>
                            <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Name</th>
                            <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Price</th>
                            <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Stock Qty.</th>
                            <th class="border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php($stage = Session::get('orderStage') ?? [])
                        @foreach ($products as $product)
                        @php($quantity = $stage[$product->id] ?? 0)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800">{{ $product->internal_id }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800">{{ $product->name }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800">{{ number_format($product->price, 2) }} PHP</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-gray-800">
                                {{ $product->stock_qty }}
                                @if(isset($stage[$product->id]))
                                <span class="{{ ($product->stock_qty - $quantity < 0) ? 'text-red-600' : 'text-blue-600' }} font-medium ml-1">
                                    ({{ $stage[$product->id] }})
                                </span>
                                @endif
                            </td>
                            <td class="border border-gray-300 px-4 py-2 text-sm">
                                <div class="flex items-center justify-center gap-1">
                                    <button type="submit" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-l hover:bg-blue-600 transition-colors">+</button>
                                    <button type="submit" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}"
                                        class="px-3 py-1 bg-gray-500 text-white rounded-r hover:bg-gray-600 transition-colors">−</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="p-2">
                {{ $products->withQueryString()->links('vendor.pagination.simple-tailwind') }}
            </div>
        </div>

        <div class="flex flex-col min-w-96 max-w-96">
            <div class="border border-black bg-blue-200 rounded p-3 pt-2 mb-3">
                <div class="mb-2 hidden">
                    <p class="m-0 text-lg font-bold">Client Selection</p>
                    <input class="mr-1" checked type="checkbox" name="walk_in" id="walk-in">
                    <label for="walk-in">Walk-in Order?</label>
                </div>
                <div class="flex flex-col w-full relative">
                    <label class="form-label" for="name">Client Name:</label>
                    <div class="relative">
                        <input class="border border-gray-500 p-1 rounded w-full {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" value="{{ old('name') }}" name="name" id="name" autocomplete="off">
                        <button type="button" class="absolute right-2 top-1/2 transform -translate-y-1/2 hidden" id="clearName">✕</button>
                    </div>

                    <div class="absolute bg-white border border-gray-300 rounded mt-1 w-full max-h-48 overflow-y-auto" style="top: 100%; z-index: 1000;">
                        <ul id="choices">

                        </ul>
                    </div>
                    @if ($errors->has('name'))
                    <div class="mt-0 text-sm text-red-600">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                </div>

                <div class="flex flex-col w-full mt-3">
                    <label class="form-label" for="tel">Client Phone:</label>
                    <input maxlength="11" class="border border-gray-500 p-1 rounded {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="tel" value="{{ old('phone') }}" name="phone" id="tel">
                    @if ($errors->has('phone'))
                    <div class="mt-0 text-sm text-red-600">
                        {{ $errors->first('phone') }}
                    </div>
                    @endif
                </div>

                {{--<div class="flex flex-col my-3">
                    <label class="form-label" for="address">Client Address:</label>
                    <input class="border border-gray-500 p-1 rounded {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" value="{{ old('address') }}" name="address" id="address">
                    @if ($errors->has('address'))
                    <div class="mt-0 text-sm text-red-600">
                        {{ $errors->first('address') }}
                    </div>
                    @endif
                </div>

                <div class="flex flex-col my-3">
                    <label for="time">Delivery Time (Deadline): </label>
                    <input class="border border-gray-500 p-1 rounded {{ $errors->has('delivery_time') ? 'is-invalid' : '' }}" type="datetime-local" value="{{ old('delivery_time') }}" name="delivery_time" id="time">
                    @if ($errors->has('delivery_time'))
                    <div class="mt-0 text-sm text-red-600">
                        {{ $errors->first('delivery_time') }}
                    </div>
                    @endif
                </div>--}}
            </div>

            <div class="border border-black rounded p-3 pt-2 bg-blue-200">
                <p class="text-lg font-bold">Products Added (Total: {{ $totalPrice }} PHP)</p>
                <input class="shadow p-1.5 rounded bg-blue-600 text-white my-3" type="submit" value="Issue Order">
                <div class="table-responsive">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <th class="border border-gray-300 py-2 px-3 text-sm font-semibold text-gray-700">Name</th>
                            <th class="border border-gray-300 py-2 px-3 text-sm font-semibold text-gray-700">Qty</th>
                            <th class="border border-gray-300 py-2 px-3 text-sm font-semibold text-gray-700">Total</th>
                            <th class="border border-gray-300 py-2 px-3 text-sm font-semibold text-gray-700">Action</th>
                        </thead>
                        <tbody>
                            @php($stage = Session::get('orderStage') ?? [])
                            @foreach (App\Models\Product::all() as $product)
                            @php($quantity = $stage[$product->id] ?? 0)
                            @if($quantity > 0)
                            <tr class="hover:bg-gray-50">
                                <td class="border border-gray-300 py-2 px-3 text-sm text-gray-800">{{ Str::limit($product->name, 24) }}</td>
                                <td class="border border-gray-300 py-2 px-3 text-sm text-gray-800">x{{ $quantity }}</td>
                                <td class="border border-gray-300 py-2 px-3 text-sm text-gray-800">{{ number_format($product->price * $quantity, 2) }} PHP</td>
                                <td class="border border-gray-300 py-2 px-3 text-sm text-gray-800">
                                    <div class="flex items-center gap-2">
                                        <div class="flex">
                                            <button type="submit" formaction="{{ route('order_stage_add', ['product' => $product->id]) }}"
                                                class="px-2 py-1 bg-blue-500 text-white rounded-l hover:bg-blue-600 transition-colors">+</button>
                                            <button type="submit" formaction="{{ route('order_stage_sub', ['product' => $product->id]) }}"
                                                class="px-2 py-1 bg-gray-500 text-white rounded-r hover:bg-gray-600 transition-colors">-</button>
                                        </div>
                                        <button type="submit" formaction="{{ route('order_stage_remove', ['product' => $product->id]) }}"
                                            class="p-1 bg-red-500 text-white rounded hover:bg-red-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m4-6v.01M5 7V5a2 2 0 012-2h10a2 2 0 012 2v2" />
                                            </svg>
                                        </button>
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
    const nameInput = document.getElementById('name');

    const names = [
        <?php

        use App\Models\Order;

        foreach (Order::uniqueClientNames() as $client) : ?> {
                name: '<?= $client->client_name ?>',
                phone: '<?= $client->client_phone ?>',
                address: '<?= $client->address ?>'
            },
        <?php endforeach; ?>
    ];

    const choicesList = document.getElementById('choices');
    const phoneInput = document.getElementById('tel');

    const clearNameBtn = document.getElementById('clearName');
    clearNameBtn.addEventListener('click', function() {
        nameInput.value = '';
        phoneInput.value = '';
        this.classList.add('hidden');
        choicesList.innerHTML = '';
    });

    nameInput.addEventListener('input', function() {
        choicesList.innerHTML = '';
        if (this.value.length === 0) return;

        const clearName = document.getElementById('clearName');
        if (this.value.length > 0) {
            clearName.classList.remove('hidden');
        } else {
            clearName.classList.add('hidden');
        }

        const matchingNames = names.filter(person =>
            person.name.toLowerCase().includes(this.value.toLowerCase())
        );

        matchingNames.forEach(person => {
            const li = document.createElement('li');
            li.textContent = person.name;
            li.className = 'p-2.5 hover:bg-blue-50 cursor-pointer border-b border-gray-100 text-gray-700 text-sm transition-colors duration-150';
            li.addEventListener('click', () => {
                nameInput.value = person.name;
                phoneInput.value = person.phone;

                choicesList.innerHTML = '';
            });
            choicesList.appendChild(li);
        });
    });
</script>
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