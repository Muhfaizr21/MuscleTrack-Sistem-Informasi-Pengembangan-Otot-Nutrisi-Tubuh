<x-layouts.landing>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-800 text-white pt-32 pb-20">
        <!-- Background Elements -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top,rgba(34,197,94,0.15),transparent)]"></div>
        <div class="absolute top-1/4 right-1/4 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
        <div class="absolute bottom-1/3 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10 text-center">
            <!-- Badge -->
            <div class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-green-500/15 backdrop-blur-sm border border-green-500/20 mb-8">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-sm font-semibold text-green-400 uppercase tracking-wider">Knowledge Base</span>
            </div>

            <h1 class="text-5xl sm:text-7xl font-bold bg-gradient-to-r from-green-400 via-emerald-400 to-teal-400 bg-clip-text text-transparent drop-shadow-lg">
                MuscleXpert</span> Journal
            </h1>
            <p class="mt-6 text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
                Bangun tubuh dan pikiran tangguh. Jelajahi arsip sains kebugaran, nutrisi, dan gaya hidup performa tinggi.
            </p>
            <div class="mt-10 flex flex-col sm:flex-row justify-center gap-4">
                <a href="#articles" class="px-8 py-4 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                    Jelajahi Artikel
                </a>
                <a href="/subscribe" class="px-8 py-4 rounded-xl border border-green-400/50 text-green-300 hover:bg-green-400/10 backdrop-blur-md transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                    </svg>
                    Gabung Komunitas
                </a>
            </div>
        </div>
    </section>

    <!-- Articles Grid -->
    <section id="articles" class="relative bg-gradient-to-b from-slate-900 to-slate-950 py-24">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient(circle, #22c55e 0.5px, transparent 0.5px); background-size: 40px 40px;"></div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">

            @if($articles->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($articles as $article)
                        <div class="group relative rounded-3xl overflow-hidden backdrop-blur-xl bg-slate-800/40 border border-slate-700/30 shadow-2xl shadow-black/30 hover:shadow-green-500/10 transition-all duration-500 transform hover:-translate-y-2">
                            <!-- Article Image -->
                            <a href="{{ route('public.articles.show', $article) }}" class="block relative overflow-hidden">
                                <img
                                    src="{{ Storage::url($article->image_url) ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2670&auto=format&fit=crop' }}"
                                    alt="{{ $article->title }}"
                                    class="w-full aspect-[16/10] object-cover group-hover:scale-110 transition-transform duration-700"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                <!-- Category Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-xs font-semibold tracking-widest uppercase bg-green-500/20 backdrop-blur-sm text-green-400 border border-green-500/30 rounded-full">
                                        {{ $article->category }}
                                    </span>
                                </div>
                            </a>

                            <!-- Article Content -->
                            <div class="p-6">
                                <a href="{{ route('public.articles.show', $article) }}" class="block">
                                    <h3 class="text-xl font-bold text-white group-hover:text-green-400 transition-colors duration-300 line-clamp-2">
                                        {{ $article->title }}
                                    </h3>
                                </a>
                                <p class="mt-3 text-slate-400 text-sm leading-relaxed line-clamp-3">
                                    {{ Str::limit(strip_tags($article->content), 120) }}
                                </p>

                                <!-- Article Meta -->
                                <div class="mt-4 flex items-center justify-between text-sm text-slate-500">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                            </svg>
                                        </div>
                                        <span>by Admin</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <span>{{ $article->created_at->format('M d, Y') }}</span>
                                    </div>
                                </div>

                                <!-- Read More -->
                                <div class="mt-4 pt-4 border-t border-slate-700/50">
                                    <a href="{{ route('public.articles.show', $article) }}"
                                       class="inline-flex items-center gap-2 text-green-400 hover:text-green-300 font-semibold text-sm transition-colors duration-300 group/read">
                                        <span>Baca Selengkapnya</span>
                                        <svg class="w-4 h-4 transform group-hover/read:translate-x-1 transition-transform duration-300"
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>

                            <!-- Hover Glow Effect -->
                            <div class="absolute inset-0 bg-gradient-to-br from-green-500/0 via-transparent to-transparent opacity-0 group-hover:opacity-10 transition-opacity duration-500 rounded-3xl"></div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-20 text-center">
                    {{ $articles->links('') }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-20">
                    <div class="w-24 h-24 mx-auto mb-6 bg-slate-800/40 rounded-3xl flex items-center justify-center">
                        <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-300 mb-2">Belum ada artikel</h3>
                    <p class="text-slate-500 max-w-md mx-auto">
                        Artikel sedang dalam persiapan. Nantikan update terbaru dari tim MuscleXpert!
                    </p>
                </div>
            @endif

        </div>
    </section>

    <style>
        /* Custom animations */
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.1; }
            50% { opacity: 0.2; }
        }
        .animate-pulse-slow {
            animation: pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Line clamp utilities */
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        .line-clamp-3 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;
        }

        /* Smooth transitions */
        * {
            transition-property: color, background-color, border-color, transform, box-shadow;
            transition-duration: 300ms;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>

</x-layouts.landing>
