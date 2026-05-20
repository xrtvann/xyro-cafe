@extends('layouts.admin')

@section('header_title', 'Cashier Overview')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full pb-10">

    <!-- Left Column: Overview & Active Shift -->
    <div class="lg:col-span-6 flex flex-col space-y-8">
        
        <!-- Welcome Card -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white tracking-tight">Hello, {{ explode(' ', Auth::user()->full_name)[0] }}!</h2>
                    <span class="px-3 py-1 bg-white/10 text-white/80 text-xs font-semibold rounded-full border border-white/20 uppercase tracking-wider">Cashier</span>
                </div>
                <p class="text-white/60 text-sm leading-relaxed mb-6">Your shift has started. Ready to process some orders today?</p>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 bg-primary text-black text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors shadow-[0_0_15px_rgba(var(--color-primary),0.4)]">Open POS System</button>
                </div>
            </div>
        </div>

        <!-- Recent POS Transactions -->
        <div class="flex-1 bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white">Your Recent Transactions</h3>
            </div>
            
            <div class="space-y-4 overflow-y-auto pr-2 scrollbar-hide flex-1">
                <!-- Dummy Order Item 1 -->
                <div class="group flex items-center p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer border border-transparent hover:border-white/5">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">local_cafe</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">Order #XC-1044</p>
                        <p class="text-[11px] text-white/50">Dine-in • Table 02</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">Rp 45.000</p>
                        <p class="text-[11px] text-emerald-400">Paid - Cash</p>
                    </div>
                </div>

                <!-- Dummy Order Item 2 -->
                <div class="group flex items-center p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer border border-transparent hover:border-white/5">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">Order #XC-1042</p>
                        <p class="text-[11px] text-white/50">Dine-in • Table 04</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">Rp 85.000</p>
                        <p class="text-[11px] text-emerald-400">Paid - QRIS</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Shift Stats -->
    <div class="lg:col-span-6 flex flex-col space-y-8">
        
        <!-- Shift Analytics Grid -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Stat 1 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-white/70">receipt</span>
                    </div>
                </div>
                <p class="text-[12px] text-white/50 uppercase tracking-wider mb-1">Orders Handled (Shift)</p>
                <h4 class="text-2xl font-bold text-white">24</h4>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-white/70">inventory_2</span>
                    </div>
                </div>
                <p class="text-[12px] text-white/50 uppercase tracking-wider mb-1">Low Stock Alerts</p>
                <h4 class="text-2xl font-bold text-white">2</h4>
            </div>
        </div>

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm flex flex-col">
            <h3 class="text-lg font-semibold text-white mb-4">Quick Actions</h3>
            <div class="grid grid-cols-2 gap-4">
                <button class="flex flex-col items-center justify-center p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl transition-colors">
                    <span class="material-symbols-outlined text-white/70 mb-2">print</span>
                    <span class="text-sm font-medium text-white">Reprint Receipt</span>
                </button>
                <button class="flex flex-col items-center justify-center p-4 bg-white/5 hover:bg-white/10 border border-white/5 rounded-xl transition-colors">
                    <span class="material-symbols-outlined text-white/70 mb-2">qr_code_scanner</span>
                    <span class="text-sm font-medium text-white">Scan QR</span>
                </button>
            </div>
        </div>

    </div>
</div>
@endsection
