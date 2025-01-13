@extends('layouts.app')

@section('content')
<div>
    <img src="{{ asset('assets/gradient.jpg') }}" class="absolute left-0 z-[-1] top-0 w-full h-screen opacity-20 object-cover" alt="Background">
    <h1 class="text-3xl font-bold">Analytics & Reports</h1>

    <div class="my-12"></div>

    <div class="flex flex-col items-center">
        <h1 class="text-3xl text-gray-700 font-bold mb-12 ">Report Generation</h1>

        <div class="my-5"></div>

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

        <div class="w-full flex justify-between mb-32">
            <div class="flex flex-col gap-8 min-w-72">
                <div class="flex bg-white/80 p-4 rounded font-semibold group justify-between gap-6 shadow hover:scale-105 transition-transform">
                    @php($distributors = App\Models\IncomingDelivery::distributors())
                    <p>Total Suppliers</p>
                    <p class="font-bold group-hover:scale-150 transition-transform">{{ count($distributors) }}</p>
                </div>

                <div class="flex bg-white/80 p-4 group rounded font-semibold justify-between gap-6 shadow hover:scale-105 transition-transform">
                    @php($transactionToday = App\Models\Order::whereDate('created_at', today()))
                    <p>Total Customers Today</p>
                    <p class="font-bold group-hover:scale-150 transition-transform">{{ $transactionToday->count() }}</p>
                </div>

                <div class="flex bg-white/80 p-4 rounded font-semibold group justify-between gap-6 shadow hover:scale-105 transition-transform">
                    @php($products = App\Models\Product::all())
                    <p>Products</p>
                    <p class="font-bold group-hover:scale-150 transition-transform">{{ count($products) }}</p>
                </div>
            </div>

            <div class="flex flex-col gap-8 min-w-72">
                <div class="flex bg-white/80 p-4 items-center rounded font-semibold group justify-between gap-6 shadow hover:scale-105 transition-transform">
                    <?php

                    $total = 0;

                    foreach ($transactionToday->get() as $transaction)
                        $total += $transaction->getTotal();
                    ?>
                    <p>Sales Today</p>
                    <p class="font-semibold text-sm group-hover:scale-110 transition-transform">{{ number_format($total, 2) }} PHP</p>
                </div>

                <div class="flex bg-white/80 p-4 rounded font-semibold group justify-between gap-6 shadow hover:scale-105 transition-transform">
                    @php($incomingGoods = App\Models\IncomingDelivery::whereDate('delivery', today())->get())
                    <p>Incoming Goods Today</p>
                    <p class="font-bold group-hover:scale-150 transition-transform">{{ count($incomingGoods) }}</p>
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

        <table class="min-w-full bg-white/60 rounded-lg shadow-lg mt-8 mb-24">
            <thead>
                <tr>
                    <th class="py-2">ID</th>
                    <th class="py-2">Supplier</th>
                    <th class="py-2">Product</th>
                    <th class="py-2">Quantity</th>
                    <th class="py-2">Delivery Date</th>
                </tr>
            </thead>
            <tbody>
                @php($incomingDeliveries = App\Models\IncomingDelivery::all())
                @foreach($incomingDeliveries as $delivery)
                <tr>
                    <td class="border px-4 py-2">{{ $delivery->id }}</td>
                    <td class="border px-4 py-2">{{ $delivery->distributor->name }}</td>
                    <td class="border px-4 py-2">{{ $delivery->product->name }}</td>
                    <td class="border px-4 py-2">{{ $delivery->quantity }}</td>
                    <td class="border px-4 py-2">{{ $delivery->delivery }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
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