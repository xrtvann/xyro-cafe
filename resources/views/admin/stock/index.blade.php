@extends('layouts.admin')

@section('header_title', 'Stock Overview')

@section('content')
<!-- Alpine.js component for view toggle & edit modal -->
<div x-data="{ 
    editModalOpen: false, 
    editUrl: '', 
    editProductName: '', 
    editStock: 0,
    editThreshold: 0,
    openEditModal(url, name, currentStock, currentThreshold) { 
        this.editUrl = url; 
        this.editProductName = name; 
        this.editStock = currentStock;
        this.editThreshold = currentThreshold;
        this.editModalOpen = true; 
    } 
}" class="pb-10 space-y-6 relative">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Stock Overview</h2>
            <p class="text-white/60 text-sm mt-1">Monitor and manage your product inventory.</p>
        </div>
    </div>

    <!-- Metrics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <!-- Total Items -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-5 relative overflow-hidden backdrop-blur-sm group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white/60 mb-1">Total Items</p>
                    <h3 class="text-3xl font-bold text-white">{{ $totalItems }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[24px]">inventory_2</span>
                </div>
            </div>
        </div>

        <!-- Low Stock -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-5 relative overflow-hidden backdrop-blur-sm group">
            <div class="absolute inset-0 bg-gradient-to-br from-amber-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white/60 mb-1">Low Stock</p>
                    <h3 class="text-3xl font-bold text-amber-500">{{ $lowStock }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500">
                    <span class="material-symbols-outlined text-[24px]">warning</span>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-5 relative overflow-hidden backdrop-blur-sm group">
            <div class="absolute inset-0 bg-gradient-to-br from-error/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-white/60 mb-1">Out of Stock</p>
                    <h3 class="text-3xl font-bold text-error">{{ $outOfStock }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-error/10 flex items-center justify-center text-error">
                    <span class="material-symbols-outlined text-[24px]">error</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/5 via-transparent to-transparent opacity-50 pointer-events-none"></div>
        <form action="{{ route('admin.stock.index') }}" method="GET" class="relative z-10 flex flex-col sm:flex-row gap-4"
              x-data="{}"
              @submit.prevent="
                  let form = $event.target;
                  let params = new URLSearchParams(new FormData(form));
                  Array.from(params.keys()).forEach(key => {
                      if (!params.get(key)) params.delete(key);
                  });
                  window.location.href = form.action + '?' + params.toString();
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
                    <option value="" class="text-black">All Stock Status</option>
                    <option value="in_stock" class="text-black" {{ request('status') === 'in_stock' ? 'selected' : '' }}>In Stock</option>
                    <option value="low_stock" class="text-black" {{ request('status') === 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    <option value="out_of_stock" class="text-black" {{ request('status') === 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                </select>
            </div>
            
            <!-- Reset Button -->
            @if(request()->hasAny(['search', 'category', 'status']))
                <a href="{{ route('admin.stock.index') }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-white text-sm font-medium flex items-center justify-center transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- TABLE VIEW -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm relative">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-50 pointer-events-none"></div>
        <div class="relative z-10 overflow-auto max-h-[60vh] custom-scrollbar">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="sticky top-0 z-20 bg-black/80 backdrop-blur-md">
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider text-center">Threshold</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider text-center">Stock</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($products as $product)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 rounded-lg overflow-hidden bg-black/40 border border-white/10 shrink-0">
                                        @if($product->image_url)
                                            <img src="{{ Str::startsWith($product->image_url, 'http') ? $product->image_url : asset($product->image_url) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <span class="material-symbols-outlined text-white/20 text-[20px]">image</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-white">{{ $product->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-xs font-medium text-white/70">{{ $product->category->name ?? 'Uncategorized' }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm text-white/40 font-mono">{{ $product->low_stock_threshold }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-sm font-bold font-mono {{ $product->stock_quantity == 0 ? 'text-error' : ($product->stock_quantity <= $product->low_stock_threshold ? 'text-amber-500' : 'text-white') }}">
                                    {{ $product->stock_quantity }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($product->stock_quantity == 0)
                                    <span class="flex items-center space-x-1.5 text-xs font-medium text-error">
                                        <div class="w-1.5 h-1.5 rounded-full bg-error"></div>
                                        <span>Out of Stock</span>
                                    </span>
                                @elseif($product->stock_quantity <= $product->low_stock_threshold)
                                    <span class="flex items-center space-x-1.5 text-xs font-medium text-amber-500">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-500"></div>
                                        <span>Low Stock</span>
                                    </span>
                                @else
                                    <span class="flex items-center space-x-1.5 text-xs font-medium text-emerald-400">
                                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
                                        <span>In Stock</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button @click="openEditModal('{{ route('admin.stock.update', $product) }}', '{{ addslashes($product->name) }}', {{ $product->stock_quantity }}, {{ $product->low_stock_threshold }})" type="button" class="px-3 py-1.5 bg-primary/10 hover:bg-primary/20 text-primary text-xs font-bold rounded-lg transition-colors inline-flex items-center space-x-1 border border-primary/20">
                                    <span class="material-symbols-outlined text-[16px]">edit</span>
                                    <span>Update</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="inline-flex flex-col items-center justify-center text-white/40">
                                    <span class="material-symbols-outlined text-[48px] mb-3">inventory_2</span>
                                    <p class="text-sm">No products found matching your criteria.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <div class="mt-6">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Quick Edit Stock Modal -->
    <div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
        <!-- Backdrop -->
        <div x-show="editModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm" 
             @click="editModalOpen = false"></div>
        
        <!-- Modal Content -->
        <div x-show="editModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
             class="relative bg-[#1a1a1a] border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl overflow-hidden mx-4">
            
            <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/20 flex items-center justify-center text-primary shrink-0">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Update Stock</h3>
                        <p class="text-sm text-white/60 mt-0.5 truncate max-w-[200px]" x-text="editProductName"></p>
                    </div>
                </div>
                
                <form :action="editUrl" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-white/80">Current Stock Quantity</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px]">tag</span>
                            <input type="number" name="stock_quantity" x-model="editStock" min="0" required
                                   class="w-full bg-black/40 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors font-mono">
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-white/80">Low Stock Threshold</label>
                        <div class="relative">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px]">warning</span>
                            <input type="number" name="low_stock_threshold" x-model="editThreshold" min="0" required
                                   class="w-full bg-black/40 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors font-mono">
                        </div>
                        <p class="text-[11px] text-white/40">Item will be flagged as Low Stock when quantity drops below or equal to this number.</p>
                    </div>

                    <div class="flex justify-end space-x-3 pt-4 border-t border-white/10 mt-6">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2.5 text-sm font-medium text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-black bg-primary hover:bg-primary/90 rounded-xl transition-colors shadow-[0_0_15px_rgba(255,183,3,0.3)]">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
