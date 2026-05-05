<x-app-layout>
    <div class="pt-20">
        <!-- Hero Section -->
        <section class="relative h-[60vh] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img class="w-full h-full object-cover brightness-[0.3]" alt="Coffee Roasting" src="https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?auto=format&fit=crop&q=80&w=2000"/>
                <div class="absolute inset-0 bg-gradient-to-b from-transparent to-background"></div>
            </div>
            <div class="relative z-10 text-center max-w-4xl px-8">
                <h1 class="text-primary mb-6 text-5xl md:text-7xl font-heading font-bold tracking-tight">Our Story</h1>
                <p class="font-sans text-xl text-on-surface-variant max-w-2xl mx-auto">
                    Crafting the future of coffee, one bean at a time.
                </p>
            </div>
        </section>

        <!-- Content Section -->
        <section class="py-24 max-w-5xl mx-auto px-8 space-y-24">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
                <div class="space-y-6">
                    <h2 class="text-3xl font-heading font-bold text-on-surface">The Beginning</h2>
                    <p class="text-on-surface-variant leading-relaxed">
                        Xyro Cafe lahir dari sebuah visi sederhana: menghadirkan kemewahan kopi specialty yang dapat diakses oleh semua orang melalui teknologi. Kami percaya bahwa kopi bukan sekadar minuman, melainkan sebuah ritual yang harus dihargai.
                    </p>
                    <p class="text-on-surface-variant leading-relaxed">
                        Berawal dari sebuah garasi kecil di tahun 2024, kami bereksperimen dengan berbagai teknik roasting untuk menemukan profil rasa yang paling sempurna—yang sekarang dikenal sebagai Signature Aura Blend.
                    </p>
                </div>
                <div class="glass-panel p-4 rounded-3xl overflow-hidden shadow-2xl">
                    <img class="rounded-2xl w-full h-full object-cover" src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&q=80&w=1000" alt="Cafe Founders"/>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-16 items-center md:flex-row-reverse">
                <div class="glass-panel p-4 rounded-3xl overflow-hidden shadow-2xl md:order-2">
                    <img class="rounded-2xl w-full h-full object-cover" src="https://images.unsplash.com/photo-1447933601403-0c6688de566e?auto=format&fit=crop&q=80&w=1000" alt="Sourcing Beans"/>
                </div>
                <div class="space-y-6 md:order-1">
                    <h2 class="text-3xl font-heading font-bold text-on-surface">Our Commitment</h2>
                    <p class="text-on-surface-variant leading-relaxed">
                        Kami bekerja secara langsung dengan petani kopi lokal di seluruh Nusantara. Dengan memotong rantai pasokan yang panjang, kami memastikan petani mendapatkan harga yang adil dan kami mendapatkan biji kopi dengan kualitas tertinggi (skor 90+).
                    </p>
                    <div class="grid grid-cols-2 gap-8 pt-6">
                        <div>
                            <div class="text-primary text-4xl font-bold font-heading">100%</div>
                            <div class="text-on-surface-variant text-sm uppercase tracking-wider mt-1">Ethically Sourced</div>
                        </div>
                        <div>
                            <div class="text-primary text-4xl font-bold font-heading">50+</div>
                            <div class="text-on-surface-variant text-sm uppercase tracking-wider mt-1">Local Farmers</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Experience Banner -->
        <section class="py-24 bg-surface-container-low">
            <div class="max-w-4xl mx-auto px-8 text-center space-y-8">
                <h2 class="text-4xl font-heading font-bold text-on-surface">Experience the Ritual</h2>
                <p class="text-on-surface-variant text-lg">
                    Bergabunglah bersama ribuan pecinta kopi yang telah merasakan perbedaan Xyro.
                </p>
                <a href="{{ route('customer.catalog') }}" class="inline-block px-10 py-4 bg-primary text-on-primary rounded-full font-heading font-semibold hover:scale-105 transition-transform glow-button">
                    Explore Our Menu
                </a>
            </div>
        </section>
    </div>
</x-app-layout>
