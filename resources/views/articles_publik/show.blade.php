<x-layouts.landing>

    <!-- Article Detail - NeoFit AI Style -->
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-800 text-white pt-32 pb-24">
        <!-- subtle radial glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(16,185,129,0.12),transparent_70%)]"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10">

            <!-- Header -->
            <div class="text-center mb-14">
                <span class="text-sm font-semibold tracking-widest uppercase text-emerald-400 bg-emerald-500/10 border border-emerald-500/20 rounded-full px-4 py-2">
                    {{ $article->category ?? 'Artikel' }}
                </span>
                <h1 class="mt-6 text-4xl sm:text-6xl font-extrabold bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent drop-shadow-md">
                    {{ $article->title }}
                </h1>
                <div class="mt-5 flex items-center justify-center gap-4 text-base text-gray-400">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500/20 to-cyan-600/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <span class="text-white font-medium">{{ $article->author ?? 'Admin MuscleXpert' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ $article->created_at->format('d F Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Image -->
            <div class="relative group rounded-2xl overflow-hidden shadow-2xl shadow-emerald-500/10 mb-12 border border-slate-700/50">
                @if($article->image)
                    @if(filter_var($article->image, FILTER_VALIDATE_URL))
                        <!-- Jika gambar adalah URL eksternal -->
                        <img
                            src="{{ $article->image }}"
                            alt="{{ $article->title }}"
                            class="w-full aspect-[16/9] object-cover transform group-hover:scale-[1.02] transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2670&auto=format&fit=crop'"
                        >
                    @else
                        <!-- Jika gambar disimpan di storage lokal -->
                        @php
                            $imagePath = $article->image;
                            // Hapus 'storage/' dari depan jika ada
                            if (strpos($imagePath, 'storage/') === 0) {
                                $imagePath = substr($imagePath, 8);
                            }
                        @endphp
                        <img
                            src="{{ asset('storage/' . $imagePath) }}"
                            alt="{{ $article->title }}"
                            class="w-full aspect-[16/9] object-cover transform group-hover:scale-[1.02] transition-transform duration-500"
                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2670&auto=format&fit=crop'"
                        >
                    @endif
                @else
                    <!-- Fallback jika tidak ada gambar -->
                    <div class="w-full aspect-[16/9] bg-gradient-to-br from-emerald-500/20 to-cyan-600/20 flex items-center justify-center">
                        <svg class="w-20 h-20 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            </div>

            <!-- Content -->
            <div class="backdrop-blur-xl bg-slate-800/40 border border-slate-700/30 rounded-2xl p-8 shadow-lg shadow-emerald-500/10 mb-12">
                <article class="prose prose-invert prose-lg max-w-none text-gray-300 leading-relaxed
                              prose-headings:text-white prose-headings:font-bold prose-headings:tracking-tight
                              prose-h1:text-3xl prose-h2:text-2xl prose-h3:text-xl
                              prose-p:text-gray-300 prose-p:leading-relaxed prose-p:my-4
                              prose-strong:text-emerald-300
                              prose-a:text-cyan-400 hover:prose-a:text-emerald-300 prose-a:transition-colors
                              prose-blockquote:border-l-4 prose-blockquote:border-emerald-500 prose-blockquote:pl-4 prose-blockquote:italic
                              prose-ul:list-disc prose-ul:pl-6 prose-ul:text-gray-300
                              prose-ol:list-decimal prose-ol:pl-6 prose-ol:text-gray-300
                              prose-li:my-1">
                    {!! $article->content !!}
                </article>
            </div>

            <!-- Tags -->
            @if($article->tags)
                <div class="mb-12">
                    <h3 class="text-lg font-semibold text-white mb-4">Tags:</h3>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $tags = is_string($article->tags) ? explode(',', $article->tags) : $article->tags;
                        @endphp
                        @foreach($tags as $tag)
                            <span class="px-3 py-1.5 text-sm bg-slate-800/50 text-slate-300 border border-slate-700 rounded-full hover:bg-slate-700/50 transition-colors">
                                {{ trim($tag) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Share Buttons -->
            <div class="mb-12 p-6 bg-slate-800/30 rounded-2xl border border-slate-700/30">
                <h3 class="text-lg font-semibold text-white mb-4">Bagikan Artikel:</h3>
                <div class="flex gap-3">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                       target="_blank"
                       class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl transition-colors duration-300 fix-clickable-link">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span>Facebook</span>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ urlencode($article->title) }}"
                       target="_blank"
                       class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-sky-500 hover:bg-sky-600 text-white rounded-xl transition-colors duration-300 fix-clickable-link">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        <span>Twitter</span>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($article->title . ' - ' . url()->current()) }}"
                       target="_blank"
                       class="flex-1 flex items-center justify-center gap-2 px-4 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl transition-colors duration-300 fix-clickable-link">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.675-.236-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.438 9.88-9.888 9.88m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                </div>
            </div>

            <!-- Related Articles -->
            @if($relatedArticles->count() > 0)
                <div class="mb-12">
                    <h3 class="text-2xl font-bold text-white mb-8">Artikel Terkait</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($relatedArticles as $related)
                            <a href="/articles/{{ $related->slug }}"
                               class="group bg-slate-800/30 border border-slate-700/30 rounded-2xl p-6 hover:border-emerald-500/30 hover:bg-slate-800/50 transition-all duration-300 fix-clickable-link">
                                <h4 class="text-lg font-bold text-white group-hover:text-emerald-400 transition-colors mb-2">
                                    {{ $related->title }}
                                </h4>
                                <p class="text-slate-400 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit(strip_tags($related->content ?? ''), 100) }}
                                </p>
                                <div class="flex items-center justify-between text-sm text-slate-500">
                                    <span>{{ $related->created_at->format('d M Y') }}</span>
                                    <span class="text-emerald-400 group-hover:translate-x-1 transition-transform">Baca →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Back Link -->
            <div class="text-center pt-8 border-t border-slate-700/50">
                <a href="/articles"
                   class="inline-flex items-center gap-2 px-8 py-3 rounded-xl bg-gradient-to-r from-emerald-500 to-cyan-600 text-white font-semibold hover:from-emerald-600 hover:to-cyan-700 transition-all hover:shadow-lg hover:shadow-emerald-500/20 hover:-translate-y-0.5 duration-300 fix-clickable-link">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Semua Artikel
                </a>
                <p class="mt-4 text-slate-500 text-sm">
                    Temukan lebih banyak tips & panduan di MuscleXpert Journal
                </p>
            </div>
        </div>
    </section>

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* FIX: Force semua link artikel bisa diklik */
        .fix-clickable-link {
            pointer-events: auto !important;
            cursor: pointer !important;
            position: relative;
            z-index: 9999 !important;
        }

        /* FIX: Pastikan parent tidak nge-block */
        .group .fix-clickable-link,
        .group\/* .fix-clickable-link,
        [class*="group"] .fix-clickable-link {
            pointer-events: auto !important;
        }

        /* FIX: Pastikan tidak ada overlay yang nge-block */
        .absolute.inset-0 {
            pointer-events: none !important;
        }

        /* Pastikan gambar tidak overflow */
        img {
            max-width: 100%;
            height: auto;
        }
    </style>

</x-layouts.landing>
