@extends('layouts.app')

@section('content')
<div>
    <h1 class="text-3xl font-bold">Analytics & Reports</h1>

    <div class="my-12"></div>

    <div class="flex flex-col items-center">
        <h1 class="text-3xl text-gray-700 font-bold mb-12 ">Report Generation</h1>

        <div class="my-5"></div>
        <div class="mb-6 w-full">
            <?php
            $orders = App\Models\Order::all();

            $goodsSold = 0;
            $netRevenue = 0;
            $netProfit = 0;

            foreach ($orders as $order) {
                foreach ($order->getItemsAndQuantity() as [$id, $qty]) {
                    $goodsSold += $qty;
                    $netRevenue += $order->getTotal();
                    $netProfit += $order->getProfit();
                }
            }
            ?>
            <div class="flex justify-between w-full p-6 bg-white/80 rounded-lg shadow-lg">
                <div class="flex flex-col items-center p-4 border-r border-gray-200">
                    <h3 class="text-gray-500 text-sm uppercase mb-2">Total Goods Sold</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($goodsSold, 0) }}</p>
                </div>
                <div class="flex flex-col items-center p-4 border-r border-gray-200">
                    <h3 class="text-gray-500 text-sm uppercase mb-2">Net Revenue</h3>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($netRevenue, 2) }}</p>
                </div>
                <div class="flex flex-col items-center p-4">
                    <h3 class="text-gray-500 text-sm uppercase mb-2">Net Profit</h3>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($netProfit, 2) }}</p>
                </div>
            </div>
        </div>

        <form class="w-full" action="{{ route('report.generate') }}">
            <div class="flex mt-4 items-center">
                <button class="p-2 bg-blue-500 text-white rounded">Generate Report</button>
                <p class="ml-2 mr-1">From: </p>
                <input class="border p-1 rounded" type="date" name="start" id="start">
                <p class="ml-2 mr-1">To: </p>
                <input class="border p-1 rounded" type="date" name="end" id="start">
            </div>
        </form>

        <div class="my-2"></div>

        <canvas class="w-screen h-screen" id="week"></canvas>

        <div class="my-16"></div>

        <hr class="self-stretch border-gray-400">
        <h1 class="text-3xl text-gray-700 font-bold mt-6">Summary</h1>
        <div class="w-full grid grid-cols-2 gap-8 mb-32 px-4">
            <!-- Left Column -->
            <div class="space-y-6">
            <div class="bg-white/90 rounded-lg shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($distributors = App\Models\IncomingDelivery::distributors())
                <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm uppercase mb-1">Total Suppliers</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ count($distributors) }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                </div>
            </div>

            <div class="bg-white/90 rounded-lg shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($transactionToday = App\Models\Order::whereDate('created_at', today()))
                <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm uppercase mb-1">Customers Today</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ $transactionToday->count() }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                </div>
            </div>

            <div class="bg-white/90 rounded-lg shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($products = App\Models\Product::all())
                <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm uppercase mb-1">Total Products</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ count($products) }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                </div>
                </div>
            </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
            <div class="bg-white/90 rounded-lg shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                <?php
                $total = 0;
                foreach ($transactionToday->get() as $transaction)
                $total += $transaction->getTotal();
                ?>
                <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm uppercase mb-1">Today's Revenue</h3>
                    <p class="text-2xl font-bold text-gray-800">₱{{ number_format($total, 2) }}</p>
                </div>
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                </div>
            </div>

            <div class="bg-white/90 rounded-lg shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($incomingGoods = App\Models\IncomingDelivery::whereDate('delivery', today())->get())
                <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-gray-600 text-sm uppercase mb-1">Incoming Deliveries</h3>
                    <p class="text-2xl font-bold text-gray-800">{{ count($incomingGoods) }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                </div>
                </div>
            </div>
            </div>
        </div>

        <hr class="self-stretch border-gray-400">
        <h1 class="text-3xl text-gray-700 font-bold mt-6">Sales Chart</h1>

        <div class="my-5"></div>

        <canvas class="max-w-[50vw] max-h-[460px]" id="product"></canvas>

        <div class="my-16"></div>

        <hr class="self-stretch border-gray-400">
        <h1 class="text-3xl text-gray-700 font-bold mt-6">Incoming Orders</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white/90 rounded-xl shadow-xl mt-8 mb-24">
            <thead class="bg-gray-100">
                <tr>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Supplier</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Product</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Delivery Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @php($incomingDeliveries = App\Models\IncomingDelivery::orderBy('delivery', 'asc')->get())
                @foreach($incomingDeliveries as $delivery)
                <tr class="hover:bg-gray-50 transition-colors duration-200">
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $delivery->id }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $delivery->distributor->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $delivery->product->name }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $delivery->quantity }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ date('M d, Y', strtotime($delivery->delivery)) }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const weekChart = document.getElementById('week');
    const productChart = document.getElementById('product');

    new Chart(weekChart, {
        type: 'bar',
        data: {
            labels: [
                'Today',
                <?php

                use App\Models\Order;
                use App\Models\Product;

                $offset = 1;
                foreach (array_slice($records, 1) as $record) {
                    if ($offset === 1) {
                        echo "'" . $offset . " day ago'" . ',';
                    } else {
                        echo "'" . $offset . " days ago'" . ',';
                    }

                    echo "\n";

                    $offset++;
                }
                ?>
            ],
            datasets: [{
                label: 'Revenue in PHP',
                data: [
                    <?php
                    echo Order::total($records[0]) . ',';
                    echo "\n";

                    foreach (array_slice($records, 1) as $record) {
                        echo Order::total($record) . ',';
                        echo "\n";
                    }
                    ?>
                ],
                borderWidth: 1
            }, {
                label: 'Profit in PHP',
                data: [
                    <?php
                    echo Order::profit($records[0]) . ',';
                    echo "\n";

                    foreach (array_slice($records, 1) as $record) {
                        echo Order::profit($record) . ',';
                        echo "\n";
                    }
                    ?>
                ]
            }, {
                label: 'Taxes in PHP',
                data: [
                    <?php
                    echo number_format(Order::profit($records[0]) * 0.12, 2) . ',';
                    echo "\n";

                    foreach (array_slice($records, 1) as $record) {
                        echo number_format(Order::profit($record) * 0.12, 2) . ',';
                        echo "\n";
                    }
                    ?>
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            scales: {
                y: {
                    beginAtZero: true,
                    stacked: true,
                },
                x: {
                    stacked: true,
                }
            }
        }
    });

    <?php
    $orders = $records[0];
    $accum = [];

    foreach ($orders as $order) {
        foreach ($order->getItemsAndQuantity() as [$id, $qty]) {
            if (array_key_exists($id, $accum)) {
                $accum[$id] += $qty;
            } else {
                $accum[$id] = $qty;
            }
        }
    }

    function generatePastelColor()
    {
        $r = rand(127, 255);
        $g = rand(127, 255);
        $b = rand(127, 255);

        return sprintf("#%02x%02x%02x", $r, $g, $b);
    }

    $colors = array();

    foreach ($accum as $id => $qty) {
        array_push($colors, generatePastelColor());
    }
    ?>

    new Chart(productChart, {
        type: 'pie',
        data: {
            labels: [
                <?php
                if (empty($accum)) {
                    echo "'No sales yet'";
                }

                foreach ($accum as $id => $qty) {
                    $product = Product::find($id);

                    echo "'" . $product->name . "'" . ',';
                    echo "\n";
                }
                ?>
            ],
            datasets: [{
                data: [
                    <?php
                    if (empty($accum)) {
                        echo '1';
                    }

                    foreach ($accum as $id => $qty) {
                        echo $qty . ',';
                        echo "\n";
                    }
                    ?>
                ],
                backgroundColor: [
                    <?php
                    if (empty($accum)) {
                        echo "'#333333'";
                    }

                    foreach ($colors as $color) {
                        echo "'" . $color . "'" . ',';
                    }
                    ?>
                ],
                hoverBackgroundColor: [
                    <?php
                    if (empty($accum)) {
                        echo "'#333333'";
                    }

                    foreach ($colors as $color) {
                        echo "'" . $color . "'" . ',';
                    }
                    ?>
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
        }
    });
</script>
@endsection