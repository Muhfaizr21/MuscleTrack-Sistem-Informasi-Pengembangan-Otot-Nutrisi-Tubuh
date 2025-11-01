@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

        {{-- 🔙 Back (Style "Dark Premium") --}}
        <div class="mb-4">
            <a href="{{ route('user.articles.index') }}" class="text-amber-400 hover:text-amber-300 font-medium hover:underline">
                ← Kembali ke Artikel
            </a>
        </div>

        {{-- 📰 Header Artikel (Style "Dark Premium" Editorial) --}}
        <h1 class="font-serif text-3xl font-bold text-amber-400 mb-2">{{ $article->title }}</h1>
        <p class="text-sm text-gray-400 mb-4">
            {{ $article->category ?? 'Umum' }} • {{ $article->created_at->format('d M Y') }}
        </p>

        {{-- 🖼️ Gambar (Style "Dark Premium") --}}
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                class="w-full rounded-xl mb-6 border border-gray-700/50">
        @endif

        {{-- ✍️ Isi Artikel (Style "Dark Premium" Prose) --}}
        <div classS="prose prose-invert max-w-none leading-relaxed prose-headings:text-amber-400 prose-a:text-amber-400">
            {!! nl2br(e($article->content)) !!}
        </div>

        {{-- ⏭ Navigasi Artikel (Style "Dark Premium") --}}
        <div class="flex justify-between items-center border-t border-gray-700/50 mt-10 pt-5">
            @if($previous)
                <a href="{{ route('user.articles.show', $previous->slug) }}"
                    class="text-amber-400 hover:text-amber-300 hover:underline">
                    ← {{ Str::limit($previous->title, 40) }}
                </a>
            @else
                <span></span> @endif

            @if($next)
                <a href="{{ route('user.articles.show', $next->slug) }}"
                    class="text-amber-400 hover:text-amber-300 hover:underline">
                    {{ Str::limit($next->title, 40) }} →
                </a>
            @endif
        </div>

        {{-- 📚 Artikel Terkait (Style "Dark Premium") --}}
        @if($relatedArticles->count())
            <div class="mt-10 border-t border-gray-700/50 pt-6">
                <h3 class="font-serif text-xl font-bold text-white mb-4">Artikel <span class="text-amber-400">Terkait</span></h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                    @foreach($relatedArticles as $related)
                        <a href="{{ route('user.articles.show', $related->slug) }}"
                            class="group bg-gray-900/50 border border-gray-700/50 rounded-lg p-4 hover:border-amber-400/50 transition-all">

                            <h4 class="font-bold text-white mb-1 group-hover:text-amber-400 transition-colors">{{ Str::limit($related->title, 50) }}</h4>

                            <p class="text-sm text-gray-400">{{ Str::limit($related->summary, 80) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
