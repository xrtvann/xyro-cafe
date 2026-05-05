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
                    <a href="{{ url('/dashboard') }}" class="px-5 py-2 rounded-full glass-panel text-sm font-semibold text-white/90 hover:bg-white/10 transition-all duration-300">
                        Dashboard
                    </a>
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
