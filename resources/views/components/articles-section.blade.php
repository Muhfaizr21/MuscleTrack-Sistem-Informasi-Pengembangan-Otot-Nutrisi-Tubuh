@props(['articles'])

<section id="articles" class="relative py-20 sm:py-32 bg-slate-900 overflow-hidden">
    {{-- Background Elements --}}
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-slate-800/20 to-slate-900"></div>
    <div class="absolute top-0 right-0 w-1/3 h-1/3 bg-green-500/5 blur-[120px] rounded-full"></div>
    <div class="absolute bottom-0 left-0 w-1/4 h-1/4 bg-blue-500/5 blur-[100px] rounded-full"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="text-left max-w-3xl mb-20 animate-fade-in-up">
            <div
                class="inline-flex items-center gap-3 px-5 py-3 rounded-2xl bg-green-500/10 backdrop-blur-sm border border-green-500/20 mb-6">
                <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                <span class="text-sm font-semibold text-green-400 uppercase tracking-wider">Knowledge Center</span>
            </div>
            <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6">
                Fitness <span
                    class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Journal</span>
            </h2>
            <p class="text-xl text-slate-400 leading-relaxed">
                Pengetahuan adalah kekuatan. Pelajari ilmu di balik otot dan nutrisi dari para ahli kami.
            </p>
        </div>

        @if($articles && $articles->count() > 0)
            <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">

                @php
                    $featured = $articles->first();
                @endphp

                {{-- Featured Article --}}
                <div class="lg:col-span-7 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div
                        class="group relative overflow-hidden rounded-3xl bg-slate-800/30 backdrop-blur-lg border border-slate-700/30 transition-all duration-500 hover:shadow-2xl hover:shadow-green-500/10">
                        {{-- Image --}}
                        <div class="relative overflow-hidden rounded-t-3xl">
                            <img class="w-full h-[400px] object-cover transition-transform duration-700 group-hover:scale-105"
                                src="{{ Storage::url($featured->image_url) ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2670&auto=format&fit=crop' }}"
                                alt="{{ $featured->title }}">
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/40 to-transparent">
                            </div>
                            {{-- Category Badge --}}
                            <div class="absolute top-6 left-6">
                                <span
                                    class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-green-500/15 backdrop-blur-sm border border-green-500/20">
                                    <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                                    <span class="text-sm font-semibold text-green-400 uppercase tracking-wider">
                                        {{ $featured->category ?? 'Fitness' }}
                                    </span>
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="p-8">
                            <a href="{{ route('articles.show', $featured) }}" class="block group/title mb-4">
                                <h3
                                    class="text-3xl font-bold text-white group-hover/title:text-green-400 transition-colors duration-300 leading-tight">
                                    {{ $featured->title }}
                                </h3>
                            </a>
                            <p class="text-slate-400 text-lg leading-relaxed mb-6">
                                {{ Str::limit(strip_tags($featured->content), 200) }}
                            </p>
                            <div class="flex items-center justify-between">
                                <a href="{{ route('articles.show', $featured) }}"
                                    class="inline-flex items-center gap-3 font-semibold text-green-400 hover:text-green-300 transition-colors duration-300 group/read">
                                    <span>Baca Selengkapnya</span>
                                    <svg class="w-5 h-5 transform group-hover/read:translate-x-2 transition-transform duration-300"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </a>
                                <div class="text-sm text-slate-500">
                                    {{ $featured->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Article List --}}
                <div class="lg:col-span-5 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-2 h-8 bg-gradient-to-b from-green-400 to-blue-500 rounded-full"></div>
                        <h4 class="text-2xl font-bold text-white">Artikel Terbaru Lainnya</h4>
                    </div>

                    <div class="space-y-6">
                        @foreach($articles->skip(1) as $index => $article)
                            <a href="{{ route('articles.show', $article) }}"
                                class="group block p-6 bg-slate-800/30 hover:bg-slate-800/40 rounded-2xl backdrop-blur-lg border border-slate-700/30 hover:border-slate-600/50 transition-all duration-300 transform hover:-translate-y-1">
                                <div class="flex items-start gap-5">
                                    {{-- Number Badge --}}
                                    <div
                                        class="flex-shrink-0 w-14 h-14 bg-gradient-to-br from-green-500/15 to-emerald-600/15 rounded-2xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                        <span class="text-xl font-bold text-green-400">0{{ $index + 1 }}</span>
                                    </div>

                                    {{-- Content --}}
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="w-1.5 h-1.5 bg-green-400 rounded-full"></span>
                                            <span class="text-xs text-slate-500 uppercase tracking-wider font-semibold">
                                                {{ $article->category ?? 'Fitness' }}
                                            </span>
                                        </div>
                                        <h5
                                            class="text-lg font-bold text-white group-hover:text-green-400 transition-colors duration-300 leading-tight">
                                            {{ $article->title }}
                                        </h5>
                                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">
                                            {{ Str::limit(strip_tags($article->content), 100) }}
                                        </p>
                                        <div class="flex items-center justify-between mt-4">
                                            <span class="text-sm text-slate-500">
                                                {{ $article->created_at->diffForHumans() }}
                                            </span>
                                            <svg class="w-4 h-4 text-slate-500 transform group-hover:translate-x-1 transition-transform duration-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- View All Button --}}
                    <div class="mt-8 text-center lg:text-left">
                        <a href="{{ route('public.articles.index') }}"
                            class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-base font-semibold text-white bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-green-500/25">
                            <span>Lihat Semua Artikel</span>
                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform duration-300"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        @else
            {{-- Empty State --}}
            <div class="text-center py-20 animate-fade-in-up">
                <div class="w-24 h-24 bg-slate-800/50 rounded-3xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-4">Belum Ada Artikel</h3>
                <p class="text-slate-400 text-lg max-w-md mx-auto">
                    Artikel terbaru akan segera tersedia. Pantau terus untuk update terbaru seputar fitness dan nutrisi.
                </p>
            </div>
        @endif
    </div>
</section>

<style>
    .animate-fade-in-up {
        opacity: 0;
        animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
    }

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

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>