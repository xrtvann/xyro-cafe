@extends('layouts.admin')

@section('header_title', 'POS Cashier')

@section('content')
<div x-data="posSystem()" class="pb-10 h-[calc(100vh-100px)] flex flex-col relative">
    
    <!-- Product Catalog (Full Width) -->
    <div class="w-full flex flex-col h-full relative">
        
        <!-- Header & Filters -->
        <div class="relative z-10 pb-5 mb-5 border-b border-white/10 shrink-0">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                <div>
                    <h2 class="text-xl font-bold text-white tracking-tight">Menu Catalog</h2>
                    <p class="text-white/60 text-xs mt-1">Select items to add to the cart.</p>
                </div>
                
                <!-- Cart Button -->
                <button @click="cartModalOpen = true" class="relative flex items-center justify-center px-4 py-2 bg-primary hover:bg-primary/90 text-black rounded-xl transition-colors shadow-[0_0_15px_rgba(255,183,3,0.2)] font-bold space-x-2">
                    <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                    <span>View Cart</span>
                    <span x-show="cart.length > 0" class="absolute -top-2 -right-2 bg-error text-white text-[11px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-[#1a1a1a]" x-text="cart.length"></span>
                </button>
            </div>
            
            <div class="flex flex-col gap-4 mt-2">
                <!-- Search -->
                <div class="w-full relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-[18px]">search</span>
                    <input type="text" x-model="searchQuery" placeholder="Search menu..." class="w-full bg-white/5 border border-white/10 rounded-xl pl-9 pr-4 py-2 text-sm text-white placeholder-white/40 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                </div>
                
                <!-- Category Filter -->
                <div class="w-full overflow-x-auto custom-scrollbar flex gap-2 pb-2">
                    <button @click="activeCategory = ''" :class="activeCategory === '' ? 'bg-primary text-black font-bold' : 'bg-white/5 text-white/70 hover:bg-white/10'" class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-colors border border-white/5">All</button>
                    @foreach($categories as $category)
                        <button @click="activeCategory = '{{ $category->slug }}'" :class="activeCategory === '{{ $category->slug }}' ? 'bg-primary text-black font-bold' : 'bg-white/5 text-white/70 hover:bg-white/10'" class="px-4 py-2 rounded-xl text-xs whitespace-nowrap transition-colors border border-white/5">{{ $category->name }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Product Grid -->
        <div class="relative z-10 flex-1 overflow-y-auto custom-scrollbar pb-5">
            <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-4">
                <template x-for="product in filteredProducts" :key="product.id">
                    <div @click="addToCart(product)" class="bg-black/40 border border-white/5 hover:border-primary/50 rounded-xl overflow-hidden cursor-pointer group transition-all duration-300 hover:shadow-[0_0_15px_rgba(255,183,3,0.15)] flex flex-col h-full">
                        <div class="h-32 w-full bg-white/5 relative overflow-hidden">
                            <template x-if="product.image_url">
                                <img :src="product.image_url.startsWith('http') || product.image_url.startsWith('/') ? product.image_url : '/' + product.image_url" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </template>
                            <div x-show="!product.image_url" class="absolute inset-0 flex items-center justify-center">
                                <span class="material-symbols-outlined text-white/20 text-[32px]">restaurant</span>
                            </div>
                            
                            <!-- Stock Badge -->
                            <div class="absolute top-2 right-2 px-2 py-1 bg-black/60 backdrop-blur-md rounded-md border border-white/10">
                                <span class="text-[10px] font-bold" :class="product.stock_quantity <= product.low_stock_threshold ? 'text-amber-500' : 'text-primary'" x-text="product.stock_quantity + ' left'"></span>
                            </div>
                        </div>
                        <div class="p-3 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="text-sm font-bold text-white leading-tight line-clamp-2" x-text="product.name"></h3>
                                <p class="text-[10px] text-white/40 mt-1" x-text="product.category_name"></p>
                            </div>
                            <div class="mt-2 text-primary font-bold text-sm">
                                Rp <span x-text="formatMoney(product.price)"></span>
                            </div>
                        </div>
                    </div>
                </template>
                
                <div x-show="filteredProducts.length === 0" class="col-span-full py-10 flex flex-col items-center justify-center text-white/40">
                    <span class="material-symbols-outlined text-[48px] mb-3">search_off</span>
                    <p class="text-sm">No products found.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Slide-Over Modal -->
    <div x-show="cartModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-hidden">
        <!-- Backdrop -->
        <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" @click="cartModalOpen = false"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

        <!-- Slide-over panel -->
        <div class="fixed inset-y-0 right-0 max-w-md w-full flex">
            <div class="w-full flex flex-col h-full bg-[#1a1a1a] border-l border-white/10 shadow-2xl transform transition ease-in-out duration-300"
                 x-show="cartModalOpen"
                 x-transition:enter="translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="translate-x-0" x-transition:leave-end="translate-x-full">
                
                <!-- Header -->
                <div class="p-5 border-b border-white/10 bg-black/40 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl bg-primary/20 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[20px]">shopping_cart</span>
                        </div>
                        <div>
                            <h2 class="text-lg font-bold text-white">Current Order</h2>
                            <p class="text-[11px] text-white/50" x-text="cart.length + ' items'"></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="clearCart()" x-show="cart.length > 0" class="text-white/40 hover:text-error transition-colors p-2 rounded-lg hover:bg-error/10" title="Clear Cart">
                            <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                        </button>
                        <button @click="cartModalOpen = false" class="text-white/40 hover:text-white transition-colors p-2 rounded-lg hover:bg-white/10" title="Close">
                            <span class="material-symbols-outlined text-[20px]">close</span>
                        </button>
                    </div>
                </div>

                <!-- Customer Name Input -->
                <div class="p-4 border-b border-white/5">
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-white/30 text-[18px]">person</span>
                        <input type="text" x-model="customerName" placeholder="Customer Name / Table No (Optional)" class="w-full bg-white/5 border border-white/10 rounded-xl pl-9 pr-4 py-2.5 text-sm text-white placeholder-white/40 focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="flex-1 overflow-y-auto custom-scrollbar p-4 space-y-3">
                    <template x-for="(item, index) in cart" :key="item.product_id">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 transition-colors">
                            <div class="flex-1 min-w-0 pr-3">
                                <h4 class="text-sm font-bold text-white truncate" x-text="item.name"></h4>
                                <div class="text-xs text-primary font-medium mt-0.5">Rp <span x-text="formatMoney(item.price)"></span></div>
                            </div>
                            
                            <div class="flex items-center space-x-2 bg-black/40 rounded-lg border border-white/10 p-1">
                                <button @click="decreaseQuantity(index)" class="w-7 h-7 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 rounded-md transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">remove</span>
                                </button>
                                <span class="w-6 text-center text-sm font-bold text-white" x-text="item.quantity"></span>
                                <button @click="increaseQuantity(index)" class="w-7 h-7 flex items-center justify-center text-white/70 hover:text-white hover:bg-white/10 rounded-md transition-colors">
                                    <span class="material-symbols-outlined text-[16px]">add</span>
                                </button>
                            </div>
                        </div>
                    </template>
                    
                    <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center text-white/30 py-10">
                        <span class="material-symbols-outlined text-[48px] mb-3 opacity-50">shopping_bag</span>
                        <p class="text-sm font-medium">Cart is empty</p>
                        <p class="text-[10px] mt-1 text-center px-4">Select items from the catalog<br>to start an order.</p>
                    </div>
                </div>

                <!-- Checkout Summary -->
                <div class="p-5 bg-black/60 border-t border-white/10">
                    <div class="space-y-3 mb-5">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-white/60">Subtotal</span>
                            <span class="text-white font-medium">Rp <span x-text="formatMoney(cartTotal)"></span></span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-white/60">Discount / Tax</span>
                            <span class="text-white/40 font-medium">Rp 0</span>
                        </div>
                        <div class="pt-3 border-t border-white/10 flex justify-between items-center">
                            <span class="text-base font-bold text-white">Total</span>
                            <span class="text-xl font-bold text-primary">Rp <span x-text="formatMoney(cartTotal)"></span></span>
                        </div>
                    </div>

                    <button @click="openCheckout()" :disabled="cart.length === 0" :class="cart.length === 0 ? 'opacity-50 cursor-not-allowed bg-white/10 text-white/40' : 'bg-primary hover:bg-primary/90 text-black shadow-[0_0_15px_rgba(255,183,3,0.3)]'" class="w-full py-3.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center space-x-2">
                        <span class="material-symbols-outlined text-[20px]">payments</span>
                        <span>Process Payment</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div x-show="checkoutModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center">
        <!-- Backdrop -->
        <div x-show="checkoutModalOpen" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-black/80 backdrop-blur-md" 
             @click="checkoutModalOpen = false"></div>
        
        <!-- Modal Content -->
        <div x-show="checkoutModalOpen" 
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95"
             class="relative bg-[#1a1a1a] border border-white/10 rounded-2xl w-full max-w-lg shadow-2xl overflow-hidden mx-4 flex flex-col max-h-[90vh]">
            
            <div class="p-6 border-b border-white/10 bg-black/40 flex justify-between items-center shrink-0">
                <h3 class="text-xl font-bold text-white">Complete Payment</h3>
                <button @click="checkoutModalOpen = false" class="text-white/40 hover:text-white transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            
            <div class="p-6 overflow-y-auto custom-scrollbar">
                <!-- Payment Method Selection -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-white/80 mb-3">Payment Method</label>
                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="paymentMethod = 'cash'" :class="paymentMethod === 'cash' ? 'bg-primary/20 border-primary text-primary' : 'bg-white/5 border-white/10 text-white/70 hover:bg-white/10'" class="flex items-center justify-center space-x-2 py-4 rounded-xl border transition-colors font-medium">
                            <span class="material-symbols-outlined text-[20px]">payments</span>
                            <span>Cash</span>
                        </button>
                        <button type="button" @click="paymentMethod = 'qris'" :class="paymentMethod === 'qris' ? 'bg-primary/20 border-primary text-primary' : 'bg-white/5 border-white/10 text-white/70 hover:bg-white/10'" class="flex items-center justify-center space-x-2 py-4 rounded-xl border transition-colors font-medium">
                            <span class="material-symbols-outlined text-[20px]">qr_code_scanner</span>
                            <span>QRIS</span>
                        </button>
                    </div>
                </div>

                <!-- Cash Calculation (Only show if Cash is selected) -->
                <div x-show="paymentMethod === 'cash'" x-collapse>
                    <div class="bg-black/40 rounded-xl p-4 border border-white/5 mb-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-white/60">Total Due</span>
                            <span class="text-lg font-bold text-white">Rp <span x-text="formatMoney(cartTotal)"></span></span>
                        </div>
                        
                        <div class="space-y-1.5">
                            <label class="block text-xs text-white/60">Cash Received</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-white/40 text-sm font-medium">Rp</span>
                                <input type="number" x-model="cashReceived" class="w-full bg-white/5 border border-white/10 rounded-lg pl-9 pr-4 py-2 text-white font-bold focus:outline-none focus:border-primary transition-colors text-right" placeholder="0">
                            </div>
                        </div>

                        <!-- Quick Cash Buttons -->
                        <div class="grid grid-cols-3 gap-2">
                            <button @click="cashReceived = cartTotal" class="py-1.5 bg-white/5 hover:bg-white/10 rounded border border-white/5 text-xs text-white transition-colors">Exact Amount</button>
                            <button @click="addCash(50000)" class="py-1.5 bg-white/5 hover:bg-white/10 rounded border border-white/5 text-xs text-white transition-colors">+50k</button>
                            <button @click="addCash(100000)" class="py-1.5 bg-white/5 hover:bg-white/10 rounded border border-white/5 text-xs text-white transition-colors">+100k</button>
                        </div>

                        <div class="pt-3 border-t border-white/10 flex justify-between items-center">
                            <span class="text-sm text-white/60">Change</span>
                            <span class="text-lg font-bold" :class="changeAmount >= 0 ? 'text-emerald-400' : 'text-error'">
                                Rp <span x-text="formatMoney(changeAmount)"></span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Error Message -->
                <div x-show="errorMessage" class="mb-4 p-3 rounded-lg bg-error/10 border border-error/20 flex items-start space-x-2 text-error">
                    <span class="material-symbols-outlined text-[18px] shrink-0 mt-0.5">error</span>
                    <p class="text-sm leading-tight" x-text="errorMessage"></p>
                </div>
            </div>

            <div class="p-6 border-t border-white/10 bg-black/40 shrink-0">
                <button @click="submitOrder()" :disabled="isSubmitting || (paymentMethod === 'cash' && changeAmount < 0)" :class="(isSubmitting || (paymentMethod === 'cash' && changeAmount < 0)) ? 'opacity-50 cursor-not-allowed bg-white/10 text-white/40' : 'bg-primary hover:bg-primary/90 text-black shadow-[0_0_15px_rgba(255,183,3,0.3)]'" class="w-full py-3.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center space-x-2">
                    <span x-show="isSubmitting" class="material-symbols-outlined animate-spin text-[20px]">refresh</span>
                    <span x-show="!isSubmitting" class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span x-text="isSubmitting ? 'Processing...' : 'Confirm Transaction'"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<script src="{{ config('midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
function posSystem() {
    return {
        // Data
        products: @json($products),
        searchQuery: '',
        activeCategory: '',
        cart: [],
        customerName: '',
        
        // Checkout state
        cartModalOpen: false,
        checkoutModalOpen: false,
        paymentMethod: 'cash',
        cashReceived: '',
        isSubmitting: false,
        errorMessage: '',

        // Computed
        get filteredProducts() {
            return this.products.filter(p => {
                const matchesSearch = p.name.toLowerCase().includes(this.searchQuery.toLowerCase());
                const matchesCategory = this.activeCategory === '' || p.category_slug === this.activeCategory;
                return matchesSearch && matchesCategory;
            });
        },

        get cartTotal() {
            return this.cart.reduce((total, item) => total + (item.price * item.quantity), 0);
        },

        get changeAmount() {
            const cash = parseInt(this.cashReceived) || 0;
            return cash - this.cartTotal;
        },

        // Actions
        addToCart(product) {
            // Check stock
            const existingItem = this.cart.find(i => i.product_id === product.id);
            const currentQty = existingItem ? existingItem.quantity : 0;
            
            if (currentQty >= product.stock_quantity) {
                return;
            }

            if (existingItem) {
                existingItem.quantity++;
            } else {
                this.cart.push({
                    product_id: product.id,
                    name: product.name,
                    price: product.price,
                    stock_quantity: product.stock_quantity,
                    quantity: 1
                });
            }
        },

        increaseQuantity(index) {
            const item = this.cart[index];
            if (item.quantity < item.stock_quantity) {
                item.quantity++;
            }
        },

        decreaseQuantity(index) {
            if (this.cart[index].quantity > 1) {
                this.cart[index].quantity--;
            } else {
                this.cart.splice(index, 1);
            }
        },

        clearCart() {
            if(confirm('Are you sure you want to clear the cart?')) {
                this.cart = [];
                this.customerName = '';
            }
        },

        openCheckout() {
            this.errorMessage = '';
            this.cashReceived = '';
            this.checkoutModalOpen = true;
        },

        addCash(amount) {
            const current = parseInt(this.cashReceived) || 0;
            this.cashReceived = current + amount;
        },

        async submitOrder() {
            if (this.cart.length === 0) return;
            
            this.isSubmitting = true;
            this.errorMessage = '';

            try {
                const response = await fetch('{{ route('admin.pos.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        customer_name: this.customerName,
                        payment_method: this.paymentMethod,
                        items: this.cart.map(i => ({
                            product_id: i.product_id,
                            quantity: i.quantity
                        }))
                    })
                });

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(data.message || 'Validation error');
                }

                if (data.success) {
                    if (data.snap_token) {
                        // Launch Midtrans Snap Popup
                        window.snap.pay(data.snap_token, {
                            onSuccess: (result) => {
                                window.location.href = data.redirect_url;
                            },
                            onPending: (result) => {
                                window.location.href = data.redirect_url;
                            },
                            onError: (result) => {
                                this.errorMessage = "Payment failed!";
                                this.isSubmitting = false;
                            },
                            onClose: () => {
                                this.errorMessage = "Payment window closed by user.";
                                this.isSubmitting = false;
                            }
                        });
                    } else {
                        // Redirect to receipt immediately for Cash
                        window.location.href = data.redirect_url;
                    }
                }
            } catch (error) {
                this.errorMessage = error.message;
                this.isSubmitting = false;
            }
        },

        // Utils
        formatMoney(amount) {
            return new Intl.NumberFormat('id-ID').format(amount);
        }
    }
}
</script>
@endsection
