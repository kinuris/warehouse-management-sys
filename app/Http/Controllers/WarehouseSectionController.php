<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\WarehouseSection;
use App\Models\WareHouseSectionProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'products' => ['nullable', 'array', 'min:0'],
        ]);

        $name = sha1(random_int(0, 99999999)) . '.' . $request->file('image')->extension();
        $request->file('image')->storePubliclyAs(path: 'public/section/images', name: $name);

        $validated['image_link'] = $name;

        $section = WarehouseSection::query()->create($validated);

        foreach ($validated['products'] ?? [] as $product) {
            WareHouseSectionProduct::query()->create([
                'warehouse_section_id' => $section->id,
                'product_id' => $product,
            ]);
        }

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

    public function delete(Warehouse $warehouse, WarehouseSection $warehouseSection)
    {
        return view('warehouse.warehouse-section-delete')
            ->with('section', $warehouseSection)
            ->with('warehouse', $warehouse);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse, WarehouseSection $warehouseSection)
    {
        Storage::delete('public/section/images/' . $warehouseSection->image_link);

        $sectionProducts = WareHouseSectionProduct::query()
            ->where('warehouse_section_id', '=', $warehouseSection->id)
            ->get();

        foreach ($sectionProducts as $sectionProduct) {
            $sectionProduct->delete();
        }

        $warehouseSection->delete();

        return redirect()->route('warehouse_section', ['warehouse' => $warehouse->id])->with('message', 'Section Deleted Successfully');
    }

    public function itemSections(Product $product)
    {
        $sectionProducts = WareHouseSectionProduct::query()
            ->where('product_id', '=', $product->id)
            ->get();

        return view('warehouse.item-sections')
            ->with('sections', $sectionProducts)
            ->with('item', $product);
    }
}
