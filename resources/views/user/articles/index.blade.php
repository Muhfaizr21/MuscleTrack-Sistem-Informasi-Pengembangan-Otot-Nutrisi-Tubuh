@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6 text-gray-800">Artikel Terbaru</h1>

    @if($articles->count() > 0)
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($articles as $article)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-200">
                    @if($article->thumbnail)
                        <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-40 object-cover">
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold text-gray-900">
                            <a href="{{ route('user.articles.show', $article->id) }}">{{ $article->title }}</a>
                        </h2>
                        <p class="text-sm text-gray-500 mb-2">{{ $article->created_at->format('d M Y') }}</p>
                        <p class="text-gray-700 text-sm">{{ Str::limit(strip_tags($article->content), 100) }}</p>
                        <a href="{{ route('user.articles.show', $article->id) }}" class="text-blue-600 font-medium text-sm mt-3 inline-block hover:underline">Baca Selengkapnya →</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $articles->links() }}
        </div>
    @else
        <p class="text-gray-600">Belum ada artikel yang tersedia.</p>
    @endif
</div>
@endsection
