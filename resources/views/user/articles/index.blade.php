@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 transition-all duration-300">

    {{-- 🔔 Notifikasi Artikel Baru (Style "Dark Premium" Emas) --}}
    @if($showNotification)
        <div class="bg-amber-900/50 border-l-4 border-amber-400 p-4 mb-6 rounded-lg flex items-center gap-3">
            📰 <span class="text-amber-200">
                Ada <strong class="text-amber-100">{{ $newArticlesCount }}</strong> artikel baru minggu ini! Yuk, baca sekarang 💪
            </span>
        </div>
    @endif

    {{-- 🏷️ Header (Style "Dark Premium") --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            📚 Tips & <span class="text-amber-400">Articles</span>
        </h2>
        <span class="text-gray-400 text-sm italic">
            Inspirasi & edukasi seputar fitness, nutrisi, dan gaya hidup sehat 🌱
        </span>
    </div>

    {{-- 📰 Daftar Artikel --}}
    @if($articles->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            @foreach($articles as $article)
                <a href="{{ route('user.articles.show', $article->slug) }}"
                   class="group block bg-gray-900/50 border border-gray-700/50 rounded-xl overflow-hidden transition-all duration-300 hover:border-amber-400/50">

                    @if($article->image)
                        <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}"
                             class="h-40 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="h-40 w-full bg-gradient-to-r from-gray-800 to-gray-900 flex items-center justify-center text-white text-3xl font-bold">
                            💡
                        </div>
                    @endif

                    <div class="p-4">
                        <span class="text-xs uppercase text-amber-400 font-semibold">{{ $article->category ?? 'Umum' }}</span>

                        <h3 class="font-serif text-lg font-bold text-white mt-1 group-hover:text-amber-400 transition">
                            {{ Str::limit($article->title, 70) }}
                        </h3>

                        <p class="text-sm text-gray-300 mt-2">{{ Str::limit($article->summary, 100) }}</p>

                        <p class="text-xs text-gray-500 mt-3">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination (Sistem Anda aman) --}}
        <div class="mt-8">
            {{ $articles->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-gray-400 italic text-center py-8">
            Belum ada artikel untuk saat ini.
        </p>
    @endif

    {{-- 🧠 Tips Reminder (Style "Dark Premium" Kuning) --}}
    <div class="bg-yellow-900/50 border-l-4 border-yellow-400 text-yellow-200 p-4 mt-8 rounded-lg">
        <div class="flex items-center gap-2">
            💬 <strong class="text-yellow-300">Tips:</strong>
            <span>Baca 1 artikel setiap minggu untuk tambah ilmu dan semangat baru 💪</span>
        </div>
    </div>
</div>
@endsection
