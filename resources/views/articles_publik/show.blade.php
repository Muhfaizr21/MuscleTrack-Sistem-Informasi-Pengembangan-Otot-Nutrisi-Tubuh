<x-layouts.landing>

    <!-- Article Detail - NeoFit AI Style -->
    <section class="relative overflow-hidden bg-gradient-to-b from-slate-950 via-slate-900 to-slate-800 text-white pt-32 pb-24">
        <!-- subtle radial glow -->
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(16,185,129,0.12),transparent_70%)]"></div>

        <div class="max-w-4xl mx-auto px-6 relative z-10">

            <!-- Header -->
            <div class="text-center mb-14">
                <span class="text-sm font-semibold tracking-widest uppercase text-emerald-400">
                    {{ $article->category }}
                </span>
                <h1 class="mt-3 text-4xl sm:text-6xl font-extrabold bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-500 bg-clip-text text-transparent drop-shadow-md">
                    {{ $article->title }}
                </h1>
                <p class="mt-5 text-base text-gray-400">
                    Oleh <span class="text-white font-medium">{{ $article->author }}</span>
                    &bull; {{ $article->created_at->format('d F Y') }}
                </p>
            </div>

            <!-- Image -->
            <div class="relative group rounded-2xl overflow-hidden shadow-2xl shadow-emerald-500/10 mb-12">
                <img
                    src="{{ Storage::url($article->image_url) ?? 'https://via.placeholder.com/800x450.png?text=Article+Image' }}"
                    alt="{{ $article->title }}"
                    class="w-full aspect-[16/9] object-cover transform group-hover:scale-[1.02] transition-transform duration-500"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950/40 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>

            <!-- Content -->
            <div class="backdrop-blur-xl bg-white/5 border border-white/10 rounded-2xl p-8 shadow-lg shadow-emerald-500/10">
                <article class="prose prose-invert prose-lg max-w-none text-gray-300 leading-relaxed prose-headings:font-serif prose-headings:text-emerald-300 prose-a:text-cyan-400 hover:prose-a:text-emerald-300 transition-colors">
                    {!! nl2br(e($article->content)) !!}
                </article>
            </div>

            <!-- Back Link -->
            <div class="mt-12 text-center">
                <a href="{{ route('public.articles.index') }}"
                   class="inline-flex items-center gap-2 px-6 py-3 rounded-xl border border-emerald-400/40 text-emerald-300 hover:bg-emerald-400/10 transition-all hover:shadow-emerald-500/20 hover:-translate-y-0.5 duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali ke Semua Artikel
                </a>
            </div>
        </div>
    </section>

</x-layouts.landing>
