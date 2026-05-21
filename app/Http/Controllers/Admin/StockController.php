<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStockRequest;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $searchTerm = $request->search;
        $categorySlug = $request->category;
        $statusFilter = $request->status;

        // Metrics queries
        $totalItems = Product::count();
        $outOfStock = Product::where('stock_quantity', 0)->count();
        $lowStock = Product::whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                            ->where('stock_quantity', '>', 0)
                            ->count();

        // Main table query
        $query = Product::with('category')->latest();

        if (!empty($searchTerm)) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        if (!empty($categorySlug)) {
            $query->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if (!empty($statusFilter)) {
            if ($statusFilter === 'out_of_stock') {
                $query->where('stock_quantity', 0);
            } elseif ($statusFilter === 'low_stock') {
                $query->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                      ->where('stock_quantity', '>', 0);
            } elseif ($statusFilter === 'in_stock') {
                $query->whereColumn('stock_quantity', '>', 'low_stock_threshold');
            }
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        return view('admin.stock.index', compact('products', 'categories', 'totalItems', 'outOfStock', 'lowStock'));
    }

    public function update(UpdateStockRequest $request, Product $product)
    {
        $product->update($request->validated());

        return back()->with('success', "Stock for {$product->name} successfully updated!");
    }
}
