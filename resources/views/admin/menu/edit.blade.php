@extends('layouts.admin')

@section('header_title', 'Edit Menu')

@section('content')
<div class="max-w-4xl mx-auto pb-10">
    <div class="bg-white/5 border border-white/10 rounded-2xl p-8 backdrop-blur-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/10 to-transparent opacity-50 pointer-events-none"></div>
        
        <div class="relative z-10">
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-white tracking-tight mb-2">Edit Product: {{ $product->name }}</h2>
                <p class="text-white/60 text-sm">Update the details of the menu item below.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-error/10 border border-error/20">
                    <div class="flex items-start">
                        <span class="material-symbols-outlined text-error mr-3 text-[20px]">error</span>
                        <div>
                            <h3 class="text-sm font-semibold text-error mb-1">Please correct the following errors:</h3>
                            <ul class="list-disc list-inside text-xs text-error/80 space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.menu.update', $product) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Product Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-white/80">Product Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" required
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="e.g. Caramel Macchiato">
                    </div>

                    <!-- Category -->
                    <div class="space-y-2">
                        <label for="category_id" class="block text-sm font-medium text-white/80">Category *</label>
                        <select id="category_id" name="category_id" required
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors appearance-none">
                            <option value="" disabled class="text-black">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" class="text-black" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Price -->
                    <div class="space-y-2">
                        <label for="price" class="block text-sm font-medium text-white/80">Price (Rp) *</label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}" min="0" required
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                            placeholder="e.g. 45000">
                    </div>

                    <!-- Image Input (File or URL) -->
                    <div class="space-y-2" x-data="{ imageMode: 'upload' }">
                        <div class="flex justify-between items-center">
                            <label class="block text-sm font-medium text-white/80">Product Image</label>
                            <div class="flex space-x-2 text-xs">
                                <button type="button" @click="imageMode = 'upload'" :class="imageMode === 'upload' ? 'text-primary font-bold' : 'text-white/50 hover:text-white/80'">Upload File</button>
                                <span class="text-white/20">|</span>
                                <button type="button" @click="imageMode = 'url'" :class="imageMode === 'url' ? 'text-primary font-bold' : 'text-white/50 hover:text-white/80'">Paste URL</button>
                            </div>
                        </div>
                        
                        <div x-show="imageMode === 'upload'">
                            <input type="file" id="image_file" name="image_file" accept="image/*"
                                class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-black hover:file:bg-primary/90 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                        </div>
                        
                        <div x-show="imageMode === 'url'" style="display: none;">
                            <input type="url" id="image_url" name="image_url" value="{{ old('image_url', (str_starts_with($product->image_url, 'http') ? $product->image_url : '')) }}"
                                class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                placeholder="https://example.com/image.jpg">
                        </div>
                        
                        @if($product->image_url)
                        <div class="mt-2 text-xs text-white/50">
                            Current image: 
                            <a href="{{ $product->image_url }}" target="_blank" class="text-primary hover:underline">View Image</a>
                            <br>
                            <span class="italic mt-1 inline-block">Uploading a new file or entering a new URL will replace the current image.</span>
                        </div>
                        @endif
                    </div>

                    <!-- Initial Stock -->
                    <div class="space-y-2">
                        <label for="stock_quantity" class="block text-sm font-medium text-white/80">Stock *</label>
                        <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0" required
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>

                    <!-- Low Stock Threshold -->
                    <div class="space-y-2">
                        <label for="low_stock_threshold" class="block text-sm font-medium text-white/80">Low Stock Alert Level *</label>
                        <input type="number" id="low_stock_threshold" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold) }}" min="0" required
                            class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label for="description" class="block text-sm font-medium text-white/80">Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full bg-black/40 border border-white/10 rounded-xl px-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors resize-none"
                        placeholder="Brief description of the product...">{{ old('description', $product->description) }}</textarea>
                </div>

                <!-- Status & Submit -->
                <div class="flex items-center justify-between pt-6 border-t border-white/10">
                    <label class="flex items-center space-x-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" class="peer sr-only" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                            <div class="block w-12 h-6 rounded-full bg-white/10 border border-white/20 peer-checked:bg-primary peer-checked:border-primary transition-colors"></div>
                            <div class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full transition-transform peer-checked:translate-x-6"></div>
                        </div>
                        <span class="text-sm font-medium text-white/80 group-hover:text-white transition-colors">Active (Visible in catalog)</span>
                    </label>

                    <div class="flex space-x-3">
                        <a href="{{ route('admin.menu.index') }}" class="px-5 py-2.5 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-sm font-medium rounded-xl transition-colors">
                            Cancel
                        </a>
                        <button type="submit" class="px-5 py-2.5 bg-primary hover:bg-primary/90 text-black text-sm font-bold rounded-xl transition-all shadow-[0_0_15px_rgba(var(--color-primary),0.3)] hover:shadow-[0_0_20px_rgba(var(--color-primary),0.5)]">
                            Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
