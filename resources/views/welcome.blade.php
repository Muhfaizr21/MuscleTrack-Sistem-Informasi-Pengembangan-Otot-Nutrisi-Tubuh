<x-layouts.landing>
    {{--
      ==================================
      ===== HERO SECTION - MODERN FITNESS =====
      ==================================
    --}}
    <main class="relative min-h-screen overflow-hidden bg-slate-950">
        {{-- Background dengan efek modern --}}
        <div class="absolute inset-0 z-0" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                    background-image:
                        radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                        url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop');
                    background-size: cover;
                    background-position: center;">
        </div>

        {{-- Overlay Gradient yang lebih soft --}}
        <div class="absolute inset-0 z-5 bg-gradient-to-br from-slate-900/80 via-slate-900/70 to-slate-900/50"></div>

        {{-- Content Container dengan Background --}}
        <div class="relative z-20 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">

                    {{-- Text Content dengan Background Card --}}
                    <div class="lg:col-span-7">
                        <div
                            class="bg-slate-900/60 backdrop-blur-lg rounded-2xl lg:rounded-3xl p-6 sm:p-8 lg:p-12 border border-slate-700/30 shadow-2xl shadow-black/30">

                            {{-- Badge Premium --}}
                            <div class="inline-flex items-center gap-3 px-4 py-2 sm:px-5 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-green-500/15 to-emerald-600/15 backdrop-blur-sm border border-green-500/20 mb-6 sm:mb-8 animate-fade-in-up"
                                style="animation-delay: 0.2s;">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-2 h-2 sm:w-3 sm:h-3 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full animate-pulse">
                                    </div>
                                    <span
                                        class="text-xs sm:text-sm font-semibold text-green-400 uppercase tracking-wider">AI-Powered
                                        Fitness Platform</span>
                                </div>
                            </div>

                            {{-- Main Heading --}}
                            <div class="space-y-4 sm:space-y-6 mb-6 sm:mb-8">
                                <h1 class="font-bold text-3xl sm:text-5xl lg:text-7xl text-white leading-tight animate-fade-in-up"
                                    style="animation-delay: 0.4s;">
                                    <span
                                        class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent">
                                        Transform
                                    </span>
                                    <br class="hidden sm:block">
                                    <span class="text-white">Your Body,</span>
                                    <br class="hidden sm:block">
                                    <span class="text-2xl sm:text-4xl lg:text-6xl text-slate-200 font-semibold">
                                        Dominate Results
                                    </span>
                                </h1>
                            </div>

                            {{-- Description --}}
                            <p class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-8 sm:mb-10 animate-fade-in-up max-w-2xl"
                                style="animation-delay: 0.6s;">
                                Platform fitness berbasis AI yang menganalisis data tubuh Anda dan menciptakan program
                                latihan & nutrisi personal untuk hasil maksimal.
                            </p>

                            {{-- Stats Bar --}}
                            <div class="flex flex-wrap items-center gap-4 sm:gap-8 mb-8 sm:mb-10 animate-fade-in-up"
                                style="animation-delay: 0.7s;">
                                <div class="text-center lg:text-left">
                                    <div
                                        class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">
                                        10K+</div>
                                    <div class="text-xs sm:text-sm text-slate-400 font-medium">Active Members</div>
                                </div>
                                <div
                                    class="hidden sm:block w-px h-12 bg-gradient-to-b from-transparent via-slate-600 to-transparent">
                                </div>
                                <div class="text-center lg:text-left">
                                    <div
                                        class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">
                                        50+</div>
                                    <div class="text-xs sm:text-sm text-slate-400 font-medium">Expert Trainers</div>
                                </div>
                                <div
                                    class="hidden sm:block w-px h-12 bg-gradient-to-b from-transparent via-slate-600 to-transparent">
                                </div>
                                <div class="text-center lg:text-left">
                                    <div
                                        class="text-2xl sm:text-3xl font-bold bg-gradient-to-r from-emerald-400 to-teal-500 bg-clip-text text-transparent">
                                        95%</div>
                                    <div class="text-xs sm:text-sm text-slate-400 font-medium">Success Rate</div>
                                </div>
                            </div>

                            {{-- CTA Buttons --}}
                            <div class="flex flex-col sm:flex-row items-center gap-4 sm:gap-5 animate-fade-in-up"
                                style="animation-delay: 0.8s;">
                                <a href="{{ route('register') }}" class="group relative w-full sm:w-auto px-6 py-4 sm:px-10 sm:py-5 rounded-xl sm:rounded-2xl text-base sm:text-lg font-semibold text-white
                                          bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700
                                          transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-green-500/25
                                          transform hover:scale-105 overflow-hidden">
                                    <span class="relative z-10 flex items-center justify-center gap-2 sm:gap-3">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Mulai Transformasi
                                    </span>
                                    <div
                                        class="absolute inset-0 bg-gradient-to-r from-green-600 to-emerald-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    </div>
                                </a>

                                <a href="#features" class="group w-full sm:w-auto px-6 py-4 sm:px-10 sm:py-5 rounded-xl sm:rounded-2xl text-base sm:text-lg font-semibold text-slate-300
                                          bg-slate-800/40 hover:bg-slate-700/40 backdrop-blur-lg
                                          border border-slate-600/50 hover:border-slate-500/50
                                          transition-all duration-300 transform hover:scale-105
                                          flex items-center justify-center gap-2 sm:gap-3">
                                    <span>Lihat Fitur</span>
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Spacer untuk layout --}}
                    <div class="lg:col-span-5"></div>

                </div>
            </div>
        </div>

        {{-- Floating Elements yang lebih modern --}}
        <div
            class="absolute top-1/4 right-1/4 w-48 h-48 sm:w-72 sm:h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow">
        </div>
        <div class="absolute bottom-1/3 left-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow"
            style="animation-delay: 2s;"></div>
    </main>

    {{--
      ==================================
      ===== FEATURES SECTION =====
      ==================================
    --}}
    <section id="features" class="relative py-16 sm:py-20 lg:py-24 bg-slate-900 overflow-hidden">
        {{-- Background Pattern yang lebih subtle --}}
        <div class="absolute inset-0 opacity-3" style="background-image: radial-gradient(circle, #22c55e 0.5px, transparent 0.5px);
                    background-size: 40px 40px;">
        </div>

        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-900/95 to-slate-900"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 lg:mb-20 animate-fade-in-up">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-green-500/10 backdrop-blur-sm border border-green-500/20 mb-4 sm:mb-6">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <span class="text-xs sm:text-sm font-semibold text-green-400 uppercase tracking-wider">Powered by AI
                        Technology</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    Sistem <span
                        class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Cerdas</span>
                    untuk Hasil Nyata
                </h2>
                <p class="text-base sm:text-xl text-slate-400 leading-relaxed">
                    Platform kami menggunakan teknologi AI untuk menganalisis tubuh Anda dan menciptakan program yang
                    100% personal dan efektif.
                </p>
            </div>

            {{-- Features Grid --}}
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

                {{-- Feature Card 1 --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div
                        class="relative h-full bg-slate-800/40 backdrop-blur-lg rounded-2xl sm:rounded-3xl p-6 sm:p-8 transition-all duration-500 transform group-hover:-translate-y-2 group-hover:shadow-2xl group-hover:shadow-green-500/10">
                        <div
                            class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-green-500/30 to-emerald-600/30 rounded-lg sm:rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-green-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 group-hover:text-green-400 transition-colors duration-300">
                            Analisis AI Presisi
                        </h3>
                        <p class="text-slate-400 leading-relaxed text-base sm:text-lg">
                            Sistem AI kami menghitung BMR, TDEE, dan kebutuhan makro secara akurat berdasarkan data
                            tubuh Anda.
                        </p>
                    </div>
                </div>

                {{-- Feature Card 2 --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div
                        class="relative h-full bg-slate-800/40 backdrop-blur-lg rounded-2xl sm:rounded-3xl p-6 sm:p-8 transition-all duration-500 transform group-hover:-translate-y-2 group-hover:shadow-2xl group-hover:shadow-blue-500/10">
                        <div
                            class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-500/30 to-cyan-600/30 rounded-lg sm:rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-blue-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 group-hover:text-blue-400 transition-colors duration-300">
                            Program Personal
                        </h3>
                        <p class="text-slate-400 leading-relaxed text-base sm:text-lg">
                            Akses workout & nutrition plans yang dirancang khusus oleh trainer profesional untuk tujuan
                            Anda.
                        </p>
                    </div>
                </div>

                {{-- Feature Card 3 --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div
                        class="relative h-full bg-slate-800/40 backdrop-blur-lg rounded-2xl sm:rounded-3xl p-6 sm:p-8 transition-all duration-500 transform group-hover:-translate-y-2 group-hover:shadow-2xl group-hover:shadow-emerald-500/10">
                        <div
                            class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-xl sm:rounded-2xl flex items-center justify-center mb-4 sm:mb-6 group-hover:scale-110 transition-transform duration-500">
                            <div
                                class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-emerald-500/30 to-teal-600/30 rounded-lg sm:rounded-xl flex items-center justify-center">
                                <svg class="w-5 h-5 sm:w-7 sm:h-7 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                        </div>
                        <h3
                            class="text-xl sm:text-2xl font-bold text-white mb-3 sm:mb-4 group-hover:text-emerald-400 transition-colors duration-300">
                            Tracking Real-Time
                        </h3>
                        <p class="text-slate-400 leading-relaxed text-base sm:text-lg">
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
    <section class="relative py-16 sm:py-20 lg:py-24 bg-slate-800 overflow-hidden">
        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-800/90 to-slate-900"></div>

        {{-- Background Elements --}}
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-blue-500/5 blur-[120px] rounded-full"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 lg:mb-20 animate-fade-in-up">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-blue-500/10 backdrop-blur-sm border border-blue-500/20 mb-4 sm:mb-6">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    <span class="text-xs sm:text-sm font-semibold text-blue-400 uppercase tracking-wider">Knowledge
                        Base</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-6xl font-bold text-white mb-4 sm:mb-6">
                    Fitness <span
                        class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">Journal</span>
                </h2>
                <p class="text-base sm:text-xl text-slate-400 leading-relaxed">
                    Tingkatkan pengetahuan fitness Anda dengan artikel dari expert trainer dan nutritionist profesional.
                </p>
            </div>

            <div class="grid lg:grid-cols-12 gap-6 sm:gap-8">

                {{-- Featured Article --}}
                <div class="lg:col-span-7 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div
                        class="group relative overflow-hidden rounded-2xl sm:rounded-3xl bg-slate-700/30 backdrop-blur-lg border border-slate-600/30 transition-all duration-500 hover:shadow-2xl hover:shadow-blue-500/10">
                        {{-- Image dengan Overlay --}}
                        <div class="relative overflow-hidden rounded-t-2xl sm:rounded-t-3xl">
                            <img class="w-full h-48 sm:h-64 lg:h-[400px] object-cover transition-transform duration-700 group-hover:scale-110"
                                src="https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop"
                                alt="Fitness Training">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/40 to-transparent">
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-4 sm:p-6 lg:p-8">
                            <div
                                class="inline-flex items-center gap-2 px-3 py-1 sm:px-4 sm:py-2 rounded-xl sm:rounded-2xl bg-green-500/15 backdrop-blur-sm border border-green-500/20 mb-3 sm:mb-4">
                                <span class="text-xs font-semibold text-green-400 uppercase tracking-wider">Nutrition
                                    Science</span>
                            </div>
                            <a href="#" class="block group/link mb-3 sm:mb-4">
                                <h3
                                    class="text-xl sm:text-2xl lg:text-3xl font-bold text-white group-hover/link:text-green-400 transition-colors duration-300">
                                    Protein Timing: Science Behind Muscle Growth
                                </h3>
                            </a>
                            <p class="text-slate-400 text-base sm:text-lg leading-relaxed mb-4 sm:mb-6">
                                Memahami kapan dan berapa banyak protein yang dibutuhkan tubuh Anda adalah kunci untuk
                                pertumbuhan otot optimal...
                            </p>
                            <a href="{{ route('public.articles.index') }}"
                                class="inline-flex items-center gap-2 sm:gap-3 font-semibold text-green-400 hover:text-green-300 transition-colors duration-300 group/read">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-4 h-4 sm:w-5 sm:h-5 transform group-hover/read:translate-x-2 transition-transform duration-300"
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
                    <h4 class="text-xl sm:text-2xl font-bold text-white mb-6 sm:mb-8 flex items-center gap-3 sm:gap-4">
                        <div class="w-1.5 h-6 sm:w-2 sm:h-8 bg-gradient-to-b from-green-400 to-blue-500 rounded-full">
                        </div>
                        Latest Articles
                    </h4>

                    <div class="space-y-4 sm:space-y-6">

                        {{-- Article Item 1 --}}
                        <a href="#"
                            class="group block p-4 sm:p-6 bg-slate-700/30 hover:bg-slate-700/40 rounded-xl sm:rounded-2xl backdrop-blur-lg border border-slate-600/30 hover:border-slate-500/50 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-start gap-4 sm:gap-5">
                                <div
                                    class="flex-shrink-0 w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-green-500/15 to-emerald-600/15 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-base sm:text-xl font-bold text-green-400">01</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Workout
                                        Tips</span>
                                    <h5
                                        class="text-base sm:text-lg font-bold text-white group-hover:text-green-400 transition-colors duration-300 mt-1 sm:mt-2 line-clamp-2">
                                        5 Common Deadlift Mistakes to Avoid
                                    </h5>
                                </div>
                            </div>
                        </a>

                        {{-- Article Item 2 --}}
                        <a href="#"
                            class="group block p-4 sm:p-6 bg-slate-700/30 hover:bg-slate-700/40 rounded-xl sm:rounded-2xl backdrop-blur-lg border border-slate-600/30 hover:border-slate-500/50 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-start gap-4 sm:gap-5">
                                <div
                                    class="flex-shrink-0 w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-blue-500/15 to-cyan-600/15 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-base sm:text-xl font-bold text-blue-400">02</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Recovery</span>
                                    <h5
                                        class="text-base sm:text-lg font-bold text-white group-hover:text-blue-400 transition-colors duration-300 mt-1 sm:mt-2 line-clamp-2">
                                        Sleep Quality for Optimal Muscle Recovery
                                    </h5>
                                </div>
                            </div>
                        </a>

                        {{-- Article Item 3 --}}
                        <a href="#"
                            class="group block p-4 sm:p-6 bg-slate-700/30 hover:bg-slate-700/40 rounded-xl sm:rounded-2xl backdrop-blur-lg border border-slate-600/30 hover:border-slate-500/50 transition-all duration-300 transform hover:-translate-y-1">
                            <div class="flex items-start gap-4 sm:gap-5">
                                <div
                                    class="flex-shrink-0 w-10 h-10 sm:w-14 sm:h-14 bg-gradient-to-br from-emerald-500/15 to-teal-600/15 rounded-xl sm:rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <span class="text-base sm:text-xl font-bold text-emerald-400">03</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="text-xs text-slate-500 uppercase tracking-wider font-semibold">Supplements</span>
                                    <h5
                                        class="text-base sm:text-lg font-bold text-white group-hover:text-emerald-400 transition-colors duration-300 mt-1 sm:mt-2 line-clamp-2">
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

        /* Slow Pulse Animation */
        @keyframes pulse-slow {

            0%,
            100% {
                opacity: 0.1;
            }

            50% {
                opacity: 0.2;
            }
        }

        .animate-pulse-slow {
            animation: pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #0f172a;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #22c55e, #10b981);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #10b981, #059669);
        }

        /* Smooth transitions for all interactive elements */
        * {
            transition-property: color, background-color, border-color, transform, box-shadow;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Line clamp utility for text truncation */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Responsive text sizing for very small screens */
        @media (max-width: 360px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .hero-subtitle {
                font-size: 1.25rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>

</x-layouts.landing>
