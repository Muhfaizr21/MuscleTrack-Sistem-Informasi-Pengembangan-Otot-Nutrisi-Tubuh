<x-layouts.landing>

    <div class="pt-32 pb-16 bg-black z-10 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="font-serif text-5xl sm:text-7xl font-bold text-white">
                The <span class="text-amber-400">Journal</span>
            </h1>
            <p class="mt-4 text-lg text-gray-400 max-w-2xl">
                Pengetahuan adalah kekuatan. Telusuri arsip kami untuk ilmu di balik otot, nutrisi, dan gaya hidup kebugaran.
            </p>
        </div>
    </div>

    <div class="bg-black z-10 relative pb-20 sm:pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if($articles->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-16">

                    @foreach($articles as $article)
                        <div class="group">
                            <a href="{{ route('articles.show', $article) }}" class="block">
                                <img class="w-full h-auto aspect-[16/10] object-cover rounded-lg shadow-2xl group-hover:opacity-80 transition-opacity"
                                     src="{{ Storage::url($article->image_url) ?? 'https://via.placeholder.com/600x400.png?text=Article+Image' }}"
                                     alt="{{ $article->title }}">
                            </a>
                            <div class="mt-4">
                                <span class="text-sm font-medium text-amber-400 uppercase tracking-widest">{{ $article->category }}</span>
                                <a href="{{ route('articles.show', $article) }}" class="block mt-1">
                                    <h3 class="font-serif text-2xl font-bold text-white group-hover:text-gray-200 transition-colors">
                                        {{ $article->title }}
                                    </h3>
                                </a>
                                <p class="mt-3 text-gray-400 text-sm">
                                    {{ Str::limit($article->content, 120) }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="mt-16 text-white">
                    {{ $articles->links() }}
                </div>
            @else
                <p class="text-lg text-gray-400">Belum ada artikel yang dipublikasikan.</p>
            @endif

        </div>
    </div>

</x-layouts.landing>
