@extends('layouts.app')

@section('content')
<div class="container">
    <a class="btn btn-secondary" href="{{ route('orders') }}">Back</a>
    <button class="btn btn-primary" onclick="printJS({ printable: 'receipt', type: 'html', css: 'https\://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' })">Print</button>

    <div id="receipt" class="p-3 mt-4 border d-flex flex-column rounded" style="background-color: #FFE4C4; width: 600px;">
        <div class="d-flex p-3 flex-column rounded" style="background-color: white; width: fit-content; height: fit-content;">
            <div class="d-flex" style="place-items: center;">
                <img class="me-3" style="width: 32px; height: 32px; border-radius: 9999px;" src="{{ asset('assets/logo.jpg') }}" alt="">
                <h1 class="m-0" style="font-size: 24px; font-weight: bold;">SOBIDA</h1>
            </div>

            <p class="m-0 mt-2">Brgy. Pob. Tabuc, Maayon, Capiz</p>
            <p class="m-0">0980-123-4567</p>
        </div>

        <div class="d-flex p-3 flex-column rounded mt-3" style="background-color: white; width: 100%; height: fit-content;">
            <div class="d-flex justify-content-between" style="place-items: center;">
                <p>DATE: {{ $order->created_at->format('M. d, Y H:m') }}</p>
            </div>

            <table>
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

            <p class="m-0 mt-2">TOTAL: {{ $order->getTotal() }} PHP</p>
            <p class="m-0">TAX: {{ $order->getTax() }} PHP</p>
            <p class="m-0" style="font-size: 12px; color: gray;">Sobida WMS {{ $order->isWalkIn() ? '(WALK-IN ORDER)' : '(DELIVERED BY:' }} {{ $order->delivery_time->format('M. d, Y H:m') }})</p>
        </div>


        <div class="d-flex p-3 flex-column rounded mt-3" style="background-color: white; width: 100%; height: fit-content;">
            <h1 class="text-center m-0" style="font-size: 32px; font-weight: bold; text-decoration: underline;">Receiver:</h1>
            <div class="d-flex flex-column mt-3 mx-auto" style="font-size: 16px;">
                <p class="m-0">Name: <span style="text-decoration: underline;">{{ $order->client_name }}</span></p>
                <p class="m-0">Address: <span style="text-decoration: underline;">{{ $order->address }}</span></p>
                <p>Signature: _____________________</p>
            </div>
        </div>
    </div>
</div>
@endsection