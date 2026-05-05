<x-app-layout>
    <div class="pt-32 pb-24 max-w-4xl mx-auto px-8">
        <!-- Header -->
        <div class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-heading font-bold text-on-surface mb-6">Frequently Asked Questions</h1>
            <p class="text-on-surface-variant text-lg max-w-2xl mx-auto">Punya pertanyaan tentang layanan kami? Cari jawaban cepat di sini atau hubungi tim dukungan kami.</p>
        </div>

        <!-- Search Bar -->
        <div class="relative mb-12 group">
            <span class="material-symbols-outlined absolute left-6 top-1/2 -translate-y-1/2 text-primary text-2xl">search</span>
            <input type="text" placeholder="Bagaimana cara memesan?" class="w-full pl-16 pr-8 py-5 bg-white/5 border border-white/10 rounded-3xl text-on-surface text-lg focus:outline-none focus:border-primary/50 focus:bg-white/10 transition-all font-sans">
        </div>

        <!-- FAQ Categories -->
        <div class="space-y-6" x-data="{ active: null }">
            <!-- FAQ Item 1 -->
            <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
                <button 
                    @click="active = (active === 1 ? null : 1)"
                    class="w-full p-8 flex items-center justify-between text-left transition-colors hover:bg-white/5"
                    :class="active === 1 ? 'bg-white/5' : ''"
                >
                    <span class="text-xl font-heading font-semibold text-on-surface">Bagaimana cara memastikan kesegaran biji kopi?</span>
                    <span class="material-symbols-outlined text-primary transition-transform duration-300" :class="active === 1 ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div 
                    x-show="active === 1" 
                    x-collapse
                    class="p-8 pt-0 text-on-surface-variant leading-relaxed font-sans border-t border-white/5 mt-[-1px]"
                >
                    Biji kopi kami dipanggang dalam batch kecil setiap hari di roastery lokal kami. Setiap kantong disegel dengan nitrogen dalam waktu 30 menit setelah pemanggangan untuk mengunci senyawa aromatik yang mudah menguap, memastikan Anda mendapatkan rasa terbaik saat sampai di rumah.
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
                <button 
                    @click="active = (active === 2 ? null : 2)"
                    class="w-full p-8 flex items-center justify-between text-left transition-colors hover:bg-white/5"
                    :class="active === 2 ? 'bg-white/5' : ''"
                >
                    <span class="text-xl font-heading font-semibold text-on-surface">Apakah saya bisa berlangganan untuk pengiriman rutin?</span>
                    <span class="material-symbols-outlined text-primary transition-transform duration-300" :class="active === 2 ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div 
                    x-show="active === 2" 
                    x-collapse
                    class="p-8 pt-0 text-on-surface-variant leading-relaxed font-sans border-t border-white/5 mt-[-1px]"
                >
                    Tentu saja! Anda dapat memilih frekuensi pengiriman (mingguan, dua mingguan, atau bulanan), jenis panggangan, dan jumlah melalui dashboard Xyro Anda. Pelanggan langganan juga mendapatkan diskon eksklusif 15% untuk setiap pesanan.
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
                <button 
                    @click="active = (active === 3 ? null : 3)"
                    class="w-full p-8 flex items-center justify-between text-left transition-colors hover:bg-white/5"
                    :class="active === 3 ? 'bg-white/5' : ''"
                >
                    <span class="text-xl font-heading font-semibold text-on-surface">Berapa jangkauan pengiriman Xyro Cafe?</span>
                    <span class="material-symbols-outlined text-primary transition-transform duration-300" :class="active === 3 ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div 
                    x-show="active === 3" 
                    x-collapse
                    class="p-8 pt-0 text-on-surface-variant leading-relaxed font-sans border-t border-white/5 mt-[-1px]"
                >
                    Saat ini kami melayani pengiriman instan dalam radius 25 km dari lokasi gerai unggulan kami untuk memastikan minuman tetap pada suhu yang sempurna. Untuk biji kopi (whole bean) dan peralatan kopi, kami melayani pengiriman ke seluruh wilayah Indonesia.
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="glass-card rounded-3xl overflow-hidden border border-white/5">
                <button 
                    @click="active = (active === 4 ? null : 4)"
                    class="w-full p-8 flex items-center justify-between text-left transition-colors hover:bg-white/5"
                    :class="active === 4 ? 'bg-white/5' : ''"
                >
                    <span class="text-xl font-heading font-semibold text-on-surface">Apa saja metode pembayaran yang diterima?</span>
                    <span class="material-symbols-outlined text-primary transition-transform duration-300" :class="active === 4 ? 'rotate-180' : ''">expand_more</span>
                </button>
                <div 
                    x-show="active === 4" 
                    x-collapse
                    class="p-8 pt-0 text-on-surface-variant leading-relaxed font-sans border-t border-white/5 mt-[-1px]"
                >
                    Kami menerima berbagai metode pembayaran digital termasuk QRIS, GoPay, OVO, Dana, serta kartu kredit/debit melalui gerbang pembayaran Midtrans yang aman. Kami juga mendukung pembayaran dengan beberapa aset kripto terpilih.
                </div>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="mt-20 glass-panel p-12 rounded-[3rem] text-center border border-white/10">
            <h3 class="text-2xl font-heading font-bold text-on-surface mb-4">Masih butuh bantuan?</h3>
            <p class="text-on-surface-variant mb-8">Tim dukungan pelanggan kami siap membantu Anda setiap hari dari pukul 08:00 hingga 22:00 WIB.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#" class="w-full sm:w-auto px-10 py-4 bg-primary text-on-primary rounded-full font-heading font-bold glow-button transition-transform hover:scale-105">Hubungi Kami</a>
                <a href="#" class="w-full sm:w-auto px-10 py-4 glass-panel text-white font-heading font-bold rounded-full hover:bg-white/10 transition-all border border-white/10">Email Support</a>
            </div>
        </div>
    </div>
</x-app-layout>
