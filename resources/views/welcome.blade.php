<x-layouts.landing>

    {{--
      ==================================
      ===== HERO "JENIUS" (ROMBAKAN) =====
      ==================================
      (WAH #1: Kita tambahkan 'x-data' dan 'mousemove' untuk 3D Parallax)
    --}}
    <main class="relative min-h-screen overflow-hidden"
          x-data="{ x: 0, y: 0 }"
          @mousemove.window="x = (event.clientX / window.innerWidth) - 0.5; y = (event.clientY / window.innerHeight) - 0.5">

        {{--
          WAH #2: Latar Belakang "KEN BURNS" + "PARALLAX 3D"
          (100% bergerak 'melawan' mouse Anda)
        --}}
        <div class="absolute inset-0 z-0 animate-ken-burns transition-transform duration-300 ease-out"
             :style="{ transform: 'translateX(' + (x * -20) + 'px) translateY(' + (y * -20) + 'px) scale(1.1)' }"
             style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2669&auto=format&fit=crop'); background-size: cover; background-position: center;">
        </div>

        {{--
          WAH #3: Panel "AGGRESSIVE GLASS SHARD"
          (Potongan 100% lebih tajam + border "ciamik")
        --}}
        <div class="absolute inset-0 z-10 w-full lg:w-[65%] bg-black/80 backdrop-blur-lg animate-slide-in-left
                    border-r-2 border-amber-400/30"
             style="clip-path: polygon(0 0, 100% 0, 80% 100%, 0 100%);">
        </div>

        {{--
          WAH #4: KONTEN "PARALLAX 3D" + "STAGGERED"
          (100% bergerak 'mengikuti' mouse Anda + 'staggered' animation)
        --}}
        <div class="relative z-20 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12">

                    {{-- (Kita pakai 7 kolom agar 100% pas di dalam "Shard") --}}
                    <div class="lg:col-span-7 text-center lg:text-left
                                transition-transform duration-300 ease-out"
                         :style="{ transform: 'translateX(' + (x * 40) + 'px) translateY(' + (y * 40) + 'px)' }">

                        {{-- Judul (Animasi "Ciamik" #1) --}}
                        <h1 class="font-serif text-4xl sm:text-6xl lg:text-7xl font-bold text-white leading-tight animate-fade-in-up"
                            style="animation-delay: 0.4s;">
                            Bangun.
                            <span class="text-amber-400">Analisis.</span>
                            Dominasi.
                        </h1>

                        {{-- Paragraf (Animasi "Ciamik" #2) --}}
                        <p class="mt-8 text-base sm:text-lg text-gray-300 max-w-lg mx-auto lg:mx-0 leading-relaxed animate-fade-in-up"
                           style="animation-delay: 0.6s;">
                            Selamat datang di MuscleXpert. Kami adalah sistem analisis Anda, yang mengubah data tubuh
                            menjadi rencana presisi untuk hasil yang nyata.
                        </p>

                        {{-- Tombol (Animasi "Ciamik" #3) --}}
                        <div class="mt-12 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 animate-fade-in-up"
                             style="animation-delay: 0.8s;">
                            <a href="{{ route('register') }}"
                                class="w-full sm:w-auto px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400
                                       hover:bg-amber-300 transition-all duration-300 shadow-lg shadow-amber-500/30
                                       transform hover:scale-105">
                                Mulai Rencana Anda
                            </a>
                            <a href="#features"
                                class="w-full sm:w-auto px-8 py-3 rounded-md text-base font-medium text-white
                                       bg-gray-800/50 hover:bg-gray-700 transition-all duration-300
                                       transform hover:scale-105">
                                Pelajari Metodenya
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-5"></div> {{-- (Kolom kanan 100% kosong) --}}

                </div>
            </div>
        </div>
    </main>

    {{--
      ==================================
      ===== FEATURES (ROMBAKAN "WAH") =====
      ==================================
    --}}
    <section id="features" class="py-20 sm:py-32 bg-black z-10 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center lg:text-left max-w-2xl mx-auto lg:mx-0 animate-fade-in-up">
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                    Metodologi Anda.
                </h2>
                <p class="mt-6 text-base sm:text-lg text-gray-400">
                    Sistem kami dibangun di atas tiga pilar: analisis data presisi, rencana yang dapat dieksekusi, dan
                    pelacakan progres yang terbukti.
                </p>
            </div>

            <div class="mt-20 grid md:grid-cols-3 gap-8">

                {{-- KARTU "MAESTRO" 1 --}}
                <div class="group relative text-center md:text-left animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 md:left-0 md:-translate-x-0 md:-left-4
                                font-serif text-7xl lg:text-9xl font-bold text-gray-800/50 z-0
                                transition-all duration-300 group-hover:text-amber-400/50">01</div>

                    {{-- KARTU KACA "CIAMIK" --}}
                    <div class="relative z-10 bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-lg p-6
                                transition-all duration-300 transform hover:scale-105 hover:border-amber-400/50 shadow-xl">
                        <h3 class="text-xl sm:text-2xl font-bold text-white transition-all duration-300 group-hover:text-amber-400">
                            Kalkulasi Presisi
                        </h3>
                        <p class="mt-4 text-gray-400">
                            Sistem kami menghitung BMR, TDEE, dan kebutuhan makro Anda secara otomatis. Tidak ada lagi
                            tebakan.
                        </p>
                    </div>
                </div>

                {{-- KARTU "MAESTRO" 2 --}}
                <div class="group relative text-center md:text-left animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 md:left-0 md:-translate-x-0 md:-left-4
                                font-serif text-7xl lg:text-9xl font-bold text-gray-800/50 z-0
                                transition-all duration-300 group-hover:text-amber-400/50">02</div>

                    <div class="relative z-10 bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-lg p-6
                                transition-all duration-300 transform hover:scale-105 hover:border-amber-400/50 shadow-xl">
                        <h3 class="text-xl sm:text-2xl font-bold text-white transition-all duration-300 group-hover:text-amber-400">
                            Rencana Tereksekusi
                        </h3>
                        <p class="mt-4 text-gray-400">
                            Akses Workout & Nutrition Plans yang dirancang oleh Admin dan Trainer profesional.
                        </p>
                    </div>
                </div>

                {{-- KARTU "MAESTRO" 3 --}}
                <div class="group relative text-center md:text-left animate-fade-in-up" style="animation-delay: 0.6s;">
                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 md:left-0 md:-translate-x-0 md:-left-4
                                font-serif text-7xl lg:text-9xl font-bold text-gray-800/50 z-0
                                transition-all duration-300 group-hover:text-amber-400/50">03</div>

                    <div class="relative z-10 bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-lg p-6
                                transition-all duration-300 transform hover:scale-105 hover:border-amber-400/50 shadow-xl">
                        <h3 class="text-xl sm:text-2xl font-bold text-white transition-all duration-300 group-hover:text-amber-400">
                            Progres Terbukti
                        </h3>
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
      ===== JOURNAL (ROMBAKAN "WAH") =====
      ==================================
    --}}
    <section class="py-20 sm:py-32 bg-black z-10 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center lg:text-left max-w-2xl mx-auto lg:mx-0 animate-fade-in-up">
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold text-white">
                    The <span class="text-amber-400">Journal</span>
                </h2>
                <p class="mt-6 text-base sm:text-lg text-gray-400">
                    Pengetahuan adalah kekuatan. Pelajari ilmu di balik otot dan nutrisi dari para ahli kami.
                </p>
            </div>

            <div class="mt-20 grid lg:grid-cols-12 gap-x-12 gap-y-16">

                {{-- ARTIKEL UTAMA "CIAMIK" --}}
                <div class="lg:col-span-7 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="relative">

                        {{-- EFEK "ZOOM" WAH --}}
                        <div class="relative group overflow-hidden rounded-lg shadow-2xl">
                            <a href="#" class="block">
                                <img class="w-full h-auto aspect-[16/10] object-cover
                                            transition-all duration-500 ease-in-out group-hover:scale-105"
                                    src="https://images.unsplash.com/photo-1541534741688-6078c6bfb5c5?q=80&w=2669&auto=format&fit=crop"
                                    alt="Latihan beban">
                            </a>
                        </div>

                        {{-- KARTU "MELAYANG" "CIAMIK" --}}
                        <div class="relative lg:-mt-16 lg:ml-8 z-10">
                            <div
                                class="p-6 sm:p-8 bg-black/80 backdrop-blur-lg border border-gray-700/50 rounded-lg shadow-xl">
                                <span
                                    class="text-sm font-medium text-amber-400 uppercase tracking-widest">Nutrisi</span>
                                <a href="#" class="block mt-2">
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

                {{-- LIST ARTIKEL "CIAMIK" --}}
                <div class="lg:col-span-5 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <h4 class="text-xl sm:text-2xl font-serif font-bold text-white">Artikel Terbaru Lainnya</h4>

                    <div class="mt-8 space-y-10">

                        <div class="group relative">
                            <div
                                class="absolute -left-4 -top-2 font-serif text-6xl lg:text-7xl font-bold text-gray-800/50 z-0 opacity-50
                                       transition-all duration-300 group-hover:text-amber-400/50">
                                01</div>
                            <div
                                class="relative z-10 pl-8 border-l-2 border-amber-500/30 group-hover:border-amber-400 transition-all duration-300">
                                <span class="text-sm text-gray-500 uppercase tracking-widest">Latihan</span>
                                <a href="#" class="block mt-1">
                                    <h5
                                        class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-amber-400 transition-all duration-300">
                                        5 Kesalahan Umum Saat Melakukan Deadlift
                                    </h5>
                                </a>
                            </div>
                        </div>

                        <div class="group relative">
                            <div
                                class="absolute -left-4 -top-2 font-serif text-6xl lg:text-7xl font-bold text-gray-800/50 z-0 opacity-50
                                       transition-all duration-300 group-hover:text-amber-400/50">
                                02</div>
                            <div
                                class="relative z-10 pl-8 border-l-2 border-amber-500/30 group-hover:border-amber-400 transition-all duration-300">
                                <span class="text-sm text-gray-500 uppercase tracking-widest">Gaya Hidup</span>
                                <a href="#" class="block mt-1">
                                    <h5
                                        class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-amber-400 transition-all duration-300">
                                        Pentingnya Tidur untuk Pemulihan Otot
                                    </h5>
                                </a>
                            </div>
                        </div>

                        <div class="group relative">
                            <div
                                class="absolute -left-4 -top-2 font-serif text-6xl lg:text-7xl font-bold text-gray-800/50 z-0 opacity-50
                                       transition-all duration-300 group-hover:text-amber-400/50">
                                03</div>
                            <div
                                class="relative z-10 pl-8 border-l-2 border-amber-500/30 group-hover:border-amber-400 transition-all duration-300">
                                <span class="text-sm text-gray-500 uppercase tracking-widest">Suplemen</span>
                                <a href="#" class="block mt-1">
                                    <h5
                                        class="font-serif text-lg sm:text-xl font-bold text-white group-hover:text-amber-400 transition-all duration-300">
                                        Creatine: Mitos vs Fakta "MAESTRO"
                                    </h5>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== CSS "JENIUS" (WAJIB!) =====
      ==================================
      (Anda 100% HARUS menambahkan ini ke <style> Anda)
    --}}
    <style>
        /* WAH #1: Animasi "Ken Burns" (Zoom Ciamik) */
        @keyframes kenBurns {
            0% { transform: scale(1.1) translate(0, 0); }
            100% { transform: scale(1) translate(-5px, -5px); }
        }
        .animate-ken-burns {
            animation: kenBurns 20s ease-out forwards;
        }

        /* WAH #2: Animasi "Slide In" (Panel Kaca) */
        @keyframes slideInLeft {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(0); }
        }
        .animate-slide-in-left {
            animation: slideInLeft 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* WAH #3: Animasi "Staggered Fade In" (Teks & Kartu) */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            opacity: 0; /* Mulai 100% transparan */
            animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            animation-fill-mode: forwards; /* (Pastikan 100% tetap terlihat) */
        }

        /* Tunda animasi untuk "staggering" ciamik */
        main .animate-fade-in-up[style*="animation-delay: 0.4s"] { animation-delay: 0.4s; }
        main .animate-fade-in-up[style*="animation-delay: 0.6s"] { animation-delay: 0.6s; }
        main .animate-fade-in-up[style*="animation-delay: 0.8s"] { animation-delay: 0.8s; }

        #features .animate-fade-in-up[style*="animation-delay: 0.2s"] { animation-delay: 0.2s; }
        #features .animate-fade-in-up[style*="animation-delay: 0.4s"] { animation-delay: 0.4s; }
        #features .animate-fade-in-up[style*="animation-delay: 0.6s"] { animation-delay: 0.6s; }

        section:last-of-type .animate-fade-in-up[style*="animation-delay: 0.2s"] { animation-delay: 0.2s; }
        section:last-of-type .animate-fade-in-up[style*="animation-delay: 0.4s"] { animation-delay: 0.4s; }

        /* Responsif "Ciamik" untuk "Glass Shard" di Mobile */
        @media (max-width: 1023px) {
            main .animate-slide-in-left {
                /* Di mobile, kita 100% tidak pakai 'clip-path' diagonal */
                clip-path: none !important;
                width: 100%;
                /* Kita buat 100% "Full Hero" */
                min-height: 100vh;
                height: 100%;
                /* (FIX: Tambahkan border "ciamik" di bawah) */
                border-r-2: none;
                border-bottom: 2px solid rgba(251, 191, 36, 0.3);
            }
            main .relative.z-20 {
                padding-top: 5rem; /* (Beri nafas di atas) */
                padding-bottom: 5rem; /* (Beri nafas di bawah) */
            }
            /* Di mobile, kita 100% tengahkan semua */
            main .lg\:col-span-7 {
                text-align: center;
            }
            main .lg\:col-span-7 p {
                margin-left: auto;
                margin-right: auto;
            }
            main .lg\:col-span-7 .flex {
                justify-content: center;
            }
        }
    </style>

</x-layouts.landing>
