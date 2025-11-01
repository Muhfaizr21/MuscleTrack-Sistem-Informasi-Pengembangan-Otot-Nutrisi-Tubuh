<x-layouts.admin>
    <x-slot name="title">
        Manajemen <span class="text-amber-400">Artikel</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">

        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white">
                    Daftar <span class="text-amber-400">Artikel</span>
                </h3>
                <p class="text-sm text-gray-400 mt-1">Semua artikel yang telah dipublikasikan.</p>
            </div>
            <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                Tulis Artikel Baru
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-500/20 text-green-300 border-b border-gray-700/50">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Artikel</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($articles as $article)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ $article->image_url }}" alt="">
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-white">{{ Str::limit($article->title, 50) }}</div>
                                    <div class="text-sm text-gray-500">{{ $article->slug }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-500/20 text-amber-300">
                                {{ $article->category ?? 'Umum' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $article->author }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $article->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.articles.edit', $article) }}" class="text-amber-400 hover:text-amber-300">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            Belum ada artikel.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-gray-700/50">
            {{ $articles->links() }}
        </div>
    </div>
</x-layouts.admin>
