<?php

namespace App\Http\Controllers;

use App\Models\IncomingDelivery;
use App\Models\IncomingDeliveryCancel;
use App\Models\IncomingDeliverySuccess;
use Illuminate\Http\Request;

class IncomingDeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('incoming.incoming-delivery-management');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('incoming.incoming-delivery-add');
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'distributor' => ['required'],
            'product' => ['required'],
            'quantity' => ['required'],
            'delivery' => ['required', 'date', 'after:now'],
        ]);

        $validated['product_id'] = $validated['product'];

        IncomingDelivery::create($validated);

        return redirect()->route('incoming')->with('message', 'Incoming Delivery Scheduled Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(IncomingDelivery $incomingDelivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(IncomingDelivery $incomingDelivery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, IncomingDelivery $incomingDelivery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncomingDelivery $incomingDelivery)
    {
        //
    }

    public function success(IncomingDelivery $delivery)
    {
        if ($delivery->status() !== 'pending') {
            return redirect()->route('incoming')->with('message', 'Delivery Already Delivered or Canceled');
        }

        $delivery->product->update([
            'quantity' => $delivery->product->quantity + $delivery->quantity
        ]);

        IncomingDeliverySuccess::query()->create([
            'incoming_delivery_id' => $delivery->id
        ]);

        return redirect()->route('incoming')->with('message', 'Incoming Delivery Delivered Successfully');
    }

    public function cancel(IncomingDelivery $delivery)
    {
        if ($delivery->status() !== 'pending') {
            return redirect()->route('incoming')->with('message', 'Delivery Already Delivered or Canceled');
        }

        IncomingDeliveryCancel::query()->create([
            'incoming_delivery_id' => $delivery->id
        ]);

        return redirect()->route('incoming')->with('message', 'Incoming Delivery Canceled Successfully');
    }
}
