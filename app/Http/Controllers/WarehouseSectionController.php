<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use App\Models\WarehouseSection;
use Illuminate\Http\Request;

class WarehouseSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Warehouse $warehouse)
    {
        $sections = WarehouseSection::query()->where('warehouse_id', $warehouse->id)->get();
        
        return view('warehouse.warehouse-section')
            ->with('warehouse', $warehouse)
            ->with('sections', $sections);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Warehouse $warehouse)
    {
        return view('warehouse.warehouse-section-add')->with('warehouse', $warehouse);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'warehouse_id' => 'required',
            'description' => 'required',
            'image' => ['required', 'image', 'mimes:png,jpg', 'max:16000'],
        ]);

        $name = sha1(random_int(0, 99999999)) . '.' . $request->file('image')->extension();
        $request->file('image')->storePubliclyAs(path: 'public/section/images', name: $name);

        $validated['image_link'] = $name;

        WarehouseSection::query()->create($validated);

        return redirect()->route('warehouse_section', ['warehouse' => $warehouse->id])->with('message', 'Section Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(WarehouseSection $warehouseSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WarehouseSection $warehouseSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WarehouseSection $warehouseSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WarehouseSection $warehouseSection)
    {
        //
    }
}
