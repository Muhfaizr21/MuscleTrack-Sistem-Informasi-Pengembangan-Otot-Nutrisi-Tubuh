@extends('layouts.user')

@section('content')
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 transition-all duration-300">

        {{-- 🔙 Back --}}
        <div class="mb-4">
            <a href="{{ route('user.articles.index') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline">
                ← Kembali ke Artikel
            </a>
        </div>

        {{-- 📰 Header Artikel --}}
        <h1 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-2">{{ $article->title }}</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">
            {{ $article->category ?? 'Umum' }} • {{ $article->created_at->format('d M Y') }}
        </p>

        {{-- 🖼️ Gambar --}}
        @if($article->image)
            <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}"
                class="w-full rounded-xl mb-6 shadow-md">
        @endif

        {{-- ✍️ Isi Artikel --}}
        <div class="prose dark:prose-invert max-w-none leading-relaxed text-gray-800 dark:text-gray-200">
            {!! nl2br(e($article->content)) !!}
        </div>

        {{-- ⏭ Navigasi Artikel --}}
        <div class="flex justify-between items-center border-t border-gray-200 dark:border-gray-700 mt-10 pt-5">
            @if($previous)
                <a href="{{ route('user.articles.show', $previous->slug) }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    ← {{ Str::limit($previous->title, 40) }}
                </a>
            @else
                <span></span>
            @endif

            @if($next)
                <a href="{{ route('user.articles.show', $next->slug) }}"
                    class="text-indigo-600 dark:text-indigo-400 hover:underline">
                    {{ Str::limit($next->title, 40) }} →
                </a>
            @endif
        </div>

        {{-- 📚 Artikel Terkait --}}
        @if($relatedArticles->count())
            <div class="mt-10">
                <h3 class="text-lg font-semibold text-indigo-700 dark:text-indigo-300 mb-4">Artikel Terkait</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @foreach($relatedArticles as $related)
                        <a href="{{ route('user.articles.show', $related->slug) }}"
                            class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 hover:shadow-lg transition">
                            <h4 class="font-bold text-gray-800 dark:text-gray-100 mb-1">{{ Str::limit($related->title, 50) }}</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ Str::limit($related->summary, 80) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection