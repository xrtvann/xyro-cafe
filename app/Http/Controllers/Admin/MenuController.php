<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with('category')->latest()->paginate(10);
        $categories = Category::where('is_active', true)->get();

        return view('admin.menu.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function search(Request $request)
    {
        $searchTerm = $request->search;
        $categorySlug = $request->category;
        $statusFilter = $request->status;
        
        $query = Product::with('category')->latest();
        
        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%");
            });
        }

        if (!empty($categorySlug)) {
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }
        
        if (!empty($statusFilter)) {
            if ($statusFilter === 'trash') {
                $query->onlyTrashed();
            } else {
                $statusVal = $statusFilter === 'active' ? true : false;
                $query->where('is_active', $statusVal);
            }
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', true)->get();

        return view('admin.menu.index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menu.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        
        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }
        unset($validated['image_file']);
        
        $validated['id'] = Str::uuid()->toString();
        $validated['slug'] = Str::slug($validated['name']) . '-' . substr($validated['id'], 0, 8);
        $validated['is_active'] = $request->has('is_active');

        Product::create($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully added!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->get();
        return view('admin.menu.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $validated = $request->validated();

        if ($request->hasFile('image_file')) {
            // Delete old image if it exists in storage
            if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $product->image_url);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image_file')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        } elseif ($request->filled('image_url')) {
            $validated['image_url'] = $request->image_url;
        } else {
            // Preserve the existing image if no new file or URL is provided
            $validated['image_url'] = $product->image_url;
        }

        unset($validated['image_file']);
        
        $validated['slug'] = Str::slug($validated['name']) . '-' . substr($product->id, 0, 8);
        $validated['is_active'] = $request->has('is_active');

        $product->update($validated);

        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully updated!');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully moved to trash!');
    }

    public function restore($slug)
    {
        $product = Product::withTrashed()->where('slug', $slug)->firstOrFail();
        $product->restore();
        return redirect()->route('admin.menu.index')->with('success', 'Menu successfully restored!');
    }

    public function forceDelete($slug)
    {
        $product = Product::withTrashed()->where('slug', $slug)->firstOrFail();

        if ($product->image_url && str_starts_with($product->image_url, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $product->image_url);
            \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
        }
        
        $product->forceDelete();
        
        return redirect()->route('admin.menu.index')->with('success', 'Menu permanently deleted!');
    }
}
