<x-layouts.admin>
    <x-slot name="title">
        Community <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">Reports</span>
    </x-slot>

    <!-- Success Message -->
    @if(session('success'))
        <div class="p-4 bg-green-500/15 backdrop-blur-sm text-green-400 border border-green-500/20 rounded-xl mb-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('warning'))
        <div class="p-4 bg-orange-500/15 backdrop-blur-sm text-orange-400 border border-orange-500/20 rounded-xl mb-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('warning') }}
            </div>
        </div>
    @endif

    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-red-600 rounded-2xl flex items-center justify-center shadow-lg shadow-orange-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Community <span class="bg-gradient-to-r from-orange-400 to-red-500 bg-clip-text text-transparent">Reports</span>
                        </h1>
                        <p class="text-orange-400/80 text-lg mt-2">Moderasi dan laporan komunitas</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.communities.dashboard') }}"
                       class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-slate-300 hover:text-white transition-all duration-300 border border-slate-600 hover:bg-slate-700/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                        </svg>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Reported Posts -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-orange-500/20 rounded-2xl p-6 shadow-lg shadow-orange-500/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="text-orange-400">🚨 Reported Posts</span>
                </h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($reportedPosts as $post)
                    <div class="p-4 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300 border border-orange-500/20">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="text-white font-medium text-sm">{{ $post->user->name }}</p>
                                        <p class="text-gray-400 text-xs">in <span class="text-orange-400">{{ $post->community->name }}</span></p>
                                    </div>
                                    <span class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300 text-sm line-clamp-2 leading-relaxed mb-3">
                                    {{ Str::limit(strip_tags($post->content), 120) }}
                                </p>
                                <div class="flex items-center gap-2">
                                    <form action="{{ route('admin.communities.posts.destroy', $post) }}" method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Hapus postingan ini? Tindakan ini tidak dapat dibatalkan!')"
                                                class="w-full px-3 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30 rounded-xl text-red-400 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                            Hapus Post
                                        </button>
                                    </form>
                                    <a href="{{ route('user.communities.show', $post->community) }}"
                                       target="_blank"
                                       class="flex-1 text-center px-3 py-2 bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/20 hover:border-blue-500/30 rounded-xl text-blue-400 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>Tidak ada postingan yang dilaporkan</p>
                        <p class="text-sm mt-1">Semua postingan aman dan sesuai aturan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Problematic Communities -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-red-500/20 rounded-2xl p-6 shadow-lg shadow-red-500/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="text-red-400">⚠️ Problematic Communities</span>
                </h3>
                <div class="space-y-4">
                    @forelse($problematicCommunities as $community)
                    <div class="p-4 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300 border border-red-500/20">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                @if($community->image)
                                    <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-sm">{{ substr($community->name, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-white font-medium">{{ $community->name }}</h4>
                                    <p class="text-gray-400 text-xs">by {{ $community->creator->name }}</p>
                                </div>
                            </div>
                            <span class="text-red-400 text-sm font-bold">{{ $community->members_count }} members</span>
                        </div>

                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div class="text-center p-2 bg-red-500/10 rounded-lg">
                                <div class="text-red-400 font-bold">{{ $community->members_count }}</div>
                                <div class="text-gray-400">Members</div>
                            </div>
                            <div class="text-center p-2 bg-orange-500/10 rounded-lg">
                                <div class="text-orange-400 font-bold">{{ $community->posts_count ?? 0 }}</div>
                                <div class="text-gray-400">Posts</div>
                            </div>
                        </div>

                        <div class="flex gap-2 mt-3">
                            @if($community->is_suspended)
                                <form action="{{ route('admin.communities.activate', $community) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            class="w-full px-3 py-2 bg-green-500/10 hover:bg-green-500/20 border border-green-500/20 hover:border-green-500/30 rounded-xl text-green-400 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                        </svg>
                                        Activate
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.communities.suspend', $community) }}" method="POST" class="flex-1">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Suspend community {{ $community->name }}?')"
                                            class="w-full px-3 py-2 bg-orange-500/10 hover:bg-orange-500/20 border border-orange-500/20 hover:border-orange-500/30 rounded-xl text-orange-400 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                        Suspend
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.communities.destroy', $community) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Hapus community {{ $community->name }}? Tindakan ini tidak dapat dibatalkan!')"
                                        class="w-full px-3 py-2 bg-red-500/10 hover:bg-red-500/20 border border-red-500/20 hover:border-red-500/30 rounded-xl text-red-400 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p>Tidak ada komunitas bermasalah</p>
                        <p class="text-sm mt-1">Semua komunitas dalam kondisi baik</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-slate-800/40 backdrop-blur-lg border border-orange-500/20 rounded-2xl p-6 text-center">
                <div class="text-2xl font-bold text-orange-400 mb-2">{{ $reportedPosts->count() }}</div>
                <div class="text-sm text-gray-400">Reported Posts</div>
            </div>
            <div class="bg-slate-800/40 backdrop-blur-lg border border-red-500/20 rounded-2xl p-6 text-center">
                <div class="text-2xl font-bold text-red-400 mb-2">{{ $problematicCommunities->count() }}</div>
                <div class="text-sm text-gray-400">Problematic Communities</div>
            </div>
            <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6 text-center">
                <div class="text-2xl font-bold text-purple-400 mb-2">{{ $problematicCommunities->where('is_suspended', true)->count() }}</div>
                <div class="text-sm text-gray-400">Suspended Communities</div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.admin>
