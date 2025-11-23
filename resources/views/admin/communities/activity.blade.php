<x-layouts.admin>
    <x-slot name="title">
        Community <span class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">Activity</span>
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Community <span class="bg-gradient-to-r from-blue-400 to-cyan-500 bg-clip-text text-transparent">Activity</span>
                        </h1>
                        <p class="text-blue-400/80 text-lg mt-2">Aktivitas dan analytics komunitas terbaru</p>
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
                    <a href="{{ route('admin.communities.index') }}"
                       class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-purple-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Kelola Communities
                    </a>
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="bg-slate-800/40 backdrop-blur-lg border border-blue-500/20 rounded-2xl p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $recentPosts->count() }}</div>
                    <div class="text-blue-400 text-sm">Recent Posts</div>
                </div>
            </div>
            <div class="bg-slate-800/40 backdrop-blur-lg border border-green-500/20 rounded-2xl p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $recentMembers->count() }}</div>
                    <div class="text-green-400 text-sm">New Members</div>
                </div>
            </div>
            <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $activeCommunities->count() }}</div>
                    <div class="text-purple-400 text-sm">Active Communities</div>
                </div>
            </div>
            <div class="bg-slate-800/40 backdrop-blur-lg border border-orange-500/20 rounded-2xl p-6">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white mb-2">{{ $activeCommunities->sum('posts_count') }}</div>
                    <div class="text-orange-400 text-sm">Total Posts</div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Posts -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-blue-500/20 rounded-2xl p-6 shadow-lg shadow-blue-500/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="text-blue-400">📝 Recent Posts</span>
                </h3>
                <div class="space-y-4 max-h-96 overflow-y-auto">
                    @forelse($recentPosts as $post)
                    <div class="p-4 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300 border border-slate-700/50">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="text-white font-medium text-sm">{{ $post->user->name }}</p>
                                        <p class="text-gray-400 text-xs">in <span class="text-blue-400">{{ $post->community->name }}</span></p>
                                    </div>
                                    <span class="text-gray-500 text-xs">{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300 text-sm line-clamp-3 leading-relaxed">
                                    {{ Str::limit(strip_tags($post->content), 150) }}
                                </p>
                                <div class="flex items-center gap-4 mt-3 text-xs text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                        {{ $post->likes_count ?? 0 }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.255-3.765A9.863 9.863 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                        </svg>
                                        {{ $post->comments_count ?? 0 }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <p>Belum ada postingan terbaru</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Members & Active Communities -->
            <div class="space-y-6">
                <!-- Recent Members -->
               <!-- Recent Members -->
<div class="bg-slate-800/40 backdrop-blur-lg border border-green-500/20 rounded-2xl p-6 shadow-lg shadow-green-500/10">
    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
        <span class="text-green-400">👥 Recent Members</span>
    </h3>
    <div class="space-y-3 max-h-48 overflow-y-auto">
        @forelse($recentMembers as $member)
        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center">
                    <span class="text-white font-bold text-xs">{{ substr($member->user->name, 0, 1) }}</span>
                </div>
                <div>
                    <p class="text-white text-sm font-medium">{{ $member->user->name }}</p>
                    <p class="text-gray-400 text-xs">joined {{ $member->community->name }}</p>
                </div>
            </div>
            <span class="text-gray-500 text-xs">
                {{ $member->joined_at->diffForHumans() }} {{-- ✅ SEKARANG AMAN --}}
            </span>
        </div>
        @empty
        <div class="text-center py-4 text-gray-500 text-sm">
            Belum ada member baru
        </div>
        @endforelse
    </div>
</div>

                <!-- Active Communities -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6 shadow-lg shadow-purple-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-purple-400">🏆 Most Active Communities</span>
                    </h3>
                    <div class="space-y-3">
                        @forelse($activeCommunities as $community)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300">
                            <div class="flex items-center gap-3">
                                @if($community->image)
                                    <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}" class="w-8 h-8 rounded-lg object-cover">
                                @else
                                    <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                        <span class="text-white font-bold text-xs">{{ substr($community->name, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <p class="text-white text-sm font-medium">{{ $community->name }}</p>
                                    <p class="text-gray-400 text-xs">{{ $community->posts_count }} posts</p>
                                </div>
                            </div>
                            <span class="text-purple-400 text-sm font-bold">{{ $community->posts_count }}</span>
                        </div>
                        @empty
                        <div class="text-center py-4 text-gray-500 text-sm">
                            Belum ada komunitas aktif
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.admin>
