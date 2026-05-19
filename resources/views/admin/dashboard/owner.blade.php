@extends('layouts.admin')

@section('header_title', 'Cafe Overview')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 h-full pb-10">

    <!-- Left Column: Overview & Recent Orders -->
    <div class="lg:col-span-5 flex flex-col space-y-8">
        
        <!-- Welcome Card -->
        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm relative overflow-hidden group">
            <div class="absolute inset-0 bg-gradient-to-br from-primary/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-white tracking-tight">Welcome back, {{ explode(' ', Auth::user()->full_name)[0] }}!</h2>
                    <span class="px-3 py-1 bg-primary/20 text-primary text-xs font-semibold rounded-full border border-primary/30 uppercase tracking-wider">Owner</span>
                </div>
                <p class="text-white/60 text-sm leading-relaxed mb-6">Here is what's happening at Xyro Cafe today. Your POS system and online orders are running smoothly.</p>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 bg-primary text-black text-sm font-semibold rounded-lg hover:bg-primary/90 transition-colors shadow-[0_0_15px_rgba(var(--color-primary),0.4)]">View Reports</button>
                    <button class="px-4 py-2 bg-white/10 text-white text-sm font-semibold rounded-lg hover:bg-white/20 transition-colors border border-white/5">Manage Menu</button>
                </div>
            </div>
        </div>

        <!-- Recent Orders List -->
        <div class="flex-1 bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-semibold text-white">Recent Orders</h3>
                <a href="#" class="text-xs text-primary hover:underline">View all</a>
            </div>
            
            <div class="space-y-4 overflow-y-auto pr-2 scrollbar-hide flex-1">
                <!-- Dummy Order Item 1 -->
                <div class="group flex items-center p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer border border-transparent hover:border-white/5">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">local_cafe</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">Order #XC-1042</p>
                        <p class="text-[11px] text-white/50">Dine-in • Table 04</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">Rp 85.000</p>
                        <p class="text-[11px] text-emerald-400">Completed</p>
                    </div>
                </div>

                <!-- Dummy Order Item 2 -->
                <div class="group flex items-center p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer border border-transparent hover:border-white/5">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">takeout_dining</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">Order #XC-1043</p>
                        <p class="text-[11px] text-white/50">Online • Gojek</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">Rp 120.000</p>
                        <p class="text-[11px] text-amber-400">Preparing</p>
                    </div>
                </div>

                <!-- Dummy Order Item 3 -->
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
                        <p class="text-[11px] text-emerald-400">Completed</p>
                    </div>
                </div>
                
                <!-- Dummy Order Item 4 -->
                <div class="group flex items-center p-3 rounded-xl hover:bg-white/5 transition-colors cursor-pointer border border-transparent hover:border-white/5">
                    <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center mr-4 text-white/50 group-hover:text-primary transition-colors">
                        <span class="material-symbols-outlined text-[20px]">takeout_dining</span>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-white">Order #XC-1045</p>
                        <p class="text-[11px] text-white/50">Online • Midtrans</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-white">Rp 210.000</p>
                        <p class="text-[11px] text-blue-400">Delivery</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Analytics & Charts -->
    <div class="lg:col-span-7 flex flex-col space-y-8">
        
        <!-- Analytics Grid -->
        <div class="grid grid-cols-2 gap-4">
            <!-- Stat 1 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-white/70">receipt</span>
                    </div>
                    <span class="text-[10px] text-emerald-400 font-bold bg-emerald-400/10 px-2 py-1 rounded-full">+12%</span>
                </div>
                <p class="text-[12px] text-white/50 uppercase tracking-wider mb-1">Total Orders (Today)</p>
                <h4 class="text-2xl font-bold text-white">142</h4>
            </div>

            <!-- Stat 2 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-white/70">payments</span>
                    </div>
                    <span class="text-[10px] text-emerald-400 font-bold bg-emerald-400/10 px-2 py-1 rounded-full">+8.5%</span>
                </div>
                <p class="text-[12px] text-white/50 uppercase tracking-wider mb-1">Revenue (Today)</p>
                <h4 class="text-2xl font-bold text-white">Rp 4.2M</h4>
            </div>

            <!-- Stat 3 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-white/70">point_of_sale</span>
                    </div>
                </div>
                <p class="text-[12px] text-white/50 uppercase tracking-wider mb-1">Active Cashiers</p>
                <h4 class="text-2xl font-bold text-white">2 <span class="text-sm font-normal text-white/40">/ 3</span></h4>
            </div>

            <!-- Stat 4 -->
            <div class="bg-white/5 border border-white/10 rounded-2xl p-5 hover:bg-white/10 transition-colors">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-8 h-8 rounded-full bg-error/20 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[16px] text-error">warning</span>
                    </div>
                </div>
                <p class="text-[12px] text-white/50 uppercase tracking-wider mb-1">Low Stock Items</p>
                <h4 class="text-2xl font-bold text-white">4</h4>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="flex-1 bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-white">Revenue Trend</h3>
                    <p class="text-xs text-white/50">Last 7 days</p>
                </div>
                <div class="flex space-x-2">
                    <button class="px-3 py-1 bg-white/10 text-[11px] font-semibold text-white rounded-md">Weekly</button>
                    <button class="px-3 py-1 text-[11px] font-semibold text-white/50 hover:bg-white/5 rounded-md transition-colors">Monthly</button>
                </div>
            </div>
            
            <!-- Mock Chart Area using CSS/SVG for visual representation -->
            <div class="flex-1 relative w-full mt-4 flex items-end justify-between px-2">
                <!-- Grid Lines -->
                <div class="absolute inset-0 flex flex-col justify-between pb-8 z-0">
                    <div class="w-full h-px bg-white/5"></div>
                    <div class="w-full h-px bg-white/5"></div>
                    <div class="w-full h-px bg-white/5"></div>
                    <div class="w-full h-px bg-white/5"></div>
                </div>

                <!-- Bars -->
                <div class="relative z-10 w-8 md:w-12 bg-primary/20 rounded-t-sm h-[40%] group hover:bg-primary/40 transition-colors"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">1.2M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white/50">Mon</div></div>
                <div class="relative z-10 w-8 md:w-12 bg-primary/40 rounded-t-sm h-[65%] group hover:bg-primary/60 transition-colors"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">2.4M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white/50">Tue</div></div>
                <div class="relative z-10 w-8 md:w-12 bg-primary/30 rounded-t-sm h-[50%] group hover:bg-primary/50 transition-colors"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">1.8M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white/50">Wed</div></div>
                <div class="relative z-10 w-8 md:w-12 bg-primary/80 rounded-t-sm h-[90%] group hover:bg-primary transition-colors"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">3.5M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white/50">Thu</div></div>
                <div class="relative z-10 w-8 md:w-12 bg-primary/60 rounded-t-sm h-[75%] group hover:bg-primary/80 transition-colors"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">2.8M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white/50">Fri</div></div>
                <div class="relative z-10 w-8 md:w-12 bg-primary rounded-t-sm h-[100%] shadow-[0_0_15px_rgba(var(--color-primary),0.3)] group"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">4.2M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white font-bold">Sat</div></div>
                <div class="relative z-10 w-8 md:w-12 bg-primary/20 rounded-t-sm h-[30%] group hover:bg-primary/40 transition-colors"><div class="absolute -top-6 left-1/2 -translate-x-1/2 text-[10px] text-white opacity-0 group-hover:opacity-100 transition-opacity">0.9M</div><div class="absolute -bottom-6 left-1/2 -translate-x-1/2 text-[10px] text-white/50">Sun</div></div>
            </div>
        </div>

    </div>
</div>
@endsection
