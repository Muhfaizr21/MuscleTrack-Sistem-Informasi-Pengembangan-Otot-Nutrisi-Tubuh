<x-layouts.admin>
    <x-slot name="title">
        Kelola <span class="bg-gradient-to-r from-purple-400 to-indigo-500 bg-clip-text text-transparent">Communities</span>
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

    @if(session('error'))
        <div class="p-4 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 rounded-xl mb-6">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Kelola <span class="bg-gradient-to-r from-purple-400 to-indigo-500 bg-clip-text text-transparent">Communities</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Manage semua komunitas di platform MuscleXpert</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="px-4 py-2 bg-slate-700/50 rounded-xl border border-slate-600/30">
                        <div class="text-sm font-semibold text-purple-400">
                            Total: {{ $communities->total() }} Communities
                        </div>
                    </div>
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

        <!-- Filter Section -->
        <div class="p-6 border-b border-slate-700/50 bg-slate-800/20">
            <form action="{{ route('admin.communities.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari komunitas berdasarkan nama atau deskripsi..."
                           class="w-full px-4 py-3 bg-slate-800 border border-purple-500/20 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
                </div>
                <div class="flex gap-3">
                    <select name="status" class="px-4 py-3 bg-slate-800 border border-purple-500/20 rounded-xl text-white focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300">
                        <option value="">Semua Status</option>
                        <option value="public" {{ request('status') == 'public' ? 'selected' : '' }}>Public</option>
                        <option value="private" {{ request('status') == 'private' ? 'selected' : '' }}>Private</option>
                    </select>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 rounded-xl text-white font-bold transition-all duration-300 shadow-lg shadow-purple-500/20 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Communities Grid -->
        <div class="p-6">
            @if($communities->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                    @foreach($communities as $community)
                    <div class="bg-slate-800/50 rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/30 transition-all duration-300 group hover:transform hover:scale-105">
                        <!-- Community Header -->
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center gap-3">
                                @if($community->image)
                                    <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}"
                                         class="w-12 h-12 rounded-xl object-cover border border-purple-500/20">
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center border border-purple-500/30">
                                        <span class="text-white font-bold text-sm">{{ substr($community->name, 0, 2) }}</span>
                                    </div>
                                @endif
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-white font-bold text-lg group-hover:text-purple-400 transition-colors duration-300 truncate">
                                        {{ $community->name }}
                                    </h3>
                                    <p class="text-gray-400 text-sm truncate">by {{ $community->creator->name }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-1">
                                <span class="text-xs px-2 py-1 rounded-full {{ $community->is_public ? 'bg-green-500/20 text-green-400 border border-green-500/30' : 'bg-orange-500/20 text-orange-400 border border-orange-500/30' }}">
                                    {{ $community->is_public ? 'Public' : 'Private' }}
                                </span>
                                @if($community->is_suspended)
                                    <span class="text-xs px-2 py-1 rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                        Suspended
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Description -->
                        <p class="text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                            {{ $community->description }}
                        </p>

                        <!-- Stats -->
                        <div class="flex items-center justify-between text-sm mb-4">
                            <div class="flex items-center gap-4">
                                <span class="text-white flex items-center gap-1 text-xs">
                                    <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                    {{ $community->members_count }} members
                                </span>
                                <span class="text-white flex items-center gap-1 text-xs">
                                    <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    {{ $community->posts_count }} posts
                                </span>
                            </div>
                            <div class="text-xs text-gray-500">
                                {{ $community->created_at->format('d M Y') }}
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('user.communities.show', $community) }}"
                               target="_blank"
                               class="flex-1 text-center px-3 py-2 bg-blue-500/10 hover:bg-blue-500/20 border border-blue-500/20 hover:border-blue-500/30 rounded-xl text-blue-400 text-sm font-medium transition-all duration-300 flex items-center justify-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                View
                            </a>

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
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-6 border-t border-slate-700/50 pt-6">
                    {{ $communities->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-700/50">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-400 mb-2">Tidak ada communities</h3>
                    <p class="text-gray-500">Belum ada komunitas yang dibuat atau sesuai dengan filter pencarian.</p>
                </div>
            @endif
        </div>
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

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }
    </style>

</x-layouts.admin>
