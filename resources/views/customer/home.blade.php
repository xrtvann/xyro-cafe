<x-app-layout>
    <!-- Hero Section -->
    <section class="relative h-[870px] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img class="w-full h-full object-cover brightness-[0.4]" alt="Cafe interior" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD79NEAPxpOm38iw9R6OY5kI6nElF-n1FYSRLwg9lxU0tN36upD21C_qo5kcPQX6XinTmuq5TzxvSsp1_HqPkqQWV7U3ZERFIXGIjxkBvmD9h2Q8D3LArCuzPQvK0wXbtSEDCB_mm-2JXT990pWQjddZdKR3RddXmi6VRudk540xEEGMcJClr_l7IBPgFjCPhDuL32L8ke7-wIfgeXEK1f0GAXSS95Bqa2cWF9B5turlFPmb7TibGk6Pfv-cjaXDcDbkJoUc-Eby1C3"/>
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-background/20 to-background"></div>
        </div>
        <div class="relative z-10 text-center max-w-4xl px-gutter">
            <h1 class="text-on-surface mb-6 text-4xl md:text-6xl font-heading font-bold tracking-tight">Elevate Your Coffee Ritual</h1>
            <p class="font-sans text-lg text-on-surface-variant mb-10 max-w-2xl mx-auto">
                Discover the art of the perfect brew. From ethically sourced beans to precision-crafted pastries, Xyro Cafe brings a premium digital-first coffee experience to your doorstep.
            </p>
            <button class="glow-button px-10 py-4 bg-primary-container text-on-primary-container rounded-full font-heading font-semibold hover:scale-105 transition-transform">
                Order Now
            </button>
        </div>
    </section>

    <!-- Menu Catalog Section -->
    <section class="py-24 max-w-7xl mx-auto px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
            <div>
                <h2 class="font-heading text-3xl font-semibold text-primary mb-2">Signature Menu</h2>
                <p class="text-on-surface-variant font-sans">Handcrafted flavors delivered with precision.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button class="px-6 py-2 rounded-full glass-panel text-primary border-primary/40 text-sm font-semibold">All</button>
                <button class="px-6 py-2 rounded-full glass-panel text-on-surface-variant hover:text-primary transition-colors text-sm font-semibold">Coffee</button>
                <button class="px-6 py-2 rounded-full glass-panel text-on-surface-variant hover:text-primary transition-colors text-sm font-semibold">Non-Coffee</button>
                <button class="px-6 py-2 rounded-full glass-panel text-on-surface-variant hover:text-primary transition-colors text-sm font-semibold">Pastry</button>
            </div>
        </div>

        <!-- Menu Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Product 1 -->
            <div class="glass-card rounded-2xl overflow-hidden flex flex-col">
                <div class="h-64 relative overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" alt="Midnight Velvet Latte" src="https://lh3.googleusercontent.com/aida-public/AB6AXuB8DYtH_-HbL5iMjFVnUdmObVKSGlFXkNFCIy9Hnh0hMXfLZuQQ-jbtJ85PqjmC0fCArfmYkNtkFLAvH4-Ry2KnRK8gmfD__NgDh-5OU4bwLDjjX2gH81PBSu98L3QA93tbWg_0p_nDAYcn85sOGSvpmQm0_vqCPpgsLbxkYWiDkr-tYxgDsn1Mxguwi0V1HbwiSBiv9_NUpXcbw_5vjKgBgB_pfe-_JHJ4VcBcnzKUmbFZQVTLOzoW-3Y767wYOZnmJnRwV81Jnx6D"/>
                    <div class="absolute top-4 left-4 glass-panel px-3 py-1 rounded-full text-[12px] font-bold text-primary uppercase tracking-wider">Popular</div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-heading text-xl font-semibold text-on-surface">Midnight Velvet Latte</h3>
                        <div class="text-right">
                            <span class="text-primary font-bold block">Rp 35.000</span>
                            <span class="text-on-surface-variant text-[12px] font-medium">Stock: 12</span>
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 flex-grow font-sans">A deep espresso blend with activated charcoal and vanilla bean silk.</p>
                    <button class="w-full py-3 bg-primary-container/20 border border-primary/30 text-primary rounded-xl font-semibold hover:bg-primary-container hover:text-on-primary-container transition-all">
                        Add to Cart
                    </button>
                </div>
            </div>

            <!-- Product 2 (Out of Stock) -->
            <div class="glass-card rounded-2xl overflow-hidden flex flex-col opacity-80">
                <div class="h-64 relative overflow-hidden grayscale-[0.5]">
                    <img class="w-full h-full object-cover" alt="Gold-Leaf Brioche" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAB9tZV7YupQLRvJYOYQIsHqglR-i6uEGJnW2rtoCMsrFQGmKF1pqXTdHG-y3Y2-mncF0xFFnOQ1bK7nx07LPzjQKxwJW6QBvQv-jIlTJH_p4JlMn2P0STerCLn4pDSrfib9nuPQgCLj89cAlDuJlCtykdhAMI2loMiiuD1hiBlk9V8XyM0qltfi7V8l9ctobamgyo_jc7qr_zhBothSzBQ8mV5EP0hju_ibp70hsr_2q6lUzn68quj_huKkBx4Vpeuv0TvfPWOsoCB"/>
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <span class="bg-error-container text-on-error-container px-4 py-1 rounded-full font-bold text-sm">Stok Habis</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-heading text-xl font-semibold text-on-surface">Gold-Leaf Brioche</h3>
                        <div class="text-right">
                            <span class="text-on-surface-variant font-bold line-through block">Rp 45.000</span>
                            <span class="text-error text-[12px] font-medium">Stock: 0</span>
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 flex-grow font-sans">Hand-kneaded brioche infused with saffron and topped with 24k gold flakes.</p>
                    <button class="w-full py-3 bg-neutral-700 text-on-surface/50 rounded-xl font-semibold cursor-not-allowed opacity-50 pointer-events-none" disabled>
                        Out of Stock
                    </button>
                </div>
            </div>

            <!-- Product 3 -->
            <div class="glass-card rounded-2xl overflow-hidden flex flex-col">
                <div class="h-64 relative overflow-hidden">
                    <img class="w-full h-full object-cover hover:scale-110 transition-transform duration-500" alt="Amber Quartz Cold" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCU3gd8lTMr759R6BorIdU7c3ZxREeuBrDjS9-YwCPZQGQMJCVU-AZvMhNJlRPFG0Sby3Mxu2X8K01-OLp2ah8ujNCjIGEg9x9i1CP-vrRJMKwbtu0e6aOtfvKWCRRoJ0DfXZAa8Y4mCnZxiYihwOT0jQ78gVQDVjhmlDLKwK9_2oBXZvpaMXad2_74_Yb47ORfIcANbji8Co1gviR3Z_aDxFwRGPF7d3y85GmawhradL9Soa1YW9eDm-AAFlSuRNvXtmsyvYWQ8weu"/>
                    <div class="absolute top-4 left-4 glass-panel px-3 py-1 rounded-full text-[12px] font-bold text-primary uppercase tracking-wider">Cold Brew</div>
                </div>
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-heading text-xl font-semibold text-on-surface">Amber Quartz Cold</h3>
                        <div class="text-right">
                            <span class="text-primary font-bold block">Rp 28.000</span>
                            <span class="text-on-surface-variant text-[12px] font-medium">Stock: 8</span>
                        </div>
                    </div>
                    <p class="text-on-surface-variant text-sm mb-6 flex-grow font-sans">18-hour steep cold brew with notes of nectarine and toasted almond.</p>
                    <button class="w-full py-3 bg-primary-container/20 border border-primary/30 text-primary rounded-xl font-semibold hover:bg-primary-container hover:text-on-primary-container transition-all">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Xyro? Section -->
    <section class="py-24 bg-surface-container-lowest">
        <div class="max-w-7xl mx-auto px-8">
            <div class="text-center mb-16">
                <h2 class="text-on-surface mb-4 text-2xl font-bold font-heading">Why Choose Xyro?</h2>
                <div class="h-1 w-20 bg-primary mx-auto rounded-full"></div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center p-8 glass-panel rounded-3xl">
                    <div class="w-16 h-16 bg-primary-container/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-primary text-3xl">auto_awesome</span>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-on-surface mb-4">Exceptional Quality</h3>
                    <p class="text-on-surface-variant font-sans">We partner with single-estate farms to ensure every bean meets our rigorous 90+ score standard.</p>
                </div>
                <div class="text-center p-8 glass-panel rounded-3xl">
                    <div class="w-16 h-16 bg-primary-container/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-primary text-3xl">bolt</span>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-on-surface mb-4">Swift Delivery</h3>
                    <p class="text-on-surface-variant font-sans">Our smart routing system ensures your coffee arrives at the peak of its flavor window, every time.</p>
                </div>
                <div class="text-center p-8 glass-panel rounded-3xl">
                    <div class="w-16 h-16 bg-primary-container/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <span class="material-symbols-outlined text-primary text-3xl">payments</span>
                    </div>
                    <h3 class="font-heading text-xl font-semibold text-on-surface mb-4">Seamless Payment</h3>
                    <p class="text-on-surface-variant font-sans">One-tap checkout with crypto, digital wallets, or traditional cards for a frictionless experience.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="py-24 max-w-4xl mx-auto px-8">
        <h2 class="text-on-surface mb-12 text-center text-2xl font-bold font-heading">Frequently Asked Questions</h2>
        <div class="space-y-4 font-sans">
            <div class="glass-card p-6 rounded-2xl">
                <button class="w-full flex justify-between items-center text-left focus:outline-none">
                    <span class="font-semibold text-on-surface">How do you ensure bean freshness?</span>
                    <span class="material-symbols-outlined text-primary">expand_more</span>
                </button>
                <div class="mt-4 text-on-surface-variant text-sm border-t border-white/5 pt-4">
                    Our beans are roasted in small batches daily. Each bag is nitro-sealed within 30 minutes of roasting to lock in the volatile aromatic compounds.
                </div>
            </div>
            <div class="glass-card p-6 rounded-2xl">
                <button class="w-full flex justify-between items-center text-left focus:outline-none">
                    <span class="font-semibold text-on-surface">Can I subscribe for regular deliveries?</span>
                    <span class="material-symbols-outlined text-primary">expand_more</span>
                </button>
                <div class="hidden mt-4 text-on-surface-variant text-sm border-t border-white/5 pt-4">
                    Yes! You can choose the frequency, roast type, and quantity through your Xyro dashboard at any time.
                </div>
            </div>
            <div class="glass-card p-6 rounded-2xl">
                <button class="w-full flex justify-between items-center text-left focus:outline-none">
                    <span class="font-semibold text-on-surface">What is your delivery range?</span>
                    <span class="material-symbols-outlined text-primary">expand_more</span>
                </button>
                <div class="hidden mt-4 text-on-surface-variant text-sm border-t border-white/5 pt-4">
                    We currently deliver within a 25-mile radius of our flagship locations, ensuring your drinks stay at the perfect temperature.
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
