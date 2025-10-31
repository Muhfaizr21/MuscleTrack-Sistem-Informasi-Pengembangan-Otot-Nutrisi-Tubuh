@extends('layouts.user')

@section('content')
<div class="bg-white dark:bg-gray-900 shadow-md rounded-2xl p-6 transition-all duration-300">

    {{-- 🔔 Notifikasi Artikel Baru --}}
    @if($showNotification)
        <div class="bg-indigo-50 dark:bg-indigo-900/40 border-l-4 border-indigo-500 p-4 mb-6 rounded-lg flex items-center gap-3">
            📰 <span class="text-indigo-800 dark:text-indigo-200">
                Ada <strong>{{ $newArticlesCount }}</strong> artikel baru minggu ini! Yuk, baca sekarang 💪
            </span>
        </div>
    @endif

    {{-- 🏷️ Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h2 class="text-2xl font-bold text-indigo-700 dark:text-indigo-300 flex items-center gap-2">
            📚 Tips & Articles
        </h2>
        <span class="text-gray-500 dark:text-gray-400 text-sm">
            Inspirasi & edukasi seputar fitness, nutrisi, dan gaya hidup sehat 🌱
        </span>
    </div>

    {{-- 📰 Daftar Artikel --}}
    @if($articles->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articles as $article)
                <a href="{{ route('user.articles.show', $article->slug) }}" 
                   class="group block bg-gray-50 dark:bg-gray-800 rounded-xl overflow-hidden shadow hover:shadow-lg transition-all duration-300">
                    @if($article->image)
                        <img src="{{ asset('storage/'.$article->image) }}" alt="{{ $article->title }}"
                             class="h-40 w-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="h-40 w-full bg-gradient-to-r from-indigo-500 to-blue-500 flex items-center justify-center text-white text-3xl font-bold">
                            💡
                        </div>
                    @endif

                    <div class="p-4">
                        <span class="text-xs uppercase text-indigo-600 dark:text-indigo-400 font-semibold">{{ $article->category ?? 'Umum' }}</span>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mt-1 group-hover:text-indigo-500 dark:group-hover:text-indigo-300 transition">
                            {{ Str::limit($article->title, 70) }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">{{ Str::limit($article->summary, 100) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">{{ $article->created_at->format('d M Y') }}</p>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $articles->links('pagination::tailwind') }}
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400 italic text-center py-8">
            Belum ada artikel untuk saat ini.
        </p>
    @endif

    {{-- 🧠 Tips Reminder --}}
    <div class="bg-yellow-50 dark:bg-yellow-900 border-l-4 border-yellow-400 text-yellow-800 dark:text-yellow-100 p-4 mt-8 rounded-lg">
        <div class="flex items-center gap-2">
            💬 <strong>Tips:</strong>
            <span>Baca 1 artikel setiap minggu untuk tambah ilmu dan semangat baru 💪</span>
        </div>
    </div>
</div>
@endsection
