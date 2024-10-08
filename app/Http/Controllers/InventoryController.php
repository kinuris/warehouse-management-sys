<?php

namespace App\Http\Controllers;

use App\Models\ItemOverhead;
use App\Models\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        if (!$search) {
            $products = Product::all();
        } else {
            $products = Product::where('name', 'like', '%' . $search . '%')->get();
        }

        return view('inventory.inventory-management')->with('products', $products);
    }

    public function create()
    {
        return view('inventory.inventory-add');
    }

    public function edit(Product $inventory)
    {
        return view('inventory.inventory-edit')->with('inventory', $inventory);
    }

    public function update(Request $request, Product $inventory)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'base' => ['required'],
            'profit' => ['required'],
            'stock_qty' => ['required']
        ]);

        $inventory->update($validated);

        $validated['profit'] = (int) $validated['profit'] - (int) $validated['base'];
        $inventory->overhead->update($validated);

        return redirect()->route('inventory')->with('message', 'Inventory item updated successfully!');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'unique:products'],
            'base' => ['required'],
            'profit' => ['required'],
            'stock_qty' => ['required'],
            'category' => ['required']
        ]);

        $validated['category_id'] = $validated['category'];

        $item = Product::create($validated);
        ItemOverhead::query()->create([
            'product_id' => $item->id,
            'base' => $validated['base'],
            'profit' => (int) $validated['profit'] - (int) $validated['base'],
        ]);

        return redirect('/inventory')->with('message', 'Inventory item added successfully!');
    }

    public function delete(Product $inventory)
    {
        return view('inventory.inventory-delete')->with('inventory', $inventory);
    }

    public function destroy(Product $inventory)
    {
        $inventory->update(['is_suspended' => !$inventory->is_suspended]);

        return redirect()->route('inventory')->with('message', 'Inventory item suspended successfully!');
    }
}
