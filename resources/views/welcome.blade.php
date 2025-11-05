<x-layouts.landing>

    {{--
      ==================================
      ===== HERO SECTION (ROMBAKAN) =====
      ==================================
    --}}
    <main class="relative overflow-hidden">
        <div class="relative min-h-screen flex items-center pt-16 pb-20">
            {{--
              Kita gunakan 1-kolom di mobile, dan 12-kolom di desktop.
              Kita tambahkan 'items-center' agar 100% "apik".
            --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-16 items-center">

                {{--
                  ==================================
                  ===== Teks (Child 1) =====
                  ==================================
                  (Di mobile, 'order-last' = di bawah gambar)
                  (Di desktop, 'lg:order-first' = di kiri)
                --}}
                <div class="z-10 lg:col-span-7 order-last lg:order-first text-center lg:text-left">
                    {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                    <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold text-white">
                        Bangun.
                        <span class="text-amber-400">Analisis.</span>
                        Dominasi.
                    </h1>
                    {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                    <p class="mt-8 text-base sm:text-lg text-gray-300 max-w-lg mx-auto lg:mx-0">
                        Selamat datang di MuscleXpert. Kami adalah sistem analisis Anda, yang mengubah data tubuh
                        menjadi rencana presisi untuk hasil yang nyata.
                    </p>
                    <div class="mt-12 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}"
                            class="w-full sm:w-auto px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                            Mulai Rencana Anda
                        </a>
                        <a href="#features"
                            class="w-full sm:w-auto px-8 py-3 rounded-md text-base font-medium text-white bg-gray-800/50 hover:bg-gray-700 transition-all">
                            Pelajari Metodenya
                        </a>
                    </div>
                </div>

                {{--
                  ==================================
                  ===== Gambar (Child 2) =====
                  ==================================
                  (Di mobile, 'order-first' = di atas teks)
                  (Di desktop, 'lg:order-last' = di kanan)
                --}}
                <div class="lg:col-span-5 order-first lg:order-last w-full">
                    {{-- (FIX: Tinggi gambar di mobile 100% ditambah agar "ciamik") --}}
                    <div class="w-full h-80 sm:h-96 lg:h-[600px] rounded-lg shadow-2xl"
                        style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2669&auto=format&fit=crop'); background-size: cover; background-position: center; opacity: 0.3;">
                    </div>
                </div>
            </div>
        </div>
    </main>

    {{--
      ==================================
      ===== FEATURES (ROMBAKAN FONT) =====
      ==================================
    --}}
    <section id="features" class="py-20 sm:py-32 bg-black z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center lg:text-left max-w-2xl mx-auto lg:mx-0">
                {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                    Metodologi Anda.
                </h2>
                <p class="mt-6 text-base sm:text-lg text-gray-400">
                    Sistem kami dibangun di atas tiga pilar: analisis data presisi, rencana yang dapat dieksekusi, dan
                    pelacakan progres yang terbukti.
                </p>
            </div>

            <div class="mt-20 grid md:grid-cols-3 gap-12">

                <div class="relative text-center md:text-left">
                    {{-- (FIX: Font '01' 100% dikecilkan di mobile) --}}
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 md:left-0 md:-translate-x-0 md:-left-4 font-serif text-7xl lg:text-9xl font-bold text-gray-800/50 z-0">01</div>
                    <div class="relative z-10">
                        <h3 class="text-xl sm:text-2xl font-bold text-white">Kalkulasi Presisi</h3>
                        <p class="mt-4 text-gray-400">
                            Sistem kami menghitung BMR, TDEE, dan kebutuhan makro Anda secara otomatis. Tidak ada lagi
                            tebakan.
                        </p>
                    </div>
                </div>

                <div class="relative text-center md:text-left">
                    {{-- (FIX: Font '02' 100% dikecilkan di mobile) --}}
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 md:left-0 md:-translate-x-0 md:-left-4 font-serif text-7xl lg:text-9xl font-bold text-gray-800/50 z-0">02</div>
                    <div class="relative z-10">
                        <h3 class="text-xl sm:text-2xl font-bold text-white">Rencana Tereksekusi</h3>
                        <p class="mt-4 text-gray-400">
                            Akses Workout & Nutrition Plans yang dirancang oleh Admin dan Trainer profesional.
                        </p>
                    </div>
                </div>

                <div class="relative text-center md:text-left">
                    {{-- (FIX: Font '03' 100% dikecilkan di mobile) --}}
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 md:left-0 md:-translate-x-0 md:-left-4 font-serif text-7xl lg:text-9xl font-bold text-gray-800/50 z-0">03</div>
                    <div class="relative z-10">
                        <h3 class="text-xl sm:text-2xl font-bold text-white">Progres Terbukti</h3>
                        <p class="mt-4 text-gray-400">
                            Lacak setiap aspek kemajuan Anda, dari <code>Body Metrics</code> hingga
                            <code>Progress Logs</code> harian.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== JOURNAL (ROMBAKAN FONT) =====
      ==================================
    --}}
    <section class="py-20 sm:py-32 bg-black z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center lg:text-left max-w-2xl mx-auto lg:mx-0">
                {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                    The <span class="text-amber-400">Journal</span>
                </h2>
                <p class="mt-6 text-base sm:text-lg text-gray-400">
                    Pengetahuan adalah kekuatan. Pelajari ilmu di balik otot dan nutrisi dari para ahli kami.
                </p>
            </div>

            <div class="mt-20 grid lg:grid-cols-12 gap-x-12 gap-y-16">

                <div class="lg:col-span-7">
                    <div class="relative">
                        <a href="#" class="block">
                            <img class="w-full h-auto aspect-[16/10] object-cover rounded-lg shadow-2xl"
                                src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=2669&auto=format&fit=crop"
                                alt="Latihan beban">
                        </a>

                        <div class="relative lg:-mt-16 lg:ml-8 z-10">
                            <div
                                class="p-6 sm:p-8 bg-black/80 backdrop-blur-lg border border-gray-700/50 rounded-lg shadow-xl">
                                <span
                                    class="text-sm font-medium text-amber-400 uppercase tracking-widest">Nutrisi</span>
                                <a href="#" class="block mt-2">
                                    {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                                    <h3
                                        class="font-serif text-2xl sm:text-3xl font-bold text-white hover:text-gray-200 transition-colors">
                                        Pentingnya Protein: Kapan & Berapa Banyak?
                                    </h3>
                                </a>
                                <p class="mt-4 text-gray-400">
                                    Memahami asupan protein sangat krusial. Sistem kami membantu melacak ini, tapi
                                    inilah ilmu di balik mengapa Anda membutuhkannya...
                                </p>
                                <a href="{{ route('public.articles.index') }}"
                                    class="mt-6 inline-block font-bold text-amber-400 hover:text-amber-300 transition-colors">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                    <h4 class="text-xl sm:text-2xl font-serif font-bold text-white">Artikel Terbaru Lainnya</h4>

                    <div class="mt-8 space-y-10">

                        <div class="group relative">
                            {{-- (FIX: Font '01' 100% dikecilkan di mobile) --}}
                            <div
                                class="absolute -left-4 -top-2 font-serif text-6xl lg:text-7xl font-bold text-gray-800/50 z-0 opacity-50">
                                01</div>
                            <div
                                class="relative z-10 pl-8 border-l-2 border-amber-500/30 group-hover:border-amber-400 transition-all duration-300">
                                <span class="text-sm text-gray-500 uppercase tracking-widest">Latihan</span>
                                <a href="#" class="block mt-1">
                                    {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                                    <h5
                                        class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-amber-400 transition-all duration-300">
                                        5 Kesalahan Umum Saat Melakukan Deadlift
                                    </h5>
                                </a>
                            </div>
                        </div>

                        <div class="group relative">
                            {{-- (FIX: Font '02' 100% dikecilkan di mobile) --}}
                            <div
                                class="absolute -left-4 -top-2 font-serif text-6xl lg:text-7xl font-bold text-gray-800/50 z-0 opacity-50">
                                02</div>
                            <div
                                class="relative z-10 pl-8 border-l-2 border-amber-500/30 group-hover:border-amber-400 transition-all duration-300">
                                <span class="text-sm text-gray-500 uppercase tracking-widest">Gaya Hidup</span>
                                <a href="#" class="block mt-1">
                                    {{-- (FIX: Font 100% dikecilkan di mobile) --}}
                                    <h5
                                        class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-amber-400 transition-all duration-300">
                                        Pentingnya Tidur untuk Pemulihan Otot
                                    </h5>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

</x-layouts.landing>
