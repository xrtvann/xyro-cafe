@extends('layouts.admin')

@section('header_title', 'My Orders')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full pb-10">

    <!-- Left Column: Overview & Active Shift -->
    <div class="lg:col-span-8 flex flex-col space-y-8">
        
        <!-- Welcome Card -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white tracking-tight">Welcome, {{ explode(' ', Auth::user()->full_name)[0] }}!</h2>
                </div>
                <p class="text-white/60 text-sm leading-relaxed mb-6">Craving for some coffee? Check out our latest menu or track your current orders below.</p>
                <div class="flex space-x-3">
                    <a href="{{ route('customer.catalog') }}" class="px-4 py-2 bg-primary text-black text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors shadow-[0_0_15px_rgba(var(--color-primary),0.4)]">Order Now</a>
                </div>
            </div>
        </div>

        <!-- Recent POS Transactions -->
        <div class="flex-1 bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white">Your Recent Orders</h3>
            </div>
            
            <div class="space-y-4 overflow-y-auto pr-2 scrollbar-hide flex-1">
                <!-- Dummy Order Item 1 -->
                <div class="group flex items-center p-4 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[24px]">takeout_dining</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-sm font-semibold text-white">Order #XC-1045</p>
                            <span class="px-2 py-1 bg-blue-500/20 text-blue-400 text-[10px] font-bold uppercase rounded border border-blue-500/30">Delivery</span>
                        </div>
                        <p class="text-[12px] text-white/50 mb-2">2x Iced Caramel Macchiato, 1x Croissant</p>
                        <p class="text-sm font-bold text-white">Rp 120.000</p>
                    </div>
                </div>

                <!-- Dummy Order Item 2 -->
                <div class="group flex items-center p-4 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 transition-colors">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[24px]">local_cafe</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex justify-between items-start mb-1">
                            <p class="text-sm font-semibold text-white">Order #XC-0922</p>
                            <span class="px-2 py-1 bg-emerald-500/20 text-emerald-400 text-[10px] font-bold uppercase rounded border border-emerald-500/30">Completed</span>
                        </div>
                        <p class="text-[12px] text-white/50 mb-2">1x Americano Hot</p>
                        <p class="text-sm font-bold text-white">Rp 25.000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Shift Stats -->
    <div class="lg:col-span-4 flex flex-col space-y-8">
        
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm flex flex-col text-center items-center justify-center h-48">
             <div class="w-16 h-16 rounded-full bg-primary/20 flex items-center justify-center mb-4 text-primary">
                 <span class="material-symbols-outlined text-[32px]">stars</span>
             </div>
             <h3 class="text-lg font-bold text-white">Xyro Rewards</h3>
             <p class="text-sm text-white/50 mt-1">Coming Soon</p>
        </div>

    </div>
</div>
@endsection
