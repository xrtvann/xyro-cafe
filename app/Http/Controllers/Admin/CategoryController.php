<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('admin.category.index', compact('categories'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->search;
        $statusFilter = $request->status;
        
        $query = Category::withCount('products')->latest();
        
        if (!empty($searchTerm)) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('slug', 'like', "%{$searchTerm}%");
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

        $categories = $query->paginate(10)->withQueryString();

        return view('admin.category.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        $validated = $request->validated();
        
        $validated['id'] = Str::uuid()->toString();
        $validated['slug'] = Str::slug($validated['name']) . '-' . substr($validated['id'], 0, 8);
        $validated['is_active'] = $request->has('is_active');

        Category::create($validated);

        return redirect()->route('admin.category.index')->with('success', 'Category successfully added!');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $validated = $request->validated();
        
        $validated['slug'] = Str::slug($validated['name']) . '-' . substr($category->id, 0, 8);
        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.category.index')->with('success', 'Category successfully updated!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Category cannot be deleted because it is still used by products.');
        }

        $category->delete();
        return back()->with('success', 'Category successfully moved to trash!');
    }

    public function restore($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->firstOrFail();
        $category->restore();
        return back()->with('success', 'Category successfully restored!');
    }

    public function forceDelete($slug)
    {
        $category = Category::withTrashed()->where('slug', $slug)->firstOrFail();

        if ($category->products()->count() > 0) {
            return back()->with('error', 'Category cannot be permanently deleted because it is still used by products.');
        }
        
        $category->forceDelete();
        
        return back()->with('success', 'Category permanently deleted!');
    }
}
