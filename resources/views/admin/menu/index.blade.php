@extends('layouts.admin')

@section('header_title', 'Menu Catalog')

@section('content')
<!-- Alpine.js component for view toggle -->
<div x-data="{ viewMode: 'table' }" class="pb-10 space-y-6">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Product Catalog</h2>
            <p class="text-white/60 text-sm mt-1">Manage your cafe's menu offerings, prices, and stock.</p>
        </div>
        
        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <!-- View Toggle Tabs -->
            <div class="flex p-1 bg-black/40 border border-white/10 rounded-xl">
                <button @click="viewMode = 'table'" 
                        :class="viewMode === 'table' ? 'bg-white/10 text-white shadow-sm' : 'text-white/50 hover:text-white/80 hover:bg-white/5'"
                        class="flex items-center space-x-2 px-3 py-1.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[18px]">table_rows</span>
                    <span class="hidden sm:inline">List</span>
                </button>
                <button @click="viewMode = 'grid'" 
                        :class="viewMode === 'grid' ? 'bg-white/10 text-white shadow-sm' : 'text-white/50 hover:text-white/80 hover:bg-white/5'"
                        class="flex items-center space-x-2 px-3 py-1.5 rounded-lg text-sm font-medium transition-all">
                    <span class="material-symbols-outlined text-[18px]">grid_view</span>
                    <span class="hidden sm:inline">Grid</span>
                </button>
            </div>

            <!-- Add Menu Button -->
            <a href="{{ route('admin.menu.create') }}" class="flex items-center justify-center space-x-2 px-4 py-2 bg-primary hover:bg-primary/90 text-black text-sm font-bold rounded-xl transition-all shadow-[0_0_15px_rgba(var(--color-primary),0.3)] hover:shadow-[0_0_20px_rgba(var(--color-primary),0.5)] whitespace-nowrap">
                <span class="material-symbols-outlined text-[18px]">add</span>
                <span>Add Menu</span>
            </a>
        </div>
    </div>

    <!-- Search and Filter Bar -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm">
        <form action="{{ route('admin.menu.search') }}" method="GET" class="flex flex-col sm:flex-row gap-4" 
              x-data
              @submit="
                  Array.from($el.elements).forEach(el => {
                      if (el.name && !el.value) {
                          el.disabled = true;
                      }
                  });
              ">
            <!-- Search -->
            <div class="flex-1 relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px]">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products..." class="w-full bg-black/40 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-white/40 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" @input.debounce.300ms="$el.form.requestSubmit()">
            </div>
            
            <!-- Category Filter -->
            <div class="sm:w-48">
                <select name="category" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none" @change="$el.form.requestSubmit()">
                    <option value="" class="text-black">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->slug }}" class="text-black" {{ request('category') == $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <!-- Status Filter -->
            <div class="sm:w-40">
                <select name="status" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none" @change="$el.form.requestSubmit()">
                    <option value="" class="text-black">All Status</option>
                    <option value="active" class="text-black" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" class="text-black" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>
            
            <!-- Reset Button -->
            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.menu.index') }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-white text-sm font-medium flex items-center justify-center transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Alert for success messages -->
    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-400/10 border border-emerald-400/20 flex items-start">
            <span class="material-symbols-outlined text-emerald-400 mr-3 text-[20px]">check_circle</span>
            <p class="text-sm font-medium text-emerald-400">{{ session('success') }}</p>
        </div>
    @endif

    <!-- TABLE VIEW -->
    <div x-show="viewMode === 'table'" style="display: none;" class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm relative">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-50 pointer-events-none"></div>
        <div class="relative z-10 overflow-auto max-h-[64vh] custom-scrollbar">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="sticky top-0 z-20 bg-black/80 backdrop-blur-md">
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-white">{{ $products->firstItem() + $loop->index }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-white/10 flex-shrink-0 border border-white/5">
                                        @if($product->image_url)
                                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-white/30">
                                                <span class="material-symbols-outlined">local_cafe</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $product->name }}</p>
                                        <p class="text-[11px] text-white/40 truncate max-w-[200px]">{{ $product->slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-white/10 text-white/70 text-xs font-medium rounded-full border border-white/10">
                                    {{ $product->category ? $product->category->name : 'Uncategorized' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-bold text-white">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-semibold {{ $product->stock_quantity <= $product->low_stock_threshold ? 'text-error' : 'text-white' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                    @if($product->stock_quantity <= $product->low_stock_threshold)
                                        <span class="material-symbols-outlined text-error text-[16px]" title="Low Stock">warning</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->is_active)
                                    <span class="flex items-center space-x-1.5 text-xs font-medium text-emerald-400">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                                        <span>Active</span>
                                    </span>
                                @else
                                    <span class="flex items-center space-x-1.5 text-xs font-medium text-white/40">
                                        <div class="w-1.5 h-1.5 rounded-full bg-white/40"></div>
                                        <span>Draft</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button class="p-2 text-white/40 hover:text-primary transition-colors rounded-lg hover:bg-primary/10">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </button>
                                <button class="p-2 text-white/40 hover:text-error transition-colors rounded-lg hover:bg-error/10">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="inline-flex flex-col items-center justify-center text-white/40">
                                    <span class="material-symbols-outlined text-[48px] mb-3">inventory_2</span>
                                    <p class="text-sm">No products found.</p>
                                    <a href="{{ route('admin.menu.create') }}" class="text-primary hover:underline mt-2 text-sm font-medium">Add your first menu item</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- GRID VIEW -->
    <div x-show="viewMode === 'grid'" style="display: none;" class="overflow-auto max-h-[64vh] custom-scrollbar pr-2 pb-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($products as $product)
                <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm group hover:border-primary/50 transition-colors relative flex flex-col h-full">
                    <!-- Image Area -->
                    <div class="aspect-[4/3] bg-black/40 relative overflow-hidden">
                        @if($product->image_url)
                            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-white/10 group-hover:text-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-[64px]">local_cafe</span>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 left-3">
                            @if($product->is_active)
                                <span class="px-2 py-1 bg-emerald-400/20 text-emerald-400 text-[10px] font-bold rounded-md backdrop-blur-md border border-emerald-400/30 uppercase tracking-wider">Active</span>
                            @else
                                <span class="px-2 py-1 bg-black/50 text-white/70 text-[10px] font-bold rounded-md backdrop-blur-md border border-white/10 uppercase tracking-wider">Draft</span>
                            @endif
                        </div>
                    </div>

                    <!-- Content Area -->
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-1 flex justify-between items-start">
                            <span class="text-[11px] font-medium text-primary uppercase tracking-wider">{{ $product->category ? $product->category->name : 'Uncategorized' }}</span>
                            @if($product->stock_quantity <= $product->low_stock_threshold)
                                <span class="material-symbols-outlined text-error text-[16px] animate-pulse" title="Low Stock">warning</span>
                            @endif
                        </div>
                        
                        <h3 class="text-lg font-bold text-white leading-tight mb-1">{{ $product->name }}</h3>
                        <p class="text-xs text-white/50 line-clamp-2 mb-4 flex-1">{{ $product->description ?: 'No description provided.' }}</p>
                        
                        <div class="flex items-end justify-between mt-auto pt-4 border-t border-white/10">
                            <div>
                                <p class="text-[10px] text-white/50 uppercase mb-0.5">Price</p>
                                <p class="text-base font-bold text-white">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-white/50 uppercase mb-0.5">Stock</p>
                                <p class="text-base font-semibold {{ $product->stock_quantity <= $product->low_stock_threshold ? 'text-error' : 'text-white' }}">{{ $product->stock_quantity }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Hover ActionsOverlay -->
                    <div class="absolute inset-0 bg-black/80 backdrop-blur-sm flex items-center justify-center space-x-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <button class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-primary hover:text-black transition-colors" title="Edit Product">
                            <span class="material-symbols-outlined text-[20px]">edit</span>
                        </button>
                        <button class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-error hover:text-white transition-colors" title="Delete Product">
                            <span class="material-symbols-outlined text-[20px]">delete</span>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-white/5 border border-white/10 rounded-2xl backdrop-blur-sm">
                    <div class="inline-flex flex-col items-center justify-center text-white/40">
                        <span class="material-symbols-outlined text-[48px] mb-3">inventory_2</span>
                        <p class="text-sm">No products found.</p>
                        <a href="{{ route('admin.menu.create') }}" class="text-primary hover:underline mt-2 text-sm font-medium">Add your first menu item</a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

</div>
@endsection
