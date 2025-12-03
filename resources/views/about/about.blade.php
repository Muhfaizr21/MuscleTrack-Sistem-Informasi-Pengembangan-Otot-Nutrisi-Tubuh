<x-layouts.landing>
    {{--
      ==================================
      ===== MODERN HERO SECTION =====
      ==================================
    --}}
    <main class="relative min-h-screen bg-slate-950 overflow-hidden">
        {{-- Animated Gradient Background --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-slate-900 to-cyan-950"></div>
            <div class="absolute top-0 left-0 w-full h-full" style="
                background-image:
                    radial-gradient(circle at 20% 30%, rgba(59, 130, 246, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(6, 182, 212, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 40% 80%, rgba(34, 197, 94, 0.1) 0%, transparent 50%);
                background-size: 100% 100%;
            "></div>
        </div>

        {{-- Animated Particles --}}
        <div class="absolute inset-0 z-1 overflow-hidden">
            <div class="particle" style="top: 20%; left: 15%; animation-delay: 0s;"></div>
            <div class="particle" style="top: 60%; left: 80%; animation-delay: 1s;"></div>
            <div class="particle" style="top: 40%; left: 40%; animation-delay: 2s;"></div>
            <div class="particle" style="top: 80%; left: 20%; animation-delay: 3s;"></div>
            <div class="particle" style="top: 30%; left: 70%; animation-delay: 4s;"></div>
        </div>

        {{-- Content Container --}}
        <div class="relative z-10 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">

                    {{-- Text Content --}}
                    <div class="lg:col-span-7">
                        {{-- Animated Badge --}}
                        <div class="inline-flex items-center mb-8 animate-slide-in-left">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-full blur-lg opacity-50 animate-pulse"></div>
                                <div class="relative px-4 py-2 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 backdrop-blur-xl rounded-full border border-blue-500/30">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full animate-ping"></div>
                                        <span class="text-sm font-semibold text-cyan-300 uppercase tracking-wider">
                                            POLINDRA INNOVATION
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Main Heading with Typing Effect --}}
                        <div class="mb-8 animate-slide-in-left" style="animation-delay: 0.1s;">
                            <h1 class="text-4xl sm:text-5xl lg:text-7xl font-bold mb-4">
                                <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-cyan-400 to-teal-400">
                                    Revolutionizing
                                </span>
                                <br>
                                <span class="text-white">Fitness with</span>
                                <br>
                                <span class="text-3xl sm:text-4xl lg:text-6xl text-cyan-200 font-bold">
                                    AI Intelligence
                                </span>
                            </h1>
                        </div>

                        {{-- Description --}}
                        <div class="mb-10 animate-slide-in-left" style="animation-delay: 0.2s;">
                            <p class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-6 max-w-2xl">
                                <span class="text-cyan-300 font-bold">MuscleXpert</span> is an innovative AI-powered fitness platform
                                developed by <span class="text-blue-300 font-semibold">Politeknik Negeri Indramayu</span> students.
                                We combine cutting-edge artificial intelligence with exercise science to deliver
                                personalized, accurate, and accessible fitness solutions.
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-slate-400">AI-Powered Analysis</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-blue-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-slate-400">Personalized Programs</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-cyan-500 rounded-full animate-pulse"></div>
                                    <span class="text-sm text-slate-400">100% Free Access</span>
                                </div>
                            </div>
                        </div>

                        {{-- Interactive Stats --}}
                        <div class="grid grid-cols-3 gap-4 mb-10 animate-slide-in-left" style="animation-delay: 0.3s;">
                            <div class="text-center group">
                                <div class="text-3xl sm:text-4xl font-bold text-blue-400 mb-1 count-up" data-target="3">0</div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider">Dedicated Developers</div>
                                <div class="h-1 w-12 mx-auto mt-2 bg-gradient-to-r from-blue-500 to-transparent rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="text-center group">
                                <div class="text-3xl sm:text-4xl font-bold text-cyan-400 mb-1 count-up" data-target="2025">0</div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider">Project Year</div>
                                <div class="h-1 w-12 mx-auto mt-2 bg-gradient-to-r from-cyan-500 to-transparent rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="text-center group">
                                <div class="text-3xl sm:text-4xl font-bold text-teal-400 mb-1 count-up" data-target="100">0</div>
                                <div class="text-xs text-slate-400 uppercase tracking-wider">AI Accuracy %</div>
                                <div class="h-1 w-12 mx-auto mt-2 bg-gradient-to-r from-teal-500 to-transparent rounded-full opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                        </div>

                        {{-- CTA Buttons --}}
                        <div class="flex flex-col sm:flex-row gap-4 animate-slide-in-left" style="animation-delay: 0.4s;">
                            <a href="{{ route('register') }}"
                               class="group relative px-8 py-4 rounded-xl text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25 overflow-hidden">
                                <span class="relative z-10 flex items-center justify-center gap-3">
                                    <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Get Started Free
                                </span>
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                            </a>
                            <a href="#team"
                               class="group px-8 py-4 rounded-xl text-lg font-semibold text-cyan-300 bg-blue-950/30 hover:bg-blue-900/40 backdrop-blur-lg border border-cyan-500/30 hover:border-cyan-400/50 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-3">
                                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Meet Our Team
                            </a>
                        </div>
                    </div>

                    {{-- Interactive Visual --}}
                    <div class="lg:col-span-5 relative">
                        <div class="relative animate-float">
                            {{-- Main Card --}}
                            <div class="relative bg-gradient-to-br from-blue-900/20 via-cyan-900/10 to-transparent backdrop-blur-xl rounded-3xl border border-cyan-500/20 p-1 shadow-2xl">
                                <div class="relative bg-slate-900/80 rounded-2xl overflow-hidden">
                                    {{-- AI Brain Visualization --}}
                                    <div class="relative h-64 sm:h-80 lg:h-96">
                                        <div class="absolute inset-0 flex items-center justify-center">
                                            <div class="relative">
                                                {{-- Outer Rings --}}
                                                <div class="w-48 h-48 sm:w-64 sm:h-64 lg:w-80 lg:h-80 border border-cyan-500/20 rounded-full animate-spin-slow"></div>
                                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-40 h-40 sm:w-56 sm:h-56 lg:w-72 lg:h-72 border border-blue-500/30 rounded-full animate-spin-reverse"></div>

                                                {{-- AI Core --}}
                                                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
                                                    <div class="relative w-24 h-24 sm:w-32 sm:h-32 lg:w-40 lg:h-40">
                                                        <div class="absolute inset-0 bg-gradient-to-br from-cyan-600/30 to-blue-600/30 rounded-2xl animate-pulse"></div>
                                                        <div class="relative w-full h-full bg-gradient-to-br from-cyan-600/40 to-blue-600/40 rounded-2xl flex items-center justify-center backdrop-blur-sm border border-cyan-500/30">
                                                            <svg class="w-12 h-12 sm:w-16 sm:h-16 lg:w-20 lg:h-20 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Floating Data Points --}}
                                    <div class="absolute top-8 left-8 w-3 h-3 bg-cyan-400 rounded-full animate-bounce"></div>
                                    <div class="absolute bottom-12 right-12 w-4 h-4 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.5s;"></div>
                                    <div class="absolute top-16 right-16 w-2 h-2 bg-teal-400 rounded-full animate-bounce" style="animation-delay: 1s;"></div>

                                    {{-- Info Overlay --}}
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-slate-900 via-slate-900/80 to-transparent p-6">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <h3 class="text-lg font-bold text-white">MuscleXpert AI</h3>
                                                <p class="text-sm text-cyan-300">Powered by Polindra Students</p>
                                            </div>
                                            <div class="px-3 py-1 bg-gradient-to-r from-blue-600/40 to-cyan-600/40 rounded-lg backdrop-blur-sm">
                                                <span class="text-xs font-bold text-white">INNOVATION 2024</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Floating Badge --}}
                            <div class="absolute -bottom-4 -right-4 bg-gradient-to-br from-blue-700 to-cyan-600 rounded-2xl p-4 shadow-2xl border border-cyan-500/30 animate-bounce-slow">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-white">3</div>
                                    <div class="text-xs text-cyan-200">Talented</div>
                                    <div class="text-xs text-blue-200">Students</div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Scroll Indicator --}}
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#story" class="text-cyan-400 hover:text-blue-300 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                </svg>
            </a>
        </div>
    </main>

    {{--
      ==================================
      ===== STORY SECTION - MODERN DESIGN =====
      ==================================
    --}}
    <section id="story" class="relative py-20 lg:py-32 bg-gradient-to-b from-slate-900 via-blue-950/50 to-slate-900 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-5" style="
            background-image:
                radial-gradient(circle at 25% 25%, #3b82f6 1px, transparent 1px),
                radial-gradient(circle at 75% 75%, #06b6d4 1px, transparent 1px);
            background-size: 50px 50px;
        "></div>

        <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-16 lg:mb-24">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-full backdrop-blur-sm border border-blue-500/30 mb-6">
                    <div class="w-2 h-2 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-cyan-300 uppercase tracking-wider">Our Journey</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                    From Classroom to
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                        Innovation
                    </span>
                </h2>
                <p class="text-lg text-slate-400 max-w-3xl mx-auto">
                    How three students from <span class="text-blue-300 font-semibold">Politeknik Negeri Indramayu</span>
                    transformed academic knowledge into a cutting-edge fitness platform
                </p>
            </div>

            {{-- Interactive Timeline --}}
            <div class="relative">
                {{-- Timeline Line --}}
                <div class="absolute left-1/2 transform -translate-x-1/2 h-full w-px bg-gradient-to-b from-transparent via-cyan-500/30 to-transparent"></div>

                {{-- Timeline Items --}}
                <div class="space-y-16">
                    {{-- Item 1 --}}
                    <div class="relative flex items-center gap-8 group">
                        <div class="hidden lg:block lg:w-1/2"></div>
                        <div class="w-full lg:w-1/2 lg:pl-12">
                            <div class="relative bg-gradient-to-br from-blue-900/20 to-cyan-900/10 backdrop-blur-lg rounded-2xl p-6 border border-blue-500/20 group-hover:border-cyan-500/40 transition-all duration-300">
                                <div class="absolute -left-12 top-6 w-8 h-8 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-full flex items-center justify-center border-4 border-slate-900">
                                    <span class="text-sm font-bold text-white">1</span>
                                </div>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-600/20 to-cyan-600/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-cyan-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Research & Discovery</h3>
                                        <p class="text-sm text-blue-300">Identifying Fitness Challenges</p>
                                    </div>
                                </div>
                                <p class="text-slate-300">
                                    Our journey began with extensive research into fitness challenges faced by individuals.
                                    We discovered a gap in personalized, accessible fitness solutions that leverage technology.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Item 2 --}}
                    <div class="relative flex items-center gap-8 group">
                        <div class="w-full lg:w-1/2 lg:pr-12">
                            <div class="relative bg-gradient-to-br from-blue-900/20 to-cyan-900/10 backdrop-blur-lg rounded-2xl p-6 border border-blue-500/20 group-hover:border-cyan-500/40 transition-all duration-300">
                                <div class="absolute -right-12 top-6 w-8 h-8 bg-gradient-to-br from-cyan-600 to-teal-600 rounded-full flex items-center justify-center border-4 border-slate-900">
                                    <span class="text-sm font-bold text-white">2</span>
                                </div>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-600/20 to-teal-600/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Academic Integration</h3>
                                        <p class="text-sm text-teal-300">Applying Classroom Knowledge</p>
                                    </div>
                                </div>
                                <p class="text-slate-300">
                                    We applied our academic knowledge from <span class="text-blue-300">Politeknik Negeri Indramayu</span>
                                    in software development, AI algorithms, and database design to create the foundation of MuscleXpert.
                                </p>
                            </div>
                        </div>
                        <div class="hidden lg:block lg:w-1/2"></div>
                    </div>

                    {{-- Item 3 --}}
                    <div class="relative flex items-center gap-8 group">
                        <div class="hidden lg:block lg:w-1/2"></div>
                        <div class="w-full lg:w-1/2 lg:pl-12">
                            <div class="relative bg-gradient-to-br from-blue-900/20 to-cyan-900/10 backdrop-blur-lg rounded-2xl p-6 border border-blue-500/20 group-hover:border-cyan-500/40 transition-all duration-300">
                                <div class="absolute -left-12 top-6 w-8 h-8 bg-gradient-to-br from-teal-600 to-emerald-600 rounded-full flex items-center justify-center border-4 border-slate-900">
                                    <span class="text-sm font-bold text-white">3</span>
                                </div>
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-teal-600/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-xl font-bold text-white">Platform Launch</h3>
                                        <p class="text-sm text-emerald-300">Bringing Innovation to Life</p>
                                    </div>
                                </div>
                                <p class="text-slate-300">
                                    After months of development and testing, we launched MuscleXpert - a testament to
                                    how academic projects can evolve into real-world solutions that benefit society.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== TEAM SECTION - GLASSMORPHIC CARDS =====
      ==================================
    --}}
    <section id="team" class="relative py-20 lg:py-32 bg-gradient-to-b from-slate-900 to-blue-950/50 overflow-hidden">
        {{-- Floating Elements --}}
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center mb-16 lg:mb-24">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-full backdrop-blur-sm border border-blue-500/30 mb-6">
                    <div class="w-2 h-2 bg-gradient-to-r from-cyan-400 to-blue-400 rounded-full animate-pulse"></div>
                    <span class="text-sm font-semibold text-cyan-300 uppercase tracking-wider">Development Team</span>
                </div>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                    Meet the
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                        Minds Behind
                    </span>
                </h2>
                <p class="text-lg text-slate-400 max-w-3xl mx-auto">
                    Three passionate students from <span class="text-blue-300 font-semibold">Politeknik Negeri Indramayu</span>
                    combining their skills to revolutionize fitness technology
                </p>
            </div>

            {{-- Team Cards --}}
            <div class="grid md:grid-cols-3 gap-8 lg:gap-12">
                {{-- Muhammad Faiz Ramadhan --}}
                <div class="group relative">
                    <div class="relative bg-gradient-to-br from-blue-900/20 via-slate-900/30 to-cyan-900/10 backdrop-blur-xl rounded-3xl border border-blue-500/20 p-8 transition-all duration-500 group-hover:scale-105 group-hover:border-cyan-500/40 group-hover:shadow-2xl group-hover:shadow-blue-500/10">
                        {{-- Avatar --}}
                        <div class="relative mb-6">
                            <div class="absolute -inset-4 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative w-32 h-32 mx-auto bg-gradient-to-br from-blue-600 to-cyan-600 rounded-full flex items-center justify-center border-4 border-slate-900">
                                <span class="text-4xl font-bold text-white">FR</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-2xl font-bold text-white text-center mb-2">Muhammad Faiz Ramadhan</h3>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-full mx-auto mb-4">
                            <div class="w-2 h-2 bg-cyan-400 rounded-full"></div>
                            <span class="text-sm font-medium text-cyan-300">Lead Developer & AI Specialist</span>
                        </div>
                        <p class="text-slate-300 text-center mb-6">
                            Architect of the AI algorithms that power MuscleXpert's intelligent fitness recommendations
                        </p>

                        {{-- Skills --}}
                        <div class="flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-blue-600/20 text-blue-300 text-sm rounded-full border border-blue-500/20">AI/ML Engineering</span>
                            <span class="px-3 py-1 bg-cyan-600/20 text-cyan-300 text-sm rounded-full border border-cyan-500/20">Backend Architecture</span>
                            <span class="px-3 py-1 bg-teal-600/20 text-teal-300 text-sm rounded-full border border-teal-500/20">Algorithm Design</span>
                        </div>
                    </div>
                </div>

                {{-- Muhammad Ihya 'Ulumuddin --}}
                <div class="group relative">
                    <div class="relative bg-gradient-to-br from-blue-900/20 via-slate-900/30 to-cyan-900/10 backdrop-blur-xl rounded-3xl border border-blue-500/20 p-8 transition-all duration-500 group-hover:scale-105 group-hover:border-cyan-500/40 group-hover:shadow-2xl group-hover:shadow-blue-500/10">
                        {{-- Avatar --}}
                        <div class="relative mb-6">
                            <div class="absolute -inset-4 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative w-32 h-32 mx-auto bg-gradient-to-br from-cyan-600 to-teal-600 rounded-full flex items-center justify-center border-4 border-slate-900">
                                <span class="text-4xl font-bold text-white">IU</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-2xl font-bold text-white text-center mb-2">Muhammad Ihya 'Ulumuddin</h3>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-cyan-600/20 to-teal-600/20 rounded-full mx-auto mb-4">
                            <div class="w-2 h-2 bg-teal-400 rounded-full"></div>
                            <span class="text-sm font-medium text-teal-300">Frontend Developer & UX Designer</span>
                        </div>
                        <p class="text-slate-300 text-center mb-6">
                            Crafts intuitive interfaces and seamless user experiences that make fitness technology accessible to all
                        </p>

                        {{-- Skills --}}
                        <div class="flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-cyan-600/20 text-cyan-300 text-sm rounded-full border border-cyan-500/20">UI/UX Design</span>
                            <span class="px-3 py-1 bg-teal-600/20 text-teal-300 text-sm rounded-full border border-teal-500/20">Frontend Development</span>
                            <span class="px-3 py-1 bg-emerald-600/20 text-emerald-300 text-sm rounded-full border border-emerald-500/20">Responsive Design</span>
                        </div>
                    </div>
                </div>

                {{-- Hardi Rizki Triyana --}}
                <div class="group relative">
                    <div class="relative bg-gradient-to-br from-blue-900/20 via-slate-900/30 to-cyan-900/10 backdrop-blur-xl rounded-3xl border border-blue-500/20 p-8 transition-all duration-500 group-hover:scale-105 group-hover:border-cyan-500/40 group-hover:shadow-2xl group-hover:shadow-blue-500/10">
                        {{-- Avatar --}}
                        <div class="relative mb-6">
                            <div class="absolute -inset-4 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="relative w-32 h-32 mx-auto bg-gradient-to-br from-teal-600 to-emerald-600 rounded-full flex items-center justify-center border-4 border-slate-900">
                                <span class="text-4xl font-bold text-white">HT</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-2xl font-bold text-white text-center mb-2">Hardi Rizki Triyana</h3>
                        <div class="inline-flex items-center gap-2 px-3 py-1 bg-gradient-to-r from-teal-600/20 to-emerald-600/20 rounded-full mx-auto mb-4">
                            <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                            <span class="text-sm font-medium text-emerald-300">System Architect & Database Specialist</span>
                        </div>
                        <p class="text-slate-300 text-center mb-6">
                            Designs robust systems and efficient databases ensuring MuscleXpert's scalability and performance
                        </p>

                        {{-- Skills --}}
                        <div class="flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-teal-600/20 text-teal-300 text-sm rounded-full border border-teal-500/20">System Architecture</span>
                            <span class="px-3 py-1 bg-emerald-600/20 text-emerald-300 text-sm rounded-full border border-emerald-500/20">Database Design</span>
                            <span class="px-3 py-1 bg-green-600/20 text-green-300 text-sm rounded-full border border-green-500/20">DevOps</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Polindra Banner --}}

        </div>
    </section>

    {{--
      ==================================
      ===== CTA SECTION - FINAL =====
      ==================================
    --}}
    <section class="relative py-20 lg:py-32 bg-gradient-to-b from-blue-950/50 to-slate-900 overflow-hidden">
        {{-- Background Effect --}}
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/10 via-transparent to-cyan-900/10"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="bg-gradient-to-br from-blue-900/20 via-slate-900/30 to-cyan-900/10 backdrop-blur-xl rounded-3xl border border-blue-500/20 p-8 lg:p-12">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-6">
                    Ready to Experience
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-cyan-400">
                        AI-Powered Fitness?
                    </span>
                </h2>
                <p class="text-lg text-slate-300 mb-8 max-w-2xl mx-auto">
                    Join thousands who have transformed their fitness journey with intelligent technology
                    developed by <span class="text-blue-300 font-semibold">Politeknik Negeri Indramayu</span> students
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center mb-10">
                    <a href="{{ route('register') }}"
                       class="group relative px-8 py-4 rounded-xl text-lg font-semibold text-white bg-gradient-to-r from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700 transition-all duration-300 transform hover:scale-105 hover:shadow-2xl hover:shadow-blue-500/25 overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Start Your Free Journey
                        </span>
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-700 to-cyan-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </a>
                    <a href="{{ route('contact.index') }}"
                       class="group px-8 py-4 rounded-xl text-lg font-semibold text-cyan-300 bg-blue-950/30 hover:bg-blue-900/40 backdrop-blur-lg border border-cyan-500/30 hover:border-cyan-400/50 transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-3">
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Contact Our Team
                    </a>
                </div>

                {{-- Polindra Footer --}}
                <div class="pt-8 border-t border-blue-500/20">
                    <div class="inline-flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-cyan-600 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold">PNI</span>
                        </div>
                        <div class="text-left">
                            <h4 class="text-sm font-bold text-white">Politeknik Negeri Indramayu</h4>
                            <p class="text-xs text-slate-400">Creating Innovators, Shaping the Future</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== CUSTOM STYLES & ANIMATIONS =====
      ==================================
    --}}
    <style>
        /* Custom Animations */
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes spin-reverse {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(-360deg);
            }
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes particle-float {
            0%, 100% {
                transform: translateY(0) translateX(0);
                opacity: 0;
            }
            10%, 90% {
                opacity: 1;
            }
            50% {
                transform: translateY(-100px) translateX(100px);
                opacity: 0.5;
            }
        }

        /* Animation Classes */
        .animate-slide-in-left {
            opacity: 0;
            animation: slideInLeft 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        .animate-slide-in-right {
            opacity: 0;
            animation: slideInRight 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        .animate-float {
            animation: float 6s ease-in-out infinite;
        }

        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }

        .animate-spin-reverse {
            animation: spin-reverse 15s linear infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }

        /* Particle Styling */
        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: linear-gradient(45deg, #3b82f6, #06b6d4);
            border-radius: 50%;
            animation: particle-float 20s ease-in-out infinite;
        }

        /* Count Up Animation */
        .count-up {
            transition: all 0.3s ease-out;
        }

        /* Glassmorphism Effects */
        .glass-card {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        /* Responsive Adjustments */
        @media (max-width: 640px) {
            .timeline-line {
                left: 2rem;
            }
            .timeline-item:nth-child(odd) .timeline-content,
            .timeline-item:nth-child(even) .timeline-content {
                margin-left: 3rem;
            }
        }
    </style>

    {{--
      ==================================
      ===== INTERACTIVE JAVASCRIPT =====
      ==================================
    --}}
    <script>
        // Count Up Animation
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.count-up');
            const speed = 200;

            counters.forEach(counter => {
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText;
                    const increment = target / speed;

                    if (count < target) {
                        counter.innerText = Math.ceil(count + increment);
                        setTimeout(updateCount, 10);
                    } else {
                        counter.innerText = target;
                    }
                };

                // Start counting when element is in viewport
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            updateCount();
                            observer.unobserve(entry.target);
                        }
                    });
                });

                observer.observe(counter);
            });

            // Add hover effects to team cards
            const teamCards = document.querySelectorAll('.group');
            teamCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    card.style.transform = 'translateY(-10px)';
                });
                card.addEventListener('mouseleave', () => {
                    card.style.transform = 'translateY(0)';
                });
            });

            // Smooth scroll for navigation
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
        });

        // Parallax effect for hero section
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const hero = document.querySelector('main');
            if (hero) {
                hero.style.transform = `translateY(${scrolled * 0.05}px)`;
            }
        });
    </script>
</x-layouts.landing>
