@extends('layouts.app')

@section('content')
<div class="container">
    <img src="{{ asset('assets/gradient.jpg') }}" class="fixed left-0 top-0 w-full h-screen opacity-20 object-cover -z-10" alt="Background">
    
    <div class="flex gap-3 mb-4">
        <a class="px-4 py-2 bg-gray-500 hover:bg-gray-600 rounded text-white transition-colors" href="{{ route('orders') }}">Back</a>
        @php ($tw = Vite::asset('resources/css/app.css'))
        <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 rounded text-white transition-colors flex items-center gap-2" onclick="printJS({ printable: 'receipt', type: 'html', css: '{{ $tw }}' })">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Print Receipt
        </button>
    </div>

    <div id="receipt" class="p-6 mt-4 border rounded-lg bg-white min-w-[700px] max-w-[700px] shadow-sm">
        <div class="border-b pb-4">
            <div class="flex items-center mb-3">
                <img class="mr-4 w-12 h-12 rounded-full" src="{{ asset('assets/logo.jpg') }}" alt="">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Delivery Receipt</h1>
                    <p class="text-gray-600">Brgy. Pob. Tabuc, Maayon, Capiz</p>
                    <p class="text-gray-600">Date: {{ date('Y-m-d') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <div class="flex gap-2">
                        <span class="text-gray-600">Charged To:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-gray-600">Business Style:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-gray-600">Address:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-gray-600">TIN:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                </div>
                <div class="space-y-2">
                    <div class="flex gap-2">
                        <span class="text-gray-600">Terms:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-gray-600">SC/PWD ID No.:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                    <div class="flex gap-2">
                        <span class="text-gray-600">SC/PWD Signature:</span>
                        <span class="border-b border-gray-300 flex-1"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <table class="w-full">
                <thead class="text-left border-b-2 border-gray-200">
                    <tr>
                        <th class="py-2 text-gray-600">Item</th>
                        <th class="py-2 text-gray-600">Price</th>
                        <th class="py-2 text-gray-600">Quantity</th>
                        <th class="py-2 text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                       <tr>
                            <td class="py-2 text-gray-900"><span class="text-gray-500">#{{ $order->product->internal_id }}</span> {{ $order->product->shrtName() }}</td>
                            <td class="py-2 text-gray-900">{{ $order->product->price }} PHP</td>
                            <td class="py-2 text-gray-900">x{{ $order->quantity }}</td>
                            <td class="py-2 text-gray-900">{{ $order->product->price * $order->quantity }} PHP</td>
                       </tr> 
                    @endforeach 
                </tbody>
            </table>

            <div class="mt-6 border-t-2 border-gray-200 pt-4">
                <div class="ml-auto space-y-3">
                    <div class="flex justify-between items-center text-sm">
                        <span class="text-gray-600">Subtotal:</span>
                        <span class="text-gray-900 font-medium">{{ number_format($orders->sum(fn($order) => $order->product->price * $order->quantity), 2) }} PHP</span>
                    </div>
                    <div class="flex justify-end gap-2 items-center mt-2 text-sm">
                        <span class="text-gray-600">Total (VAT Inclusive):</span>
                        <span class="border-b border-gray-300 w-32 h-5"></span>
                    </div>
                    <div class="flex justify-end gap-2 items-center text-sm">
                        <span class="text-gray-600">Less: VAT:</span>
                        <span class="border-b border-gray-300 w-32 h-5"></span>
                    </div>
                    <div class="flex justify-end gap-2 items-center text-sm">
                        <span class="text-gray-600">Amount: Net of VAT:</span>
                        <span class="border-b border-gray-300 w-32 h-5"></span>
                    </div>
                    <div class="flex justify-end gap-2 items-center pt-3 text-sm">
                        <span class="text-gray-900 font-semibold">Amount Due:</span>
                        <span class="border-b border-gray-300 w-32 h-5"></span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between mt-8">
                <div>
                    <p class="font-semibold">Received by:</p>
                    <div class="mt-4 border-t border-gray-400 w-48">
                        <p class="text-center mt-2">Signature over printed name</p>
                    </div>
                </div>
                <div>
                    <p class="font-semibold">Delivered by:</p>
                    <div class="mt-4 border-t border-gray-400 w-48">
                        <p class="text-center mt-2">Signature over printed name</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection