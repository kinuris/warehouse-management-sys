@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-secondary" href="{{ route('orders') }}">Back</a>
    <button class="btn btn-primary" onclick="printJS({ printable: 'receipt', type: 'html', css: 'https\://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' })">Print</button>

    <div id="receipt" class="p-3 mt-4 border d-flex flex-column rounded" style="background-color: white; min-width: 700px; max-width: 700px;">
        <div class="d-flex p-3 flex-column rounded" style="background-color: white; width: 100%; height: fit-content;">
            <div class="d-flex" style="place-items: center;">
                <img class="me-3" style="width: 32px; height: 32px; border-radius: 9999px;" src="{{ asset('assets/logo.jpg') }}" alt="">
                <h1 class="m-0" style="font-size: 24px; font-weight: bold;">SOBIDA AGRICULTURAL SUPPLY</h1>
            </div>

            <p class="m-0 mt-2">Brgy. Pob. Tabuc, Maayon, Capiz</p>
            <p class="m-0">NONVAT Reg. TIN-735-903-767-00000</p>

            <div class="d-flex justify-content-between">
                <p class="m-0 mt-1">Sold To: <u>{{ $order->client_name }}</u></p>
                <p>DATE: {{ $order->created_at->format('M. d, Y H:m') }}</p>
            </div>

            <div class="d-flex mt-2">
                <p class="m-0">TIN: </p>
                <p class="m-0" style="flex: 1; border-bottom: 1px solid black;"></p>
                <div class="mx-2"></div>
                <p class="m-0">TERMS: </p>
                <p class="m-0" style="flex: 1; border-bottom: 1px solid black;"></p>
            </div>

            <div class="d-flex mt-1">
                <p class="m-0">Address:</p>
                <p class="m-0 text-center" style="flex: 1; border-bottom: 1px solid black;">{{ $order->address }}</p>
                <div class="mx-2"></div>
                <p class="m-0">OSCA/PWD ID No.: </p>
                <p class="m-0" style="flex: 1; border-bottom: 1px solid black;"></p>
            </div>

            <div class="d-flex mt-1">
                <p class="m-0">Business Style:</p>
                <p class="m-0 text-center" style="flex: 1; border-bottom: 1px solid black;"></p>
                <div class="mx-2"></div>
                <p class="m-0">SC/PWD Signature: </p>
                <p class="m-0" style="flex: 1; border-bottom: 1px solid black;"></p>
            </div>
        </div>

        <div class="d-flex p-3 pt-0 flex-column rounded mt-1" style="background-color: white; width: 100%; height: fit-content;">
            <table class="table-bordered">
                <thead>
                    <th>Item</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </thead>
                <tbody>
                    @foreach($order->getItemsAndQuantity() as [$id, $qty])
                    @php($item = App\Models\Product::find($id))
                    <tr style="border-bottom: 1px solid gray;">
                        <td>({{ $item->internal_id }}) {{ $item->shrtName() }}</td>
                        <td>{{ $item->price }} PHP</td>
                        <td>x{{ $qty }}</td>
                        <td>{{ $item->price * $qty }} PHP</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <p class="m-0 mt-2">SUB TOTAL: {{ $order->getTotal() }} PHP</p>
                    <!-- <p class="m-0">TAX: {{ $order->getTax() }} PHP</p> -->
                    <div class="d-flex">
                        <p class="m-0">LESS:SC/PWD-Discount:<span style="font-family: 'Courier New';">_________________</span></p>
                    </div>
                    <div class="d-flex">
                        <p class="m-0">TOTAL AMOUNT DUE:<span style="font-family: 'Courier New';">_________________</span></p>
                    </div>
                </div>
                <div class="d-flex flex-column mt-5">
                    <p class="mb-0" style="border-bottom: 1px solid black; width: 100%; line-height: 10px; text-align: center;">
                        <span style="font-size: 10px; ">{{ auth()->user()->getFullname() }}</span>
                    </p>
                    <p class="mb-0 mt-1" style="font-size: 10px;">Authorized Representative/Cashier</p>
                </div>
            </div>
            <p class="m-0" style="font-size: 12px; color: gray;">Sobida WMS {{ $order->isWalkIn() ? '(WALK-IN ORDER)' : '(DELIVERED BY:' }} {{ $order->delivery_time->format('M. d, Y H:m') }})</p>
        </div>


        <!-- <div class="d-flex p-3 flex-column rounded mt-3" style="background-color: white; width: 100%; height: fit-content;">
            <h1 class="text-center m-0" style="font-size: 24px; font-weight: bold; text-decoration: underline;">Receiver:</h1>
            <div class="d-flex flex-column mt-3 mx-auto" style="font-size: 16px;">
                <p class="m-0">Name: <span style="text-decoration: underline;">{{ $order->client_name }}</span></p>
                <p class="m-0">Address: <span style="text-decoration: underline;">{{ $order->address }}</span></p>
                <p>Signature: _____________________</p>
            </div>
        </div> -->
    </div>
</div>
@endsection