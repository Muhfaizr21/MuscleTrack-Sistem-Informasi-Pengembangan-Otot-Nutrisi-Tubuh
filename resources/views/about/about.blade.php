<x-layouts.landing>
    {{--
      ==================================
      ===== ABOUT US SECTION - HERO =====
      ==================================
    --}}
    <main class="relative min-h-screen bg-slate-950 overflow-hidden">
        {{-- Background dengan efek modern --}}
        <div class="absolute inset-0 z-0" style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
                    background-image:
                        radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                        radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%);
                    background-size: cover;">
        </div>

        {{-- Overlay Gradient --}}
        <div class="absolute inset-0 z-5 bg-gradient-to-br from-slate-900/80 via-slate-900/70 to-slate-900/50"></div>

        {{-- Content Container --}}
        <div class="relative z-20 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-center">

                    {{-- Text Content --}}
                    <div class="lg:col-span-7 animate-fade-in-up">
                        <div
                            class="bg-slate-900/60 backdrop-blur-lg rounded-2xl lg:rounded-3xl p-6 sm:p-8 lg:p-12 border border-slate-700/30 shadow-2xl shadow-black/30">

                            {{-- Badge --}}
                            <div
                                class="inline-flex items-center gap-3 px-4 py-2 sm:px-5 sm:py-3 rounded-xl sm:rounded-2xl bg-gradient-to-r from-green-500/15 to-emerald-600/15 backdrop-blur-sm border border-green-500/20 mb-6 sm:mb-8">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-2 h-2 sm:w-3 sm:h-3 bg-gradient-to-r from-green-400 to-emerald-500 rounded-full animate-pulse">
                                    </div>
                                    <span class="text-xs sm:text-sm font-semibold text-green-400 uppercase tracking-wider">
                                        Our Vision
                                    </span>
                                </div>
                            </div>

                            {{-- Main Heading --}}
                            <div class="space-y-4 sm:space-y-6 mb-6 sm:mb-8">
                                <h1 class="font-bold text-3xl sm:text-5xl lg:text-6xl text-white leading-tight">
                                    <span
                                        class="bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent">
                                        Transforming
                                    </span>
                                    <br class="hidden sm:block">
                                    <span class="text-white">Fitness Through</span>
                                    <br class="hidden sm:block">
                                    <span class="text-2xl sm:text-4xl lg:text-5xl text-slate-200 font-semibold">
                                        Intelligent Technology
                                    </span>
                                </h1>
                            </div>

                            {{-- Description --}}
                            <p class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-8 sm:mb-10 max-w-2xl">
                                MuscleXpert adalah platform fitness revolusioner yang dikembangkan oleh tim mahasiswa
                                <span class="text-green-400 font-semibold">Politeknik Negeri Indramayu</span>. Kami menggabungkan
                                ilmu olahraga terkini dengan teknologi AI untuk menciptakan pengalaman fitness yang personal,
                                akurat, dan terukur bagi semua kalangan.
                            </p>

                            {{-- Stats --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-6 mb-8 sm:mb-10">
                                <div class="text-center p-4 bg-slate-800/30 rounded-xl">
                                    <div class="text-2xl sm:text-3xl font-bold text-green-400">2024</div>
                                    <div class="text-xs sm:text-sm text-slate-400 mt-1">Project Start</div>
                                </div>
                                <div class="text-center p-4 bg-slate-800/30 rounded-xl">
                                    <div class="text-2xl sm:text-3xl font-bold text-blue-400">100%</div>
                                    <div class="text-xs sm:text-sm text-slate-400 mt-1">AI-Powered</div>
                                </div>
                                <div class="text-center p-4 bg-slate-800/30 rounded-xl">
                                    <div class="text-2xl sm:text-3xl font-bold text-emerald-400">3</div>
                                    <div class="text-xs sm:text-sm text-slate-400 mt-1">Dedicated Developers</div>
                                </div>
                            </div>

                            {{-- Polindra Logo Badge --}}
                            <div class="inline-flex items-center gap-3 px-4 py-2 bg-slate-800/40 rounded-xl border border-blue-500/20">
                                <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-xs">PNI</span>
                                </div>
                                <span class="text-sm text-blue-300">Politeknik Negeri Indramayu</span>
                            </div>
                        </div>
                    </div>

                    {{-- Image/Illustration --}}
                    <div class="lg:col-span-5 animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="relative">
                            <div
                                class="relative rounded-2xl lg:rounded-3xl overflow-hidden border border-slate-700/30 shadow-2xl">
                                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?q=80&w=2670&auto=format&fit=crop"
                                    alt="AI Fitness Technology" class="w-full h-64 sm:h-80 lg:h-96 object-cover">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent">
                                </div>
                                {{-- Polindra Overlay --}}
                                <div class="absolute bottom-4 left-4 bg-blue-600/90 backdrop-blur-sm rounded-lg px-3 py-2">
                                    <span class="text-sm font-bold text-white">Politeknik Negeri Indramayu</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- Floating Elements --}}
        <div
            class="absolute top-1/4 right-1/4 w-48 h-48 sm:w-72 sm:h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow">
        </div>
        <div class="absolute bottom-1/3 left-1/4 w-64 h-64 sm:w-96 sm:h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow"
            style="animation-delay: 2s;">
        </div>
    </main>

    {{--
      ==================================
      ===== OUR STORY SECTION =====
      ==================================
    --}}
    <section class="relative py-16 sm:py-20 lg:py-24 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-900/95 to-slate-900"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 lg:mb-20 animate-fade-in-up">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-emerald-500/10 backdrop-blur-sm border border-emerald-500/20 mb-4 sm:mb-6">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                    <span class="text-xs sm:text-sm font-semibold text-emerald-400 uppercase tracking-wider">The Journey</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6">
                    Inovasi dari
                    <span class="bg-gradient-to-r from-emerald-400 to-teal-500 bg-clip-text text-transparent">
                        Kampus Vokasi
                    </span>
                </h2>
                <p class="text-base sm:text-xl text-slate-400 leading-relaxed max-w-4xl mx-auto">
                    MuscleXpert lahir dari ide kreatif mahasiswa <span class="text-blue-300 font-semibold">Politeknik Negeri Indramayu</span>
                    yang melihat peluang untuk menerapkan teknologi dalam bidang kesehatan dan fitness. Sebagai institusi vokasi,
                    kami fokus pada pengembangan solusi praktis yang dapat langsung diaplikasikan di masyarakat.
                </p>
            </div>

            {{-- Timeline --}}
            <div class="max-w-4xl mx-auto">
                <div class="space-y-8 sm:space-y-12">
                    {{-- Timeline Item 1 --}}
                    <div class="flex items-start gap-6 animate-fade-in-up" style="animation-delay: 0.1s;">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                <span class="text-green-400 font-bold text-lg">01</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">Observasi & Ide Awal</h3>
                            <p class="text-slate-400">
                                Mengamati kesulitan masyarakat dalam mendapatkan program fitness yang sesuai dengan kondisi
                                tubuh dan tujuan spesifik mereka, tim mahasiswa Polindra berinisiatif menciptakan solusi berbasis teknologi.
                            </p>
                        </div>
                    </div>

                    {{-- Timeline Item 2 --}}
                    <div class="flex items-start gap-6 animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-xl flex items-center justify-center">
                                <span class="text-blue-400 font-bold text-lg">02</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">Pengembangan di Lingkungan Kampus</h3>
                            <p class="text-slate-400">
                                Dengan dukungan dosen pembimbing dan fasilitas kampus, kami melakukan penelitian tentang exercise science,
                                nutrition, dan mengembangkan algoritma AI yang akurat untuk analisis fitness.
                            </p>
                        </div>
                    </div>

                    {{-- Timeline Item 3 --}}
                    <div class="flex items-start gap-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-xl flex items-center justify-center">
                                <span class="text-emerald-400 font-bold text-lg">03</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-white mb-2">Implementasi & Uji Coba</h3>
                            <p class="text-slate-400">
                                Mengembangkan platform dengan teknologi modern seperti Laravel dan Tailwind CSS,
                                kemudian melakukan uji coba terbatas kepada mahasiswa dan dosen Polindra untuk mendapatkan feedback.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== DEVELOPMENT TEAM SECTION =====
      ==================================
    --}}
    <section class="relative py-16 sm:py-20 lg:py-24 bg-slate-800 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-800/90 to-slate-900"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 lg:mb-20 animate-fade-in-up">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-blue-500/10 backdrop-blur-sm border border-blue-500/20 mb-4 sm:mb-6">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    <span class="text-xs sm:text-sm font-semibold text-blue-400 uppercase tracking-wider">Development Team</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6">
                    Tim Pengembang
                    <span class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">
                        MuscleXpert
                    </span>
                </h2>
                <p class="text-base sm:text-xl text-slate-400 leading-relaxed">
                    Dikembangkan oleh tiga mahasiswa berdedikasi dari <span class="text-blue-300">Politeknik Negeri Indramayu</span>
                    yang memiliki passion dalam teknologi dan kesehatan.
                </p>
            </div>

            {{-- Team Grid --}}
            <div class="grid md:grid-cols-3 gap-8 sm:gap-12">
                {{-- Muhammad Faiz Ramadhan --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="text-center">
                        {{-- Avatar --}}
                        <div class="relative mb-6 mx-auto w-40 h-40 sm:w-48 sm:h-48">
                            <div class="absolute inset-0 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-full blur-xl"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-green-500/30 to-emerald-600/30 rounded-full flex items-center justify-center border-2 border-green-500/30">
                                <span class="text-4xl sm:text-5xl font-bold text-green-400">FR</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">Muhammad Faiz Ramadhan</h3>
                        <p class="text-green-400 text-sm sm:text-base font-medium mb-3">Lead Developer & AI Specialist</p>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs mx-auto">
                            Mahasiswa Polindra yang bertanggung jawab dalam pengembangan algoritma AI,
                            sistem rekomendasi, dan arsitektur backend platform.
                        </p>

                        {{-- Skills --}}
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-green-500/10 text-green-400 text-xs rounded-full">AI/ML</span>
                            <span class="px-3 py-1 bg-green-500/10 text-green-400 text-xs rounded-full">Laravel</span>
                            <span class="px-3 py-1 bg-green-500/10 text-green-400 text-xs rounded-full">Backend</span>
                        </div>
                    </div>
                </div>

                {{-- Muhammad Ihya 'Ulumuddin --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="text-center">
                        {{-- Avatar --}}
                        <div class="relative mb-6 mx-auto w-40 h-40 sm:w-48 sm:h-48">
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-full blur-xl"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-blue-500/30 to-cyan-600/30 rounded-full flex items-center justify-center border-2 border-blue-500/30">
                                <span class="text-4xl sm:text-5xl font-bold text-blue-400">IU</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">Muhammad Ihya 'Ulumuddin</h3>
                        <p class="text-blue-400 text-sm sm:text-base font-medium mb-3">Frontend Developer & UX Designer</p>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs mx-auto">
                            Mahasiswa Polindra yang mengembangkan antarmuka pengguna yang intuitif
                            dan pengalaman pengguna yang optimal untuk platform.
                        </p>

                        {{-- Skills --}}
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs rounded-full">Tailwind CSS</span>
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs rounded-full">JavaScript</span>
                            <span class="px-3 py-1 bg-blue-500/10 text-blue-400 text-xs rounded-full">UI/UX Design</span>
                        </div>
                    </div>
                </div>

                {{-- Hardi Rizki Triyana --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="text-center">
                        {{-- Avatar --}}
                        <div class="relative mb-6 mx-auto w-40 h-40 sm:w-48 sm:h-48">
                            <div class="absolute inset-0 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-full blur-xl"></div>
                            <div class="relative w-full h-full bg-gradient-to-br from-emerald-500/30 to-teal-600/30 rounded-full flex items-center justify-center border-2 border-emerald-500/30">
                                <span class="text-4xl sm:text-5xl font-bold text-emerald-400">HT</span>
                            </div>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-2">Hardi Rizki Triyana</h3>
                        <p class="text-emerald-400 text-sm sm:text-base font-medium mb-3">System Architect & Database Specialist</p>
                        <p class="text-slate-400 text-sm leading-relaxed max-w-xs mx-auto">
                            Mahasiswa Polindra yang merancang struktur database dan mengoptimalkan
                            performa sistem untuk skala yang lebih besar.
                        </p>

                        {{-- Skills --}}
                        <div class="mt-4 flex flex-wrap justify-center gap-2">
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-full">Database</span>
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-full">System Design</span>
                            <span class="px-3 py-1 bg-emerald-500/10 text-emerald-400 text-xs rounded-full">DevOps</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Polindra Info --}}
            <div class="mt-16 text-center animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="inline-flex items-center justify-center gap-4 px-6 py-4 bg-gradient-to-r from-blue-600/20 to-cyan-600/20 rounded-2xl backdrop-blur-sm border border-blue-500/30">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xs">PNI</span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-white">Politeknik Negeri Indramayu</h4>
                            <p class="text-sm text-blue-300">Institusi Pendidikan Vokasi Unggulan</p>
                        </div>
                    </div>
                </div>
                <p class="text-slate-400 mt-4 max-w-2xl mx-auto">
                    Sebagai politeknik negeri, Polindra berkomitmen untuk menghasilkan lulusan yang siap kerja
                    dan mampu berkontribusi dalam pengembangan teknologi di berbagai sektor industri.
                </p>
            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== TECHNOLOGY STACK SECTION =====
      ==================================
    --}}
    <section class="relative py-16 sm:py-20 lg:py-24 bg-slate-900 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-b from-slate-900 via-slate-900/95 to-slate-900"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="text-center max-w-3xl mx-auto mb-12 sm:mb-16 lg:mb-20 animate-fade-in-up">
                <div
                    class="inline-flex items-center gap-3 px-4 py-2 sm:px-6 sm:py-3 rounded-xl sm:rounded-2xl bg-green-500/10 backdrop-blur-sm border border-green-500/20 mb-4 sm:mb-6">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    <span class="text-xs sm:text-sm font-semibold text-green-400 uppercase tracking-wider">Tech Stack</span>
                </div>
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 sm:mb-6">
                    Teknologi yang Digunakan

                </h2>
                <p class="text-base sm:text-xl text-slate-400 leading-relaxed max-w-3xl mx-auto">
                    Menggunakan teknologi modern yang diajarkan dalam kurikulum <span class="text-blue-300">Politeknik Negeri Indramayu</span>
                    untuk membangun solusi yang scalable dan efisien.
                </p>
            </div>

            {{-- Tech Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-8">
                {{-- Laravel --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="bg-slate-800/40 backdrop-blur-lg rounded-2xl p-6 text-center transition-all duration-500 group-hover:-translate-y-2">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-red-500/20 to-pink-600/20 rounded-2xl flex items-center justify-center">
                            <div class="text-red-400 font-bold text-xl">L</div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Laravel Framework</h3>
                        <p class="text-slate-400 text-sm">PHP framework untuk backend yang robust dan scalable.</p>
                        <div class="mt-3">
                            <span class="text-xs text-red-400 bg-red-500/10 px-2 py-1 rounded">Polindra Curriculum</span>
                        </div>
                    </div>
                </div>

                {{-- Tailwind CSS --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="bg-slate-800/40 backdrop-blur-lg rounded-2xl p-6 text-center transition-all duration-500 group-hover:-translate-y-2">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-cyan-500/20 to-blue-600/20 rounded-2xl flex items-center justify-center">
                            <div class="text-cyan-400 font-bold text-xl">T</div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Tailwind CSS</h3>
                        <p class="text-slate-400 text-sm">Utility-first CSS framework untuk UI yang responsive.</p>
                        <div class="mt-3">
                            <span class="text-xs text-cyan-400 bg-cyan-500/10 px-2 py-1 rounded">Polindra Curriculum</span>
                        </div>
                    </div>
                </div>

                {{-- Alpine.js --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="bg-slate-800/40 backdrop-blur-lg rounded-2xl p-6 text-center transition-all duration-500 group-hover:-translate-y-2">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-indigo-500/20 to-purple-600/20 rounded-2xl flex items-center justify-center">
                            <div class="text-indigo-400 font-bold text-xl">A</div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">Alpine.js</h3>
                        <p class="text-slate-400 text-sm">Minimal framework untuk interaktivitas JavaScript.</p>
                        <div class="mt-3">
                            <span class="text-xs text-indigo-400 bg-indigo-500/10 px-2 py-1 rounded">Polindra Curriculum</span>
                        </div>
                    </div>
                </div>

                {{-- MySQL --}}
                <div class="group animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="bg-slate-800/40 backdrop-blur-lg rounded-2xl p-6 text-center transition-all duration-500 group-hover:-translate-y-2">
                        <div class="w-16 h-16 mx-auto mb-4 bg-gradient-to-br from-orange-500/20 to-yellow-600/20 rounded-2xl flex items-center justify-center">
                            <div class="text-orange-400 font-bold text-xl">M</div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-2">MySQL Database</h3>
                        <p class="text-slate-400 text-sm">Database relational untuk penyimpanan data yang terstruktur.</p>
                        <div class="mt-3">
                            <span class="text-xs text-orange-400 bg-orange-500/10 px-2 py-1 rounded">Polindra Curriculum</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Polindra Curriculum Note --}}
            <div class="mt-12 text-center animate-fade-in-up" style="animation-delay: 0.5s;">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600/20 rounded-lg">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm text-blue-300">Semua teknologi di atas merupakan bagian dari kurikulum pendidikan di Politeknik Negeri Indramayu</span>
                </div>
            </div>
        </div>
    </section>

    {{--
      ==================================
      ===== CTA SECTION =====
      ==================================
    --}}
    <section class="relative py-16 sm:py-20 lg:py-24 bg-slate-800 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-slate-800 via-slate-800/90 to-slate-900"></div>
        <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-blue-500/5 blur-[120px] rounded-full"></div>

        <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="animate-fade-in-up">
                <h2 class="text-2xl sm:text-4xl lg:text-5xl font-bold text-white mb-6 sm:mb-8">
                    Inovasi dari
                    <span class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">
                        Kampus Vokasi
                    </span>
                </h2>
                <p class="text-lg sm:text-xl text-slate-300 leading-relaxed mb-8 sm:mb-10 max-w-2xl mx-auto">
                    Rasakan pengalaman fitness yang personal dan efektif dengan teknologi AI yang dikembangkan
                    oleh mahasiswa <span class="text-blue-300 font-semibold">Politeknik Negeri Indramayu</span>.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 sm:gap-5 justify-center">
                    <a href="{{ route('register') }}"
                        class="group relative px-8 py-4 sm:px-12 sm:py-5 rounded-xl sm:rounded-2xl text-lg sm:text-xl font-semibold text-white
                               bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700
                               transition-all duration-300 shadow-lg hover:shadow-xl hover:shadow-blue-500/25
                               transform hover:scale-105 overflow-hidden">
                        <span class="relative z-10 flex items-center justify-center gap-3">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            Mulai Sekarang
                        </span>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-600 to-cyan-700 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </a>
                    <a href="{{ route('contact.index') }}"
                        class="group px-8 py-4 sm:px-12 sm:py-5 rounded-xl sm:rounded-2xl text-lg sm:text-xl font-semibold text-slate-300
                               bg-slate-800/40 hover:bg-slate-700/40 backdrop-blur-lg
                               border border-slate-600/50 hover:border-slate-500/50
                               transition-all duration-300 transform hover:scale-105
                               flex items-center justify-center gap-3">
                        <span>Hubungi Tim</span>
                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </a>
                </div>

                {{-- Polindra Footer --}}
                <div class="mt-12 pt-8 border-t border-slate-700/30">
                    <div class="inline-flex items-center gap-3">
                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-xs">PNI</span>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-white">Politeknik Negeri Indramayu</h4>
                            <p class="text-xs text-slate-400">Menghasilkan Lulusan yang Kompeten dan Siap Kerja</p>
                        </div>
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

        /* Responsive text sizing */
        @media (max-width: 360px) {
            .hero-title {
                font-size: 1.75rem;
            }

            .section-title {
                font-size: 1.5rem;
            }
        }
    </style>

</x-layouts.landing>
