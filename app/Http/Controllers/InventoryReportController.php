<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function index(Request $request)
    {
        // Get category filter if provided
        $categoryFilter = $request->query('category');
        $lowStockOnly = $request->query('low_stock');
        
        // Start with a base query
        $productsQuery = Product::with(['category', 'overhead']);
        
        // Apply category filter if selected
        if ($categoryFilter && $categoryFilter != 'all') {
            $productsQuery->where('category_id', $categoryFilter);
        }
        
        // Apply low stock filter if requested
        if ($lowStockOnly) {
            $productsQuery->where('stock_qty', '<', 10);
        }
        
        // Get all products with their relationships
        $products = $productsQuery->get();
        
        // Get all categories for the filter dropdown
        $categories = Category::orderBy('name')->get();
        
        // Calculate total inventory value
        $totalValue = $products->sum(function ($product) {
            return $product->stock_qty * ($product->overhead->base + $product->overhead->profit);
        });
        
        // Calculate total stock quantity
        $totalStock = $products->sum('stock_qty');
        
        // Calculate average price per item
        $avgPrice = $products->count() > 0 ? 
            $products->sum(function ($product) {
                return $product->overhead->base + $product->overhead->profit;
            }) / $products->count() : 0;
        
        // Get low stock items (less than 10 items)
        $lowStockItems = $products->filter(function ($product) {
            return $product->stock_qty < 10;
        });
        
        // Get out of stock items
        $outOfStockItems = $products->filter(function ($product) {
            return $product->stock_qty == 0;
        });
        
        // Get category-wise summary
        $categorySummary = $products->groupBy('category.name')
            ->map(function ($groupedProducts, $category) {
                return [
                    'name' => $category,
                    'count' => $groupedProducts->count(),
                    'value' => $groupedProducts->sum(function ($product) {
                        return $product->stock_qty * ($product->overhead->base + $product->overhead->profit);
                    }),
                    'stock' => $groupedProducts->sum('stock_qty')
                ];
            });
        
        return view('reports.inventory', compact(
            'products', 
            'categories',
            'categoryFilter',
            'lowStockOnly',
            'totalValue', 
            'totalStock', 
            'avgPrice',
            'lowStockItems',
            'outOfStockItems',
            'categorySummary'
        ));
    }
}