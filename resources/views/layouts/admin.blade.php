    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Xyro Cafe') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800|outfit:400,500,600,700,800,900" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#0a0a0a] text-white/90 selection:bg-primary/30 h-screen overflow-hidden flex">

    <!-- Sidebar -->
    <aside class="w-[280px] h-full flex flex-col border-r border-white/5 bg-[#0f0f0f]/80 backdrop-blur-xl shrink-0">
        <!-- Sidebar Header (User/App Info) -->
        <div class="h-[72px] flex items-center px-6 border-b border-white/5">
            <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-black font-bold mr-3">
                {{ strtoupper(substr(Auth::user()->full_name, 0, 1)) }}
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->full_name }}</p>
                <p class="text-[11px] text-white/50 uppercase tracking-widest">{{ Auth::user()->role }}</p>
            </div>
            <a href="/" class="text-white/40 hover:text-white transition-colors" title="Go to Website">
                <span class="material-symbols-outlined text-[20px]">language</span>
            </a>
        </div>

        <!-- Sidebar Navigation -->
        <nav class="flex-1 overflow-y-auto py-6 px-4 space-y-8 scrollbar-hide">

            <!-- APPLICATION SECTION -->
            <div>
                <p class="px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-3">Application</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center justify-between px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white transition-colors' }}">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-white/50' }}">home</span>
                                <span class="text-[13px]">Home</span>
                            </div>
                        </a>
                    </li>
                    @if(in_array(Auth::user()->role, ['owner', 'kasir']))
                    <li>
                        <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 text-white/50">point_of_sale</span>
                                <span class="text-[13px]">POS Cashier</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->role === 'customer')
                    <li>
                        <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 text-white/50">receipt_long</span>
                                <span class="text-[13px]">My Orders</span>
                            </div>
                            <span class="text-[11px] font-semibold text-white/40">2</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- INVENTORY SECTION (Owner & Kasir) -->
            @if(in_array(Auth::user()->role, ['owner', 'kasir']))
            <div>
                <p class="px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-3">Inventory</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('admin.stock.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg {{ request()->routeIs('admin.stock.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white transition-colors' }}">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 {{ request()->routeIs('admin.stock.*') ? 'text-white' : 'text-white/50' }}">inventory_2</span>
                                <span class="text-[13px]">Stock Overview</span>
                            </div>
                        </a>
                    </li>
                    @if(Auth::user()->role === 'owner')
                    <li>
                        <a href="{{ route('admin.menu.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg {{ request()->routeIs('admin.menu.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white transition-colors' }}">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 {{ request()->routeIs('admin.menu.*') ? 'text-white' : 'text-white/50' }}">menu_book</span>
                                <span class="text-[13px]">Menu Catalog</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.category.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg {{ request()->routeIs('admin.category.*') ? 'bg-white/10 text-white font-medium' : 'text-white/60 hover:bg-white/5 hover:text-white transition-colors' }}">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 {{ request()->routeIs('admin.category.*') ? 'text-white' : 'text-white/50' }}">category</span>
                                <span class="text-[13px]">Category Catalog</span>
                            </div>
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
            @endif

            <!-- BUSINESS SECTION (Owner Only) -->
            @if(Auth::user()->role === 'owner')
            <div>
                <p class="px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-3">Business</p>
                <ul class="space-y-1">
                    <li>
                        <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 text-white/50">monitoring</span>
                                <span class="text-[13px]">Financial Reports</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 text-white/50">groups</span>
                                <span class="text-[13px]">Staff Members</span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            @endif

            <!-- MY ACCOUNT SECTION -->
            <div>
                <p class="px-3 text-[10px] font-bold uppercase tracking-[0.2em] text-white/30 mb-3">My Account</p>
                <ul class="space-y-1">
                    <li>
                        <a href="{{ route('profile.edit') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-white/60 hover:bg-white/5 hover:text-white transition-colors">
                            <div class="flex items-center">
                                <span class="material-symbols-outlined text-[18px] mr-3 text-white/50">person</span>
                                <span class="text-[13px]">Profile</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-between px-3 py-2 rounded-lg text-error/80 hover:bg-error/10 hover:text-error transition-colors">
                                <div class="flex items-center">
                                    <span class="material-symbols-outlined text-[18px] mr-3">logout</span>
                                    <span class="text-[13px]">Logout</span>
                                </div>
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

        </nav>
    </aside>

    <!-- Main Content Area -->
    <main class="flex-1 flex flex-col h-full overflow-hidden bg-[#0a0a0a]">
        <!-- Top Header -->
        <header class="h-[72px] border-b border-white/5 flex items-center px-8 shrink-0">
            <h1 class="text-xl font-semibold text-white">@yield('header_title', 'Dashboard')</h1>
        </header>

        <!-- Scrollable Content -->
        <div class="flex-1 overflow-y-auto p-8 scrollbar-hide">
            @yield('content')
        </div>
    </main>

    <!-- Global Toast Notification -->
    <div x-data="{ 
            show: false, 
            message: '', 
            type: 'success',
            init() {
                @if(session('success'))
                    this.message = '{{ session('success') }}';
                    this.type = 'success';
                    this.show = true;
                    setTimeout(() => this.show = false, 4000);
                @endif
                
                @if(session('error'))
                    this.message = '{{ session('error') }}';
                    this.type = 'error';
                    this.show = true;
                    setTimeout(() => this.show = false, 4000);
                @endif
            }
         }"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-x-8"
         x-transition:enter-end="opacity-100 transform translate-x-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-x-0"
         x-transition:leave-end="opacity-0 transform translate-x-8"
         style="display: none;"
         class="fixed top-8 right-8 z-50 min-w-[320px] p-4 rounded-xl backdrop-blur-xl border shadow-2xl flex items-start"
         :class="{
             'bg-emerald-500/20 border-emerald-500/30 text-emerald-400': type === 'success',
             'bg-red-500/20 border-red-500/30 text-red-400': type === 'error'
         }">
        <div class="flex items-center space-x-3 flex-1">
            <span class="material-symbols-outlined text-[24px]" x-text="type === 'success' ? 'check_circle' : 'error'"></span>
            <span class="text-sm font-medium text-white" x-text="message"></span>
        </div>
        <button @click="show = false" class="text-white/50 hover:text-white transition-colors ml-4 focus:outline-none shrink-0">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>

    <style>
        /* Hide scrollbar for Chrome, Safari and Opera */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .scrollbar-hide {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</body>
</html>
