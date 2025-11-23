<x-layouts.admin>
    <x-slot name="title">
        Community <span class="bg-gradient-to-r from-purple-400 to-indigo-500 bg-clip-text text-transparent">Dashboard</span>
    </x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-2xl flex items-center justify-center shadow-lg shadow-purple-500/20">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Community <span class="bg-gradient-to-r from-purple-400 to-indigo-500 bg-clip-text text-transparent">Dashboard</span>
                        </h1>
                        <p class="text-purple-400/80 text-lg mt-2">Overview komunitas MuscleXpert</p>
                    </div>
                </div>
                <div class="flex gap-3">
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

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Communities -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6 shadow-lg shadow-purple-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium mb-2">Total Communities</p>
                        <p class="text-white text-3xl font-bold">{{ $totalCommunities }}</p>
                        <p class="text-purple-400 text-xs mt-2">Semua komunitas</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Members -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-blue-500/20 rounded-2xl p-6 shadow-lg shadow-blue-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium mb-2">Total Members</p>
                        <p class="text-white text-3xl font-bold">{{ $totalMembers }}</p>
                        <p class="text-blue-400 text-xs mt-2">Anggota komunitas</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Total Posts -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-green-500/20 rounded-2xl p-6 shadow-lg shadow-green-500/10">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-400 text-sm font-medium mb-2">Total Posts</p>
                        <p class="text-white text-3xl font-bold">{{ $totalPosts }}</p>
                        <p class="text-green-400 text-xs mt-2">Postingan komunitas</p>
                    </div>
                    <div class="w-12 h-12 bg-green-500/10 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Communities -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6 shadow-lg shadow-purple-500/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="text-purple-400">🏆 Top Communities</span>
                </h3>
                <div class="space-y-4">
                    @foreach($topCommunities as $community)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300">
                        <div class="flex items-center gap-3">
                            @if($community->image)
                                <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}" class="w-10 h-10 rounded-lg object-cover">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                    <span class="text-white font-bold text-sm">{{ substr($community->name, 0, 2) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="text-white font-medium text-sm">{{ $community->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $community->members_count }} members</p>
                            </div>
                        </div>
                        <span class="text-purple-400 text-sm font-bold">{{ $community->members_count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-blue-500/20 rounded-2xl p-6 shadow-lg shadow-blue-500/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <span class="text-blue-400">📝 Recent Activity</span>
                </h3>
                <div class="space-y-4">
                    @foreach($recentPosts as $post)
                    <div class="p-3 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-xs">{{ substr($post->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium line-clamp-1">{{ $post->content }}</p>
                                <p class="text-gray-400 text-xs mt-1">
                                    in <span class="text-blue-400">{{ $post->community->name }}</span> •
                                    {{ $post->created_at->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-emerald-500/20 rounded-2xl p-6 shadow-lg shadow-emerald-500/10">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <span class="text-emerald-400">⚡ Quick Actions</span>
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('admin.communities.index') }}" class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 hover:bg-emerald-500/20 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">Kelola Communities</p>
                            <p class="text-emerald-400 text-xs">Lihat semua komunitas</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.communities.reports') }}" class="p-4 rounded-xl bg-orange-500/10 border border-orange-500/20 hover:bg-orange-500/20 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-500/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">Moderation</p>
                            <p class="text-orange-400 text-xs">Lihat laporan</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.communities.activity') }}" class="p-4 rounded-xl bg-blue-500/10 border border-blue-500/20 hover:bg-blue-500/20 transition-all duration-300 group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium text-sm">Analytics</p>
                            <p class="text-blue-400 text-xs">Aktivitas terbaru</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <style>
        .line-clamp-1 {
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</x-layouts.admin>
