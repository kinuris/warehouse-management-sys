@extends('layouts.app')

@section('content')
<div class="px-5" style="position: relative;">

    <img src="{{ asset('assets/gradient.jpg') }}" style="position: absolute; left: 0; z-index: -1; top: -24px; width: 100%; height: calc(100vh - 58px); opacity: 0.2; object-fit: cover;" alt="Background">
    <h1>Analytics & Reports</h1>
    <form action="">
        <div class="d-flex mt-4" style="place-items: center;"> 
            <button class="btn btn-primary">Generate Report</button>
            <p class="m-0 ms-2 me-1">From: </p>
            <input class="form-control" style="max-width: fit-content;" type="date" name="start" id="start">
            <p class="m-0 ms-2 me-1">To: </p>
            <input class="form-control" style="max-width: fit-content;" type="date" name="end" id="start">
        </div>
    </form>
    <div class="d-flex justify-content-evenly mt-4">
        <canvas style="max-width: calc(50vw - 48px); max-height: calc(33vw - 48px); min-width: calc(50vw - 48px); min-height: calc(33vw - 48px);" id="week"></canvas>
        <canvas style="max-width: calc(50vw - 48px); max-height: calc(33vw - 48px); min-width: calc(50vw - 48px); min-height: calc(33vw - 48px);" id="product"></canvas>
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