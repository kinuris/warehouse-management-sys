<?php

namespace App\Http\Controllers;

use App\Models\DeliveryRecord;
use App\Models\EmployeeTaskQueue;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::all();

        return view('orders.order-management')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $search = $request->query('search');

        if (!$search) {
            $products = Product::all();
        } else {
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
        }

        $totalPrice = 0;

        if (Session::has('orderStage')) {
            $stage = Session::get('orderStage');

            foreach ($stage as $id => $quantity) {
                $product = Product::find($id);
                $totalPrice += $product['price'] * $quantity;
            }
        }

        return view('orders.order-add')
            ->with('products', $products)
            ->with('totalPrice', $totalPrice);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'phone' => ['required', 'min:11', 'max:11'],
            'address' => ['required'],
            'delivery_time' => ['required', 'date', 'after:now'],
        ]);

        $validated['client_name'] = $validated['name'];
        $validated['client_phone'] = $validated['phone'];

        $stage = Session::get('orderStage');

        if (!$stage || count($stage) == 0) {
            return back()->withInput()->with('message', 'No product added to order');
        }

        $order = Order::query()->create($validated);

        foreach ($stage as $productId => $quantity) {
            $product = Product::find($productId);

            OrderItem::query()->create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            $product->update(['stock_qty' => $product->stock_qty - $quantity]);
        }

        Session::put('orderStage', []);

        return redirect()->route('orders')->with('message', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function itemView(Order $order)
    {
        $orderItems = OrderItem::query()
            ->where('order_id', $order->id)
            ->get();

        $totalPrice = 0;
        $products = array();
        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            $totalPrice += $product->price * $item->quantity;

            array_push($products, $product);
        }

        $zipped = array();

        for ($i = 0; $i < count($products); $i++) {
            array_push($zipped, [$products[$i], $orderItems[$i]->quantity]);
        }

        return view('orders.item-view')
            ->with('order', $order)
            ->with('totalPrice', $totalPrice)
            ->with('orderItems', $zipped);
    }

    public function deliver(Request $request, Order $order)
    {
        if ($order->isDelivered()) {
            return redirect()->route('deliveries')->with('message', 'Order already delivered');
        }

        $validated = $request->validate([
            'proof' => ['required', 'image', 'mimes:jpg,png,jpeg'],
            'delivery_time' => ['required', 'date'],
        ]);

        $filename = sha1(time()) . '.' . $validated['proof']->extension();
        $validated['image_link'] = $filename;
        $validated['order_id'] = $order->id;

        $request->file('proof')->storePubliclyAs('public/delivery/images', $filename);

        DeliveryRecord::query()->create($validated);

        return redirect()->route('deliveries')->with('message', 'Order delivered successfully');
    }

    public function createDelivery(Order $order)
    {
        if ($order->isDelivered()) {
            return redirect()->route('deliveries')->with('message', 'Order already delivered');
        }

        return view('orders.delivery-add')
            ->with('order', $order);
    }

    public function deliveries()
    {
        $pending = Order::notDelivered();

        return view('orders.order-deliveries')
            ->with('pending', $pending);
    }

    public function deliveriesSuccess()
    {
        $success = Order::success();

        return view('orders.order-deliveries-success')
            ->with('success', $success);
    }

    public function deliveryProof(Order $order) {
        if (!$order->isDelivered()) {
            return redirect()->route('deliveries')->with('message', 'Order not delivered');
        }

        $record = DeliveryRecord::query()->where('order_id', $order->id)->first();

        return view('orders.order-delivery-proof')->with('record', $record);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeTaskQueue $employeeTaskQueue)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeTaskQueue $employeeTaskQueue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeTaskQueue $employeeTaskQueue)
    {
        //
    }

    public function stageAdd(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'min:1'],
        ]);

        $stage = Session::get('orderStage');

        if (!$stage) {
            Session::put('orderStage', [$product->id => $validated['quantity']]);

            return back()->withInput();
        }

        if (array_key_exists($product->id, $stage)) {
            $stage[$product->id] += $validated['quantity'];
        } else {
            $stage[$product->id] = $validated['quantity'];
        }

        Session::put('orderStage', $stage);

        return back()->withInput();
    }

    public function stageSub(Request $request, Product $product)
    {
        $validated = $request->validate([
            'quantity' => ['required', 'min:1'],
        ]);

        $stage = Session::get('orderStage');

        if (!$stage) {
            return back()->withInput();
        }

        if (array_key_exists($product->id, $stage)) {
            if ($stage[$product->id] <= $validated['quantity']) {
                unset($stage[$product->id]);
            } else {
                $stage[$product->id] -= $validated['quantity'];
            }
        }

        Session::put('orderStage', $stage);

        return back()->withInput();
    }
}
