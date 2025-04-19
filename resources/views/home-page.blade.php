@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Analytics Dashboard</h1>

    <!-- Key Metrics Overview -->
    <div class="mb-10">
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
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg border-l-4 border-blue-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase mb-2">Total Goods Sold</h3>
                <p class="text-3xl font-bold text-gray-800">{{ number_format($goodsSold, 0) }}</p>
                <div class="mt-2 text-sm text-gray-500">All time sales volume</div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg border-l-4 border-green-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase mb-2">Net Revenue</h3>
                <p class="text-3xl font-bold text-gray-800">₱{{ number_format($netRevenue, 2) }}</p>
                <div class="mt-2 text-sm text-gray-500">Total revenue generated</div>
            </div>
            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg border-l-4 border-purple-500">
                <h3 class="text-gray-500 text-sm font-semibold uppercase mb-2">Net Profit</h3>
                <p class="text-3xl font-bold text-gray-800">₱{{ number_format($netProfit, 2) }}</p>
                <div class="mt-2 text-sm text-gray-500">Total profit earned</div>
            </div>
        </div>
    </div>

    <!-- Reports Section -->
    <!-- Reports & Analytics Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-semibold text-gray-700 mb-6">Reports & Analytics</h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Sales Performance Report Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Sales Performance Report</h3>
                            <p class="text-sm text-gray-600">Generate detailed sales reports for specific date ranges, analyzing revenue, profit, and top products.</p>
                        </div>
                    </div>

                    <form class="mt-6 space-y-4" action="{{ route('report.generate') }}" method="GET">
                        @csrf {{-- Optional: Include CSRF for potential future method changes --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="sales_start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <input type="date" id="sales_start_date" name="start" class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                            </div>
                            <div>
                                <label for="sales_end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                                <input type="date" id="sales_end_date" name="end" class="w-full px-3 py-2 rounded-md border border-gray-300 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition duration-150 ease-in-out">
                            </div>
                        </div>
                        <div class="flex justify-end pt-2">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-800 focus:outline-none focus:border-indigo-800 focus:ring focus:ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Generate Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Inventory Status Report Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200 hover:shadow-xl transition-shadow duration-300">
                <div class="p-6 flex flex-col h-full">
                    <div class="flex items-start mb-4">
                        <div class="flex-shrink-0 p-3 rounded-full bg-teal-100 text-teal-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-1">Inventory Status Report</h3>
                            <p class="text-sm text-gray-600">Access comprehensive inventory data including stock levels, valuation, low stock alerts, and category breakdowns.</p>
                        </div>
                    </div>

                    <div class="flex-1"></div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
                         <a href="{{ route('reports.inventory') }}" class="inline-flex items-center justify-center px-4 py-2 bg-teal-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-teal-700 active:bg-teal-800 focus:outline-none focus:border-teal-800 focus:ring focus:ring-teal-300 disabled:opacity-25 transition ease-in-out duration-150">
                            View Full Report
                        </a>
                         <a href="{{ route('reports.inventory') }}?low_stock=1" class="inline-flex items-center justify-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 active:bg-orange-800 focus:outline-none focus:border-orange-800 focus:ring focus:ring-orange-300 disabled:opacity-25 transition ease-in-out duration-150">
                            View Low Stock
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Weekly Performance Chart -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Weekly Performance</h2>
        <div class="h-[400px]">
            <canvas id="week"></canvas>
        </div>
    </div>

    <!-- Business Summary Section -->
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Business Summary</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
        <!-- Left Column -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($distributors = App\Models\IncomingDelivery::distributors())
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Total Suppliers</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ count($distributors) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Active distribution partners</p>
                    </div>
                    <div class="p-4 bg-blue-100 rounded-full">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($transactionToday = App\Models\Order::whereDate('created_at', today()))
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Customers Today</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ $transactionToday->count() }}</p>
                        <p class="text-sm text-gray-500 mt-1">Transactions processed today</p>
                    </div>
                    <div class="p-4 bg-green-100 rounded-full">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($products = App\Models\Product::all())
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Total Products</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ count($products) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Items in your inventory</p>
                    </div>
                    <div class="p-4 bg-purple-100 rounded-full">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                <?php
                $total = 0;
                foreach ($transactionToday->get() as $transaction)
                    $total += $transaction->getTotal();
                ?>
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Today's Revenue</h3>
                        <p class="text-3xl font-bold text-gray-800">₱{{ number_format($total, 2) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Revenue generated today</p>
                    </div>
                    <div class="p-4 bg-yellow-100 rounded-full">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6 transition-all duration-300 hover:shadow-lg">
                @php($incomingGoods = App\Models\IncomingDelivery::whereDate('delivery', today())->get())
                <div class="flex justify-between items-center">
                    <div>
                        <h3 class="text-gray-500 text-sm font-semibold uppercase mb-1">Incoming Deliveries</h3>
                        <p class="text-3xl font-bold text-gray-800">{{ count($incomingGoods) }}</p>
                        <p class="text-sm text-gray-500 mt-1">Expected arrivals today</p>
                    </div>
                    <div class="p-4 bg-red-100 rounded-full">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Sales Chart -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Product Sales Distribution</h2>
        <div class="max-w-3xl mx-auto h-[400px]">
            <canvas id="product"></canvas>
        </div>
    </div>

    <!-- Incoming Orders Table -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-12">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Upcoming Deliveries</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Supplier</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="px-6 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php($incomingDeliveries = App\Models\IncomingDelivery::orderBy('delivery', 'asc')->get())
                    @foreach($incomingDeliveries as $delivery)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $delivery->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $delivery->distributor->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $delivery->product->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $delivery->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ date('M d, Y', strtotime($delivery->delivery)) }}</td>
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
    // Chart configuration with improved styling
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
                label: 'Revenue',
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
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }, {
                label: 'Profit',
                data: [
                    <?php
                    echo Order::profit($records[0]) . ',';
                    echo "\n";
                    foreach (array_slice($records, 1) as $record) {
                        echo Order::profit($record) . ',';
                        echo "\n";
                    }
                    ?>
                ],
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }, {
                label: 'Taxes',
                data: [
                    <?php
                    echo number_format(Order::profit($records[0]) * 0.12, 2) . ',';
                    echo "\n";
                    foreach (array_slice($records, 1) as $record) {
                        echo number_format(Order::profit($record) * 0.12, 2) . ',';
                        echo "\n";
                    }
                    ?>
                ],
                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                borderColor: 'rgba(255, 159, 64, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ₱' + context.raw.toLocaleString();
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '₱' + value.toLocaleString();
                        }
                    }
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
        type: 'doughnut',
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
                        echo "'#e5e7eb'";
                    }
                    foreach ($colors as $color) {
                        echo "'" . $color . "'" . ',';
                    }
                    ?>
                ],
                borderColor: '#ffffff',
                borderWidth: 2,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        padding: 20,
                        boxWidth: 12
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.raw || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = Math.round((value / total) * 100);
                            return label + ': ' + value + ' units (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection