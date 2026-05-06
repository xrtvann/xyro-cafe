<nav class="sticky top-0 w-full z-50 bg-black/40 backdrop-blur-[20px] border-b border-white/10 shadow-[0px_20px_40px_rgba(0,0,0,0.3)]">
    <div class="flex justify-between items-center max-w-7xl mx-auto px-8 h-20">
        <!-- Logo -->
        <a href="/" class="text-2xl font-black tracking-tighter text-primary">Xyro Cafe</a>

        <!-- Desktop Links -->
        <div class="hidden md:flex items-center space-x-8">
            <a class="font-heading font-semibold tracking-wide text-sm uppercase {{ request()->routeIs('home') ? 'text-primary border-b-2 border-primary' : 'text-white/80' }} pb-1 hover:text-primary transition-all duration-300 ease-in-out active:scale-95 cursor-pointer" href="/">Home</a>
            <a class="font-heading font-semibold tracking-wide text-sm uppercase {{ request()->routeIs('customer.story') ? 'text-primary border-b-2 border-primary' : 'text-white/80' }} pb-1 hover:text-primary transition-all duration-300 ease-in-out active:scale-95 cursor-pointer" href="{{ route('customer.story') }}">Story</a>
            <a class="font-heading font-semibold tracking-wide text-sm uppercase {{ request()->routeIs('customer.catalog') ? 'text-primary border-b-2 border-primary' : 'text-white/80' }} pb-1 hover:text-primary transition-all duration-300 ease-in-out active:scale-95 cursor-pointer" href="{{ route('customer.catalog') }}">Menu</a>
            <a class="font-heading font-semibold tracking-wide text-sm uppercase {{ request()->routeIs('customer.faq') ? 'text-primary border-b-2 border-primary' : 'text-white/80' }} pb-1 hover:text-primary transition-all duration-300 ease-in-out active:scale-95 cursor-pointer" href="{{ route('customer.faq') }}">FAQ</a>
        </div>

        <!-- Actions -->
        <div class="flex items-center">
            <div class="flex items-center space-x-6">
                @auth
                    <!-- User Dropdown Menu -->
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" @click.away="open = false" class="flex items-center justify-center w-10 h-10 rounded-full glass-panel text-white/90 hover:bg-white/10 hover:text-primary transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-primary/50">
                            <span class="material-symbols-outlined text-[22px]">person</span>
                        </button>
                        
                        <!-- Dropdown Content -->
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-[-10px]"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-[-10px]"
                             class="absolute right-0 mt-3 w-56 rounded-2xl bg-surface/95 backdrop-blur-xl border border-white/10 shadow-[0_8px_30px_rgb(0,0,0,0.4)] py-2 z-50"
                             style="display: none;">
                            
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-white/10 mb-2">
                                <p class="text-sm font-bold text-on-surface truncate">{{ Auth::user()->full_name }}</p>
                                <p class="text-xs text-secondary truncate capitalize mt-0.5">{{ Auth::user()->role }}</p>
                            </div>

                            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 text-sm text-on-surface/80 hover:bg-white/5 hover:text-primary transition-colors flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3">dashboard</span>
                                Dashboard
                            </a>
                            
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2.5 text-sm text-on-surface/80 hover:bg-white/5 hover:text-primary transition-colors flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3">account_circle</span>
                                Profile
                            </a>

                            <a href="#" class="block px-4 py-2.5 text-sm text-on-surface/80 hover:bg-white/5 hover:text-primary transition-colors flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3">settings</span>
                                Settings
                            </a>

                            <form method="POST" action="{{ route('logout') }}" class="mt-2 border-t border-white/10 pt-2">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-2.5 text-sm text-error/90 hover:bg-error/10 hover:text-error transition-colors flex items-center">
                                    <span class="material-symbols-outlined text-[18px] mr-3">logout</span>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full glass-panel text-sm font-semibold text-white/90 hover:bg-white/10 transition-all duration-300">
                        Login / Register
                    </a>
                @endauth
                
                <button class="relative flex items-center justify-center active:scale-95 transition-transform cursor-pointer">
                    <span class="material-symbols-outlined text-primary text-2xl">shopping_cart</span>
                    <span class="absolute -top-2 -right-2 bg-primary text-black text-[10px] font-black w-5 h-5 flex items-center justify-center rounded-full border-2 border-black/20">
                        0
                    </span>
                </button>
            </div>
        </div>
    </div>
</nav>
