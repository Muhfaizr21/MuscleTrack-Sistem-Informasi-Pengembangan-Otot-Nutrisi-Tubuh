<x-layouts.admin>
    <x-slot name="title">
        Detail <span class="bg-gradient-to-r from-purple-400 to-indigo-500 bg-clip-text text-transparent">Community</span>
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
                            Detail <span class="bg-gradient-to-r from-purple-400 to-indigo-500 bg-clip-text text-transparent">Community</span>
                        </h1>
                        <p class="text-purple-400/80 text-lg mt-2">Informasi lengkap komunitas {{ $community->name }}</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.communities.index') }}"
                       class="flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-purple-500 to-indigo-600 hover:from-purple-600 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-purple-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Community Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6 shadow-lg shadow-purple-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-purple-400">📋 Informasi Community</span>
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label class="text-gray-400 text-sm font-medium">Nama Community</label>
                                <p class="text-white font-medium text-lg">{{ $community->name }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm font-medium">Slug</label>
                                <p class="text-gray-300 font-mono text-sm">{{ $community->slug }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm font-medium">Status</label>
                                @if($community->is_public)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                                        Public
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                        Private
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="text-gray-400 text-sm font-medium">Dibuat Oleh</label>
                                <p class="text-white font-medium">{{ $community->creator->name }}</p>
                                <p class="text-gray-400 text-sm">{{ $community->creator->email }}</p>
                            </div>
                            <div>
                                <label class="text-gray-400 text-sm font-medium">Tanggal Dibuat</label>
                                <p class="text-gray-300">{{ $community->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Description -->
                    @if($community->description)
                    <div class="mt-6 pt-6 border-t border-slate-700/50">
                        <label class="text-gray-400 text-sm font-medium mb-2 block">Deskripsi</label>
                        <p class="text-gray-300 leading-relaxed">{{ $community->description }}</p>
                    </div>
                    @endif
                </div>

                <!-- Statistics Card -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-blue-500/20 rounded-2xl p-6 shadow-lg shadow-blue-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-blue-400">📊 Statistik</span>
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-4 rounded-xl bg-blue-500/10">
                            <p class="text-blue-400 text-2xl font-bold">{{ $memberCount }}</p>
                            <p class="text-gray-400 text-xs mt-1">Total Members</p>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-green-500/10">
                            <p class="text-green-400 text-2xl font-bold">{{ $postCount }}</p>
                            <p class="text-gray-400 text-xs mt-1">Total Posts</p>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-purple-500/10">
                            <p class="text-purple-400 text-2xl font-bold">{{ $community->member_count }}</p>
                            <p class="text-gray-400 text-xs mt-1">Member Count</p>
                        </div>
                        <div class="text-center p-4 rounded-xl bg-orange-500/10">
                            <p class="text-orange-400 text-2xl font-bold">{{ $community->post_count }}</p>
                            <p class="text-gray-400 text-xs mt-1">Post Count</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Posts -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-green-500/20 rounded-2xl p-6 shadow-lg shadow-green-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-green-400">📝 Postingan Terbaru</span>
                    </h3>
                    <div class="space-y-4">
                        @forelse($community->posts->take(5) as $post)
                        <div class="p-4 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300">
                            <div class="flex items-start gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <span class="text-white font-bold text-sm">{{ substr($post->user->name, 0, 1) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-white text-sm font-medium line-clamp-2">{{ $post->content }}</p>
                                    <div class="flex items-center gap-3 mt-2">
                                        <p class="text-gray-400 text-xs">
                                            oleh <span class="text-green-400">{{ $post->user->name }}</span>
                                        </p>
                                        <span class="text-gray-500">•</span>
                                        <p class="text-gray-400 text-xs">{{ $post->created_at->diffForHumans() }}</p>
                                        <span class="text-gray-500">•</span>
                                        <p class="text-gray-400 text-xs">{{ $post->like_count }} likes</p>
                                        <span class="text-gray-500">•</span>
                                        <p class="text-gray-400 text-xs">{{ $post->comment_count }} comments</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 mx-auto mb-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-gray-400">Belum ada postingan di community ini</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Actions Card -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-red-500/20 rounded-2xl p-6 shadow-lg shadow-red-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-red-400">⚡ Aksi Cepat</span>
                    </h3>
                    <div class="space-y-3">
                        <form action="{{ route('admin.communities.destroy', $community) }}"
                              method="POST"
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus community ini? Semua data termasuk postingan dan anggota akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-red-400 bg-red-500/10 border border-red-500/20 rounded-xl hover:bg-red-500/20 transition-all duration-300 group">
                                <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                <span class="font-medium">Hapus Community</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Members List -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-purple-500/20 rounded-2xl p-6 shadow-lg shadow-purple-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-purple-400">👥 Anggota ({{ $memberCount }})</span>
                    </h3>
                    <div class="space-y-3 max-h-80 overflow-y-auto">
                        @forelse($community->members->take(10) as $member)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-800/50 hover:bg-slate-700/50 transition-all duration-300">
                            <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-xs">{{ substr($member->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-white text-sm font-medium truncate">{{ $member->user->name }}</p>
                                <p class="text-gray-400 text-xs">{{ $member->role }}</p>
                            </div>
                            <span class="text-gray-400 text-xs">{{ $member->joined_at->diffForHumans() }}</span>
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <p class="text-gray-400 text-sm">Belum ada anggota</p>
                        </div>
                        @endforelse

                        @if($memberCount > 10)
                        <div class="text-center pt-2">
                            <p class="text-purple-400 text-sm font-medium">
                                +{{ $memberCount - 10 }} anggota lainnya
                            </p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Community Images -->
                @if($community->image || $community->cover_image)
                <div class="bg-slate-800/40 backdrop-blur-lg border border-cyan-500/20 rounded-2xl p-6 shadow-lg shadow-cyan-500/10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                        <span class="text-cyan-400">🖼️ Gambar</span>
                    </h3>
                    <div class="space-y-4">
                        @if($community->cover_image)
                        <div>
                            <label class="text-gray-400 text-sm font-medium mb-2 block">Cover Image</label>
                            <img src="{{ Storage::url($community->cover_image) }}"
                                 alt="Cover {{ $community->name }}"
                                 class="w-full h-32 object-cover rounded-xl">
                        </div>
                        @endif
                        @if($community->image)
                        <div>
                            <label class="text-gray-400 text-sm font-medium mb-2 block">Profile Image</label>
                            <img src="{{ Storage::url($community->image) }}"
                                 alt="Profile {{ $community->name }}"
                                 class="w-20 h-20 object-cover rounded-xl">
                        </div>
                        @endif
                    </div>
                </div>
                @endif
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

        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>
</x-layouts.admin>
