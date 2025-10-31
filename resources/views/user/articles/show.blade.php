@extends('layouts.user')

@section('content')
<div class="container mx-auto px-4 py-6">
    <a href="{{ route('user.articles.index') }}" class="text-blue-600 hover:underline mb-4 inline-block">← Kembali ke daftar artikel</a>

    <div class="bg-white rounded-xl shadow-md p-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-3">{{ $article->title }}</h1>
        <p class="text-gray-500 text-sm mb-6">Dipublikasikan pada {{ $article->created_at->format('d M Y') }}</p>

        @if($article->thumbnail)
            <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-64 object-cover rounded-lg mb-6">
        @endif

        <div class="prose max-w-none text-gray-800">
            {!! $article->content !!}
        </div>
    </div>
</div>
@endsection
