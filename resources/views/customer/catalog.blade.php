<x-app-layout>
    <div class="pt-32 pb-24 max-w-7xl mx-auto px-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-8">
            <div class="max-w-2xl">
                <h1 class="text-4xl md:text-5xl font-heading font-bold text-on-surface mb-4">The Catalog</h1>
                <p class="text-on-surface-variant text-lg">Jelajahi pilihan kopi terbaik, minuman non-kopi yang menyegarkan, dan pastry artisan kami.</p>
            </div>
            
            <!-- Search & Filter Bar (Desktop) -->
            <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto">
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-primary transition-colors">search</span>
                    <input type="text" placeholder="Cari menu..." class="w-full sm:w-64 pl-12 pr-6 py-3 bg-white/5 border border-white/10 rounded-full text-on-surface focus:outline-none focus:border-primary/50 focus:bg-white/10 transition-all font-sans">
                </div>
            </div>
        </div>

        <!-- Filter Categories -->
        <div class="flex flex-wrap gap-4 mb-12 overflow-x-auto pb-2 scrollbar-hide">
            <button class="px-8 py-3 rounded-full bg-primary text-on-primary font-heading font-bold shadow-lg shadow-primary/20 transition-all">All Items</button>
            <button class="px-8 py-3 rounded-full glass-panel text-on-surface-variant hover:text-primary hover:border-primary/50 transition-all font-heading font-bold border border-white/10">Coffee</button>
            <button class="px-8 py-3 rounded-full glass-panel text-on-surface-variant hover:text-primary hover:border-primary/50 transition-all font-heading font-bold border border-white/10">Non-Coffee</button>
            <button class="px-8 py-3 rounded-full glass-panel text-on-surface-variant hover:text-primary hover:border-primary/50 transition-all font-heading font-bold border border-white/10">Pastry</button>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <!-- Product 1 -->
            <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col group h-full">
                <div class="h-64 relative overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1541167760496-162955ed8a9f?auto=format&fit=crop&q=80&w=800" alt="Midnight Velvet Latte"/>
                    <div class="absolute top-4 left-4 glass-panel px-4 py-1.5 rounded-full text-[10px] font-black text-primary uppercase tracking-[0.2em] border border-white/10">Signature</div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-heading text-xl font-bold text-on-surface leading-tight">Midnight Velvet Latte</h3>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 font-sans line-clamp-2">Perpaduan espresso pekat dengan charcoal aktif dan sutra vanilla bean.</p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-primary font-black text-xl">Rp 35.000</span>
                        <button class="w-12 h-12 rounded-2xl bg-primary-container/20 text-primary flex items-center justify-center hover:bg-primary hover:text-on-primary transition-all active:scale-95 shadow-inner">
                            <span class="material-symbols-outlined text-2xl">add_shopping_cart</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 2 -->
            <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col group h-full">
                <div class="h-64 relative overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1559496417-e7f25cb247f3?auto=format&fit=crop&q=80&w=800" alt="Amber Quartz Cold Brew"/>
                    <div class="absolute top-4 left-4 glass-panel px-4 py-1.5 rounded-full text-[10px] font-black text-primary uppercase tracking-[0.2em] border border-white/10">Cold Brew</div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-heading text-xl font-bold text-on-surface leading-tight">Amber Quartz Cold</h3>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 font-sans line-clamp-2">Cold brew yang diseduh selama 18 jam dengan catatan rasa nectarine.</p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-primary font-black text-xl">Rp 28.000</span>
                        <button class="w-12 h-12 rounded-2xl bg-primary-container/20 text-primary flex items-center justify-center hover:bg-primary hover:text-on-primary transition-all active:scale-95 shadow-inner">
                            <span class="material-symbols-outlined text-2xl">add_shopping_cart</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col group h-full opacity-75">
                <div class="h-64 relative overflow-hidden grayscale-[0.5]">
                    <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1555507036-ab1f4038808a?auto=format&fit=crop&q=80&w=800" alt="Gold-Leaf Brioche"/>
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="bg-error-container text-on-error-container px-6 py-2 rounded-full font-bold text-xs uppercase tracking-widest border border-error/50">Sold Out</span>
                    </div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-heading text-xl font-bold text-on-surface leading-tight">Gold-Leaf Brioche</h3>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 font-sans line-clamp-2">Brioche yang dibuat tangan dengan infus saffron dan topping emas 24k.</p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-on-surface-variant font-bold text-xl line-through">Rp 45.000</span>
                        <button class="w-12 h-12 rounded-2xl bg-white/5 text-on-surface/20 flex items-center justify-center cursor-not-allowed" disabled>
                            <span class="material-symbols-outlined text-2xl">block</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product 4 -->
            <div class="glass-card rounded-[2rem] overflow-hidden flex flex-col group h-full">
                <div class="h-64 relative overflow-hidden">
                    <img class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" src="https://images.unsplash.com/photo-1578314675249-a6910f80cc4e?auto=format&fit=crop&q=80&w=800" alt="Crimson Berry Tea"/>
                    <div class="absolute top-4 left-4 glass-panel px-4 py-1.5 rounded-full text-[10px] font-black text-primary uppercase tracking-[0.2em] border border-white/10">Non-Coffee</div>
                </div>
                <div class="p-8 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-3">
                        <h3 class="font-heading text-xl font-bold text-on-surface leading-tight">Crimson Berry Tea</h3>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 font-sans line-clamp-2">Teh hibiscus organik dengan potongan berry segar dan madu hutan.</p>
                    <div class="mt-auto flex items-center justify-between">
                        <span class="text-primary font-black text-xl">Rp 25.000</span>
                        <button class="w-12 h-12 rounded-2xl bg-primary-container/20 text-primary flex items-center justify-center hover:bg-primary hover:text-on-primary transition-all active:scale-95 shadow-inner">
                            <span class="material-symbols-outlined text-2xl">add_shopping_cart</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
