<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouse::all();

        return view('warehouse.warehouse-management')->with('warehouses', $warehouses);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('warehouse.warehouse-add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',  
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:16000'],
            'description' => ['nullable'],
        ]);

        $name = sha1(random_int(0, 99999999)) . '.' . $request->file('image')->extension();
        $request->file('image')->storePubliclyAs(path: 'public/warehouse/images', name: $name);

        $validated['image_link'] = $name;

        Warehouse::query()->create($validated);

        return redirect()->route('warehouse')->with('message', 'Warehouse Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warehouse $warehouse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Warehouse $warehouse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        //
    }
}
