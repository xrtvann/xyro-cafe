@extends('layouts.admin')

@section('header_title', 'Transaction Receipt')

@section('content')
<div class="pb-10 flex flex-col items-center justify-center min-h-[70vh]">
    
    <!-- Receipt Card -->
    <div class="bg-white text-black p-8 rounded-xl shadow-2xl w-full max-w-md relative" id="printable-receipt">
        <!-- Logo / Header -->
        <div class="text-center mb-6 border-b border-gray-300 pb-4">
            <h1 class="text-2xl font-bold uppercase tracking-widest mb-1">Xyro Cafe</h1>
            <p class="text-xs text-gray-500 font-mono">Jl. Contoh Alamat No. 123, Kota</p>
            <p class="text-xs text-gray-500 font-mono">Telp: 0812-3456-7890</p>
        </div>

        <!-- Meta -->
        <div class="flex justify-between text-xs font-mono mb-4 text-gray-700">
            <div>
                <p>Order ID : {{ substr($order->id, 0, 8) }}...</p>
                <p>Date     : {{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div class="text-right">
                <p>Kasir    : {{ Auth::user()->full_name ?? 'Staff' }}</p>
                <p>Customer : {{ $order->customer_name ?: 'Guest' }}</p>
            </div>
        </div>

        <!-- Items -->
        <div class="border-t border-b border-gray-300 py-4 mb-4 space-y-3 font-mono text-sm">
            @foreach($order->items as $item)
                <div>
                    <div class="flex justify-between font-semibold">
                        <span>{{ $item->product->name }}</span>
                        <span>{{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="text-gray-500 text-xs">
                        {{ $item->quantity }} x {{ number_format($item->unit_price, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Totals -->
        <div class="space-y-1 text-sm font-mono text-gray-800">
            <div class="flex justify-between">
                <span>Subtotal</span>
                <span>{{ number_format($order->subtotal, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between font-bold text-base mt-2 pt-2 border-t border-gray-300">
                <span>TOTAL</span>
                <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between mt-2 text-gray-600">
                <span>Metode</span>
                <span class="uppercase">{{ $order->payment_method }}</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-xs font-mono text-gray-500">
            <p>Terima kasih atas kunjungan Anda!</p>
            <p>Silakan berkunjung kembali.</p>
            <p class="mt-4 text-[10px]">Powered by Xyro Cafe System</p>
        </div>
    </div>

    <!-- Actions (Not printed) -->
    <div class="mt-8 flex gap-4 no-print">
        <a href="{{ route('admin.pos.index') }}" class="px-6 py-3 rounded-xl bg-white/5 hover:bg-white/10 text-white font-medium transition-colors flex items-center space-x-2 border border-white/10">
            <span class="material-symbols-outlined text-[20px]">arrow_back</span>
            <span>Kembali ke POS</span>
        </a>
        <button onclick="window.print()" class="px-6 py-3 rounded-xl bg-primary hover:bg-primary/90 text-black font-bold transition-all flex items-center space-x-2 shadow-[0_0_15px_rgba(255,183,3,0.3)]">
            <span class="material-symbols-outlined text-[20px]">print</span>
            <span>Cetak Struk</span>
        </button>
    </div>

</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #printable-receipt, #printable-receipt * {
            visibility: visible;
        }
        #printable-receipt {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .no-print {
            display: none !important;
        }
        @page { margin: 0; }
    }
</style>
@endsection
