<x-layouts.admin>
    <x-slot name="title">
        Manajemen <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Artikel</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Daftar <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Artikel</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Kelola semua artikel yang telah dipublikasikan</p>
                </div>
                <a href="{{ route('admin.articles.create') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Tulis Artikel Baru
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="p-4 bg-green-500/15 backdrop-blur-sm text-green-400 border-b border-green-500/20">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead class="bg-slate-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Artikel</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Author</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Tanggal</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($articles as $article)
                    <tr class="hover:bg-slate-700/20 transition-colors duration-300">
                        <!-- Article Column -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl overflow-hidden">
                                    <img class="w-12 h-12 object-cover"
                                         src="{{ $article->image_url ?? 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2670&auto=format&fit=crop' }}"
                                         alt="{{ $article->title }}"
                                         onerror="this.src='https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2670&auto=format&fit=crop'">
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-white line-clamp-2">{{ $article->title }}</div>
                                    <div class="text-xs text-slate-400 mt-1 line-clamp-1">{{ $article->slug }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        <span class="text-xs text-slate-500">{{ $article->views ?? 0 }} views</span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <!-- Category Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                {{ $article->category ?? 'Umum' }}
                            </span>
                        </td>

                        <!-- Author Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-slate-600/50 rounded-full flex items-center justify-center">
                                    <span class="text-xs font-semibold text-slate-300">
                                        {{ strtoupper(substr($article->author, 0, 1)) }}
                                    </span>
                                </div>
                                <span class="text-sm text-slate-300">{{ $article->author }}</span>
                            </div>
                        </td>

                        <!-- Status Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                Published
                            </span>
                        </td>

                        <!-- Date Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $article->created_at->format('d M Y') }}
                            </div>
                        </td>

                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('public.articles.show', $article) }}"
                                   target="_blank"
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-300 flex items-center gap-1"
                                   title="Lihat Artikel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.articles.edit', $article) }}"
                                   class="text-green-400 hover:text-green-300 transition-colors duration-300 flex items-center gap-1"
                                   title="Edit Artikel">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.articles.destroy', $article) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus artikel \"{{ $article->title }}\"?')"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-300 flex items-center gap-1"
                                            title="Hapus Artikel">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 12h6M7 8h6"/>
                                </svg>
                                <p class="text-lg font-semibold">Belum ada artikel</p>
                                <p class="text-sm mt-1">Mulai dengan menulis artikel pertama Anda</p>
                                <a href="{{ route('admin.articles.create') }}"
                                   class="mt-4 px-6 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Tulis Artikel Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($articles->hasPages())
        <div class="p-6 border-t border-slate-700/50">
            {{ $articles->links() }}
        </div>
        @endif
    </div>

    <style>
        .line-clamp-1 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 1;
        }
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
    </style>

</x-layouts.admin>
