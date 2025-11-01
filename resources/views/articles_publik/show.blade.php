<x-layouts.landing>

    <div class="pt-32 pb-20 sm:pb-32 bg-black z-10 relative">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center">
                <span class="text-sm font-medium text-amber-400 uppercase tracking-widest">{{ $article->category }}</span>
                <h1 class="mt-2 font-serif text-4xl sm:text-5xl font-bold text-white">
                    {{ $article->title }}
                </h1>
                <p class="mt-4 text-lg text-gray-400">
                    Oleh <span class="text-white">{{ $article->author }}</span> &bull; {{ $article->created_at->format('d F Y') }}
                </p>
            </div>

            <img class="w-full h-auto aspect-[16/9] object-cover rounded-lg shadow-2xl my-12"
                 src="{{ Storage::url($article->image_url) ?? 'https://via.placeholder.com/800x450.png?text=Article+Image' }}"
                 alt="{{ $article->title }}">

            <div class="prose prose-invert prose-lg max-w-none text-gray-300 prose-headings:font-serif prose-headings:text-white prose-a:text-amber-400">
                {!! nl2br(e($article->content)) !!}
            </div>

            <a href="{{ route('public.articles.index') }}"
   class="font-medium text-amber-400 hover:text-amber-300 transition-colors">
    &larr; Kembali ke Semua Artikel
</a>

        </div>
    </div>

</x-layouts.landing>
