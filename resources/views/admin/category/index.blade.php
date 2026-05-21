@extends('layouts.admin')

@section('header_title', 'Category Management')

@section('content')
<!-- Alpine.js component for view toggle & delete modal -->
<div x-data="{ 
    deleteModalOpen: false, 
    deleteUrl: '', 
    deleteCategoryName: '', 
    isPermanent: false, 
    openDeleteModal(url, name, permanent) { 
        this.deleteUrl = url; 
        this.deleteCategoryName = name; 
        this.isPermanent = permanent; 
        this.deleteModalOpen = true; 
    } 
}" class="pb-10 space-y-6 relative">
    
    <!-- Top Action Bar -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white tracking-tight">Category Catalog</h2>
            <p class="text-white/60 text-sm mt-1">Manage product categories for your cafe.</p>
        </div>
        
        <div class="flex items-center space-x-3 w-full sm:w-auto">
            <a href="{{ route('admin.category.create') }}" class="w-full sm:w-auto px-4 py-2 bg-primary hover:bg-primary/90 text-black text-sm font-bold rounded-xl transition-colors shadow-[0_0_15px_rgba(255,183,3,0.3)] flex items-center justify-center space-x-2">
                <span class="material-symbols-outlined text-[20px]">add</span>
                <span>Add Category</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-4 backdrop-blur-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary/5 via-transparent to-transparent opacity-50 pointer-events-none"></div>
        <form action="{{ route('admin.category.search') }}" method="GET" class="relative z-10 flex flex-col sm:flex-row gap-4"
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
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search categories..." class="w-full bg-black/40 border border-white/10 rounded-xl pl-10 pr-4 py-2.5 text-sm text-white placeholder-white/40 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" @input.debounce.300ms="$el.form.requestSubmit()">
            </div>
            
            <!-- Status Filter -->
            <div class="sm:w-40">
                <select name="status" class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none" @change="$el.form.requestSubmit()">
                    <option value="" class="text-black">All Status</option>
                    <option value="active" class="text-black" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="draft" class="text-black" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="trash" class="text-black" {{ request('status') === 'trash' ? 'selected' : '' }}>Trash / Archived</option>
                </select>
            </div>
            
            <!-- Reset Button -->
            @if(request()->hasAny(['search', 'status']))
                <a href="{{ route('admin.category.index') }}" class="px-4 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 rounded-xl text-white text-sm font-medium flex items-center justify-center transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- TABLE VIEW -->
    <div class="bg-white/5 border border-white/10 rounded-2xl overflow-hidden backdrop-blur-sm relative">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-50 pointer-events-none"></div>
        <div class="relative z-10 overflow-auto max-h-[64vh] custom-scrollbar">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="sticky top-0 z-20 bg-black/80 backdrop-blur-md">
                    <tr class="border-b border-white/10">
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">#</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-white/50 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-white/10">
                    @forelse($categories as $category)
                        <tr class="hover:bg-white/5 transition-colors group">
                            <td class="px-6 py-4">
                                <span class="text-sm font-semibold text-white">{{ $categories->firstItem() + $loop->index }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-white">{{ $category->name }}</p>
                                    <p class="text-[11px] text-white/40 truncate max-w-[200px]">{{ $category->slug }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 bg-white/10 text-white/70 text-xs font-medium rounded-full border border-white/10">
                                    {{ $category->products_count }} items
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($category->trashed())
                                    <span class="flex items-center space-x-1.5 text-xs font-medium text-error">
                                        <div class="w-1.5 h-1.5 rounded-full bg-error"></div>
                                        <span>Deleted</span>
                                    </span>
                                @elseif($category->is_active)
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
                                @if($category->trashed())
                                    <div class="flex items-center justify-end space-x-2">
                                        <form action="{{ route('admin.category.restore', $category->slug) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="p-2 text-white/40 hover:text-emerald-400 transition-colors rounded-lg hover:bg-emerald-400/10" title="Restore">
                                                <span class="material-symbols-outlined text-[20px]">restore</span>
                                            </button>
                                        </form>
                                        <button @click="openDeleteModal('{{ route('admin.category.forceDelete', $category->slug) }}', '{{ addslashes($category->name) }}', true)" type="button" class="p-2 text-white/40 hover:text-error transition-colors rounded-lg hover:bg-error/10" title="Permanent Delete">
                                            <span class="material-symbols-outlined text-[20px]">delete_forever</span>
                                        </button>
                                    </div>
                                @else
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('admin.category.edit', $category) }}" class="p-2 text-white/40 hover:text-primary transition-colors rounded-lg hover:bg-primary/10" title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </a>
                                        <button @click="openDeleteModal('{{ route('admin.category.destroy', $category) }}', '{{ addslashes($category->name) }}', false)" type="button" class="p-2 text-white/40 hover:text-error transition-colors rounded-lg hover:bg-error/10" title="Delete">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="inline-flex flex-col items-center justify-center text-white/40">
                                    <span class="material-symbols-outlined text-[48px] mb-3">category</span>
                                    <p class="text-sm">No categories found.</p>
                                    <a href="{{ route('admin.category.create') }}" class="text-primary hover:underline mt-2 text-sm font-medium">Add your first category</a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Global Delete Modal -->
    <div x-show="deleteModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
        <!-- Backdrop -->
        <div x-show="deleteModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/60 backdrop-blur-sm" 
             @click="deleteModalOpen = false"></div>
        
        <!-- Modal Content -->
        <div x-show="deleteModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 transform scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 transform scale-95 translate-y-4"
             class="relative bg-[#1a1a1a] border border-white/10 rounded-2xl p-6 w-full max-w-md shadow-2xl overflow-hidden mx-4">
            
            <div class="absolute inset-0 bg-gradient-to-br from-error/10 to-transparent opacity-50 pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="flex items-center space-x-4 mb-5">
                    <div class="w-12 h-12 rounded-full bg-error/20 flex items-center justify-center text-error shrink-0">
                        <span class="material-symbols-outlined" x-text="isPermanent ? 'delete_forever' : 'delete'"></span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white" x-text="isPermanent ? 'Permanent Delete' : 'Move to Trash'"></h3>
                        <p class="text-sm text-white/60 mt-1">Are you sure you want to delete <span class="font-bold text-white" x-text="deleteCategoryName"></span>?</p>
                    </div>
                </div>
                
                <p class="text-xs text-error/80 bg-error/10 p-3 rounded-lg border border-error/20 mb-6" x-show="isPermanent">
                    <span class="font-bold block mb-1">Warning!</span> This action cannot be undone. The category will be permanently removed from the server.
                </p>
                <p class="text-xs text-white/50 bg-white/5 p-3 rounded-lg mb-6" x-show="!isPermanent">
                    You can restore this item later from the Trash if needed. Note: Categories containing products cannot be deleted.
                </p>

                <div class="flex justify-end space-x-3">
                    <button type="button" @click="deleteModalOpen = false" class="px-4 py-2.5 text-sm font-medium text-white/70 hover:text-white bg-white/5 hover:bg-white/10 rounded-xl transition-colors">Cancel</button>
                    <form :action="deleteUrl" method="POST" class="inline m-0">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2.5 text-sm font-bold text-white bg-error hover:bg-error/90 rounded-xl transition-colors shadow-[0_0_15px_rgba(239,68,68,0.3)]">
                            <span x-text="isPermanent ? 'Yes, Delete Permanently' : 'Yes, Move to Trash'"></span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
