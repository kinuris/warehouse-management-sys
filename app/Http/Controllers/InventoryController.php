<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('inventory.inventory-management')->with('products', $products);
    }

    public function create()
    {
        return view('inventory.inventory-add');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:products'],
            'price' => ['required'],
            'stock_qty' => ['required']
        ]);

        Product::create($validated);

        return redirect('/inventory')->with('message', 'Inventory item added successfully!');
    }
}
