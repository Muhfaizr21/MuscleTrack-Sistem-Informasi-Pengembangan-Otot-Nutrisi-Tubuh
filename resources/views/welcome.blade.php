<x-layouts.landing>

    {{--
      ==================================
      ===== HERO SECTION - MODERN FITNESS =====
      ==================================
    --}}
    <main class="relative min-h-screen overflow-hidden" x-data="{ x: 0, y: 0 }"
        @mousemove.window="x = (event.clientX / window.innerWidth) - 0.5; y = (event.clientY / window.innerHeight) - 0.5">

        {{-- Background dengan Parallax 3D --}}
        <div class="absolute inset-0 z-0 animate-ken-burns transition-transform duration-300 ease-out"
            :style="{ transform: 'translateX(' + (x * -20) + 'px) translateY(' + (y * -20) + 'px) scale(1.1)' }" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                    background-image: 
                        radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                        url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop');
                    background-size: cover;
                    background-position: center;
                    background-blend-mode: overlay;">
        </div>

        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 z-5 bg-gradient-to-br from-slate-900/95 via-slate-900/90 to-transparent"></div>

        {{-- Animated Grid Pattern --}}


        {{-- Glass Panel Aggressive --}}
        <div class="absolute inset-0 z-10 w-full lg:w-[70%] bg-gradient-to-br from-slate-900/85 via-slate-800/80 to-transparent
                    backdrop-blur-xl animate-slide-in-left border-r-4 border-green-500/40 shadow-2xl shadow-green-500/20"
            style="clip-path: polygon(0 0, 100% 0, 85% 100%, 0 100%);">
        </div>

        {{-- Content with 3D Parallax --}}
        <div class="relative z-20 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

                    <div class="lg:col-span-7 text-center lg:text-left space-y-8
                                transition-transform duration-300 ease-out"
                        :style="{ transform: 'translateX(' + (x * 40) + 'px) translateY(' + (y * 40) + 'px)' }">

                        {{-- Badge Premium --}}
                        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-green-500/10 border border-green-500/30 backdrop-blur-sm animate-fade-in-up"
                            style="animation-delay: 0.2s;">
                            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                            <span class="text-sm font-bold text-green-400 uppercase tracking-wider">AI-Powered Fitness
                                Platform</span>
                        </div>

                        {{-- Main Heading --}}
                        <h1 class="font-bold text-5xl sm:text-6xl lg:text-7xl xl:text-8xl text-white leading-tight animate-fade-in-up"
                            style="animation-delay: 0.4s; text-shadow: 0 0 40px rgba(34, 197, 94, 0.3);">
                            <span
                                class="bg-gradient-to-r from-green-400 via-emerald-500 to-blue-500 bg-clip-text text-transparent">
                                Transform
                            </span>
                            <br>Your Body.
                            <br>
                            <span class="text-4xl sm:text-5xl lg:text-6xl text-gray-300">
                                Dominate Results.
                            </span>
                        </h1>

                        {{-- Description --}}
                        <p class="text-lg sm:text-xl text-gray-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed animate-fade-in-up"
                            style="animation-delay: 0.6s;">
                            Platform fitness berbasis AI yang menganalisis data tubuh Anda dan menciptakan program
                            latihan & nutrisi personal untuk hasil maksimal.
                        </p>

                        {{-- Stats Bar --}}
                        <div class="flex flex-wrap items-center justify-center lg:justify-start gap-8 animate-fade-in-up"
                            style="animation-delay: 0.7s;">
                            <div class="text-center lg:text-left">
                                <div class="text-3xl font-bold text-green-400">10K+</div>
                                <div class="text-sm text-gray-400">Active Members</div>
                            </div>
                            <div class="w-px h-12 bg-gray-700"></div>
                            <div class="text-center lg:text-left">
                                <div class="text-3xl font-bold text-blue-400">50+</div>
                                <div class="text-sm text-gray-400">Expert Trainers</div>
                            </div>
                            <div class="w-px h-12 bg-gray-700"></div>
                            <div class="text-center lg:text-left">
                                <div class="text-3xl font-bold text-emerald-400">95%</div>
                                <div class="text-sm text-gray-400">Success Rate</div>
                            </div>
                        </div>

                        {{-- CTA Buttons --}}
                        <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 animate-fade-in-up"
                            style="animation-delay: 0.8s;">
                            <a href="{{ route('register') }}" class="group relative w-full sm:w-auto px-8 py-4 rounded-xl text-base font-bold text-white
                                       bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                                       transition-all duration-300 shadow-lg shadow-green-500/50 hover:shadow-green-500/70
                                       transform hover:scale-105 hover:-translate-y-1 overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Mulai Transformasi
                                </span>
                                <div
                                    class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-700 transform translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                </div>
                            </a>
                            <a href="#features" class="group w-full sm:w-auto px-8 py-4 rounded-xl text-base font-bold text-white
                                       bg-slate-800/50 hover:bg-slate-700/50 border-2 border-green-500/30 hover:border-green-500
                                       backdrop-blur-sm transition-all duration-300 transform hover:scale-105 hover:-translate-y-1
                                       flex items-center justify-center gap-2">
                                <span>Lihat Fitur</span>
                                <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <div class="lg:col-span-5"></div>

                </div>
            </div>
        </div>

        {{-- Floating Elements --}}
        <div class="absolute top-20 right-10 w-20 h-20 bg-green-500/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-40 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl animate-float-delayed">
        </div>
    </main>

    {{--
      ==================================
      ===== FEATURES SECTION =====
      ==================================
    --}}
    <section id="features" class="relative py-20 sm:py-32 bg-slate-950 overflow-hidden">



        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
                <span
                    class="inline-block px-4 py-2 rounded-full bg-green-500/10 border border-green-500/30 text-sm font-bold text-green-400 uppercase tracking-wider mb-4">
                    Powered by AI Technology
                </span>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                    Sistem <span
                        class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Cerdas</span>
                    untuk Hasil Nyata
                </h2>
                <p class="text-lg text-gray-400">
                    Platform kami menggunakan teknologi AI untuk menganalisis tubuh Anda dan menciptakan program yang
                    100% personal dan efektif.
                </p>
            </div>

            {{-- Features Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                {{-- Feature Card 1 --}}
                <div class="group relative animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-green-500 to-emerald-600 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-500">
                    </div>
                    <div
                        class="relative h-full bg-slate-900 rounded-2xl p-8 border border-slate-800 hover:border-green-500/50 transition-all duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-green-400 transition-colors">
                            Analisis AI Presisi
                        </h3>
                        <p class="text-gray-400 leading-relaxed">
                            Sistem AI kami menghitung BMR, TDEE, dan kebutuhan makro secara akurat berdasarkan data
                            tubuh Anda.
                        </p>
                    </div>
                </div>

                {{-- Feature Card 2 --}}
                <div class="group relative animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-blue-500 to-cyan-600 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-500">
                    </div>
                    <div
                        class="relative h-full bg-slate-900 rounded-2xl p-8 border border-slate-800 hover:border-blue-500/50 transition-all duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-blue-400 transition-colors">
                            Program Personal
                        </h3>
                        <p class="text-gray-400 leading-relaxed">
                            Akses workout & nutrition plans yang dirancang khusus oleh trainer profesional untuk tujuan
                            Anda.
                        </p>
                    </div>
                </div>

                {{-- Feature Card 3 --}}
                <div class="group relative animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-emerald-500 to-teal-600 rounded-2xl opacity-0 group-hover:opacity-100 blur transition-all duration-500">
                    </div>
                    <div
                        class="relative h-full bg-slate-900 rounded-2xl p-8 border border-slate-800 hover:border-emerald-500/50 transition-all duration-300 transform hover:-translate-y-2">
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform duration-300">
                            <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4 group-hover:text-emerald-400 transition-colors">
                            Tracking Real-Time
                        </h3>
                        <p class="text-gray-400 leading-relaxed">
                            Monitor progress Anda secara real-time dengan body metrics, workout logs, dan nutrition
                            tracking.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== JOURNAL SECTION =====
      ==================================
    --}}
    <section class="relative py-20 sm:py-32 bg-slate-900 overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900"></div>
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-green-500/5 blur-[150px] rounded-full"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
                <span
                    class="inline-block px-4 py-2 rounded-full bg-blue-500/10 border border-blue-500/30 text-sm font-bold text-blue-400 uppercase tracking-wider mb-4">
                    Knowledge Base
                </span>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                    Fitness <span
                        class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">Journal</span>
                </h2>
                <p class="text-lg text-gray-400">
                    Tingkatkan pengetahuan fitness Anda dengan artikel dari expert trainer dan nutritionist profesional.
                </p>
            </div>

            <div class="grid lg:grid-cols-12 gap-12">

                {{-- Featured Article --}}
                <div class="lg:col-span-7 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="group relative overflow-hidden rounded-2xl">
                        {{-- Image with Overlay --}}
                        <div class="relative overflow-hidden rounded-2xl">
                            <img class="w-full h-[400px] object-cover transition-transform duration-700 ease-out group-hover:scale-110"
                                src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop"
                                alt="Fitness Training">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent">
                            </div>
                        </div>

                        {{-- Content Card --}}
                        <div
                            class="relative lg:absolute lg:bottom-0 lg:left-0 lg:right-0 p-8 bg-slate-900/95 backdrop-blur-xl border-t-4 border-green-500">
                            <span
                                class="inline-block px-3 py-1 rounded-full bg-green-500/20 text-green-400 text-xs font-bold uppercase tracking-wider mb-4">
                                Nutrition Science
                            </span>
                            <a href="#" class="block group/link">
                                <h3
                                    class="text-3xl font-bold text-white mb-4 group-hover/link:text-green-400 transition-colors">
                                    Protein Timing: Science Behind Muscle Growth
                                </h3>
                            </a>
                            <p class="text-gray-400 mb-6 leading-relaxed">
                                Memahami kapan dan berapa banyak protein yang dibutuhkan tubuh Anda adalah kunci untuk
                                pertumbuhan otot optimal...
                            </p>
                            <a href="{{ route('public.articles.index') }}"
                                class="inline-flex items-center gap-2 font-bold text-green-400 hover:text-green-300 transition-colors group/read">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-5 h-5 transform group-hover/read:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Article List --}}
                <div class="lg:col-span-5 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <h4 class="text-2xl font-bold text-white mb-8 flex items-center gap-3">
                        <span class="w-1 h-8 bg-gradient-to-b from-green-500 to-blue-500 rounded-full"></span>
                        Latest Articles
                    </h4>

                    <div class="space-y-6">

                        {{-- Article Item 1 --}}
                        <a href="#"
                            class="group block p-6 bg-slate-800/50 hover:bg-slate-800 rounded-xl border border-slate-700 hover:border-green-500/50 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl font-bold text-green-400">01</span>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 uppercase tracking-wider">Workout Tips</span>
                                    <h5
                                        class="text-lg font-bold text-white group-hover:text-green-400 transition-colors mt-1">
                                        5 Common Deadlift Mistakes to Avoid
                                    </h5>
                                </div>
                            </div>
                        </a>

                        {{-- Article Item 2 --}}
                        <a href="#"
                            class="group block p-6 bg-slate-800/50 hover:bg-slate-800 rounded-xl border border-slate-700 hover:border-blue-500/50 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl font-bold text-blue-400">02</span>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 uppercase tracking-wider">Recovery</span>
                                    <h5
                                        class="text-lg font-bold text-white group-hover:text-blue-400 transition-colors mt-1">
                                        Sleep Quality for Optimal Muscle Recovery
                                    </h5>
                                </div>
                            </div>
                        </a>

                        {{-- Article Item 3 --}}
                        <a href="#"
                            class="group block p-6 bg-slate-800/50 hover:bg-slate-800 rounded-xl border border-slate-700 hover:border-emerald-500/50 transition-all duration-300">
                            <div class="flex items-start gap-4">
                                <div
                                    class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl font-bold text-emerald-400">03</span>
                                </div>
                                <div class="flex-1">
                                    <span class="text-xs text-gray-500 uppercase tracking-wider">Supplements</span>
                                    <h5
                                        class="text-lg font-bold text-white group-hover:text-emerald-400 transition-colors mt-1">
                                        Creatine: Separating Myths from Facts
                                    </h5>
                                </div>
                            </div>
                        </a>

                    </div>
                </div>

            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== CUSTOM STYLES =====
      ==================================
    --}}
    <style>
        /* Ken Burns Animation */
        @keyframes kenBurns {
            0% {
                transform: scale(1.1) translate(0, 0);
            }

            100% {
                transform: scale(1) translate(-5px, -5px);
            }
        }

        .animate-ken-burns {
            animation: kenBurns 20s ease-out forwards;
        }

        /* Slide In Animation */
        @keyframes slideInLeft {
            0% {
                transform: translateX(-100%);
                opacity: 0;
            }

            100% {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in-left {
            animation: slideInLeft 1s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* Fade In Up Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        /* Grid Move Animation */
        @keyframes gridMove {
            0% {
                transform: translateY(0);
            }

            100% {
                transform: translateY(50px);
            }
        }

        /* Float Animation */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-float-delayed {
            animation: float 8s ease-in-out infinite;
            animation-delay: 2s;
        }

        /* Responsive Adjustments */
        @media (max-width: 1023px) {
            main .animate-slide-in-left {
                clip-path: none !important;
                width: 100%;
                border-r: none;
                border-bottom: 4px solid rgba(34, 197, 94, 0.4);
            }

            main .relative.z-20 {
                padding-top: 5rem;
                padding-bottom: 5rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #22c55e, #10b981);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #10b981, #059669);
        }
    </style>

</x-layouts.landing>