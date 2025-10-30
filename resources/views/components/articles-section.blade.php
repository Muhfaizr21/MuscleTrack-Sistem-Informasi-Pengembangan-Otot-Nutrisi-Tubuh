@props(['articles'])

<section id="articles" class="py-20 sm:py-32 bg-black z-10 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="text-left max-w-2xl">
            <h2 class="font-serif text-4xl sm:text-5xl font-bold text-white">
                The <span class="text-amber-400">Journal</span>
            </h2>
            <p class="mt-6 text-lg text-gray-400">
                Pengetahuan adalah kekuatan. Pelajari ilmu di balik otot dan nutrisi dari para ahli kami.
            </p>
        </div>

        @if($articles && $articles->count() > 0)
            <div class="mt-20 grid lg:grid-cols-12 gap-x-12 gap-y-16">

                @php
                    $featured = $articles->first();
                @endphp
                <div class="lg:col-span-7">
                    <div class="relative">
                        <a href="{{ route('articles.show', $featured) }}" class="block">
                            <img class="w-full h-auto aspect-[16/10] object-cover rounded-lg shadow-2xl"
                                 src="{{ Storage::url($featured->image_url) ?? 'https://via.placeholder.com/600x400.png?text=Article+Image' }}"
                                 alt="{{ $featured->title }}">
                        </a>

                        <div class="relative lg:-mt-16 lg:ml-8 z-10">
                            <div class="p-8 bg-black/80 backdrop-blur-lg border border-gray-700/50 rounded-lg shadow-xl">
                                <span class="text-sm font-medium text-amber-400 uppercase tracking-widest">{{ $featured->category ?? 'News' }}</span>
                                <a href="{{ route('articles.show', $featured) }}" class="block mt-2">
                                    <h3 class="font-serif text-3xl font-bold text-white hover:text-gray-200 transition-colors">
                                        {{ $featured->title }}
                                    </h3>
                                </a>
                                <p class="mt-4 text-gray-400">
                                    {{ Str::limit($featured->content, 150) }}
                                </p>
                                <a href="{{ route('articles.show', $featured) }}" class="mt-6 inline-block font-bold text-amber-400 hover:text-amber-300 transition-colors">
                                    Baca Selengkapnya &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <h4 class="text-2xl font-serif font-bold text-white">Artikel Terbaru Lainnya</h4>

                    <div class="mt-8 space-y-10">

                        @foreach($articles->skip(1) as $index => $article)
                            <div class="group relative">
                                <div class="absolute -left-4 -top-2 font-serif text-7xl font-bold text-gray-800/50 z-0 opacity-50">0{{ $index + 1 }}</div>
                                <div class="relative z-10 pl-8 border-l-2 border-amber-500/30 group-hover:border-amber-400 transition-all duration-300">
                                    <span class="text-sm text-gray-500 uppercase tracking-widest">{{ $article->category ?? 'News' }}</span>
                                    <a href="{{ route('articles.show', $article) }}" class="block mt-1">
                                        <h5 class="font-serif text-xl font-bold text-white group-hover:text-amber-400 transition-all duration-300">
                                            {{ $article->title }}
                                        </h5>
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <a href="{{ route('articles.index') }}"
                       class="inline-block mt-12 px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                        Lihat Semua Artikel
                    </a>

                </div>

            </div>
        @endif
    </div>
</section>
