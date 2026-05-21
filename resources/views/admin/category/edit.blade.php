@extends('layouts.admin')

@section('header_title', 'Edit Category')

@section('content')
<div class="max-w-3xl mx-auto pb-10 space-y-6">
    
    <!-- Top Bar -->
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.category.index') }}" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-white/60 hover:text-white hover:bg-white/10 transition-colors">
                <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            </a>
            <div>
                <h2 class="text-2xl font-bold text-white tracking-tight">Edit Category</h2>
                <p class="text-white/60 text-sm mt-1">Update category details and status.</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white/5 border border-white/10 rounded-2xl p-6 sm:p-8 backdrop-blur-sm relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-50 pointer-events-none"></div>
        
        <form action="{{ route('admin.category.update', $category) }}" method="POST" class="relative z-10 space-y-6">
            @csrf
            @method('PUT')

            <!-- Name Field -->
            <div class="space-y-2">
                <label for="name" class="block text-sm font-medium text-white/80">Category Name <span class="text-error">*</span></label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[20px]">category</span>
                    <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required
                           class="w-full bg-black/40 border {{ $errors->has('name') ? 'border-error' : 'border-white/10' }} rounded-xl pl-10 pr-4 py-3 text-white placeholder-white/30 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                           placeholder="e.g. Signature Coffee">
                </div>
                @error('name')
                    <p class="text-error text-xs font-medium mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Toggle -->
            <div class="space-y-3 pt-2">
                <label class="block text-sm font-medium text-white/80">Category Status</label>
                <div class="flex items-center p-4 bg-black/40 border border-white/10 rounded-xl space-x-4">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                    </label>
                    <div>
                        <p class="text-sm font-medium text-white">Active Status</p>
                        <p class="text-xs text-white/50">If disabled, this category won't be visible to customers.</p>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 mt-6 border-t border-white/10">
                <a href="{{ route('admin.category.index') }}" class="px-6 py-2.5 bg-white/5 hover:bg-white/10 text-white font-medium rounded-xl transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-black font-bold rounded-xl transition-colors shadow-[0_0_15px_rgba(255,183,3,0.3)] flex items-center space-x-2">
                    <span class="material-symbols-outlined text-[20px]">save</span>
                    <span>Update Category</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
