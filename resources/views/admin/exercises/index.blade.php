<x-layouts.admin>
    <x-slot name="title">
        Master <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Exercise</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        {{-- Header --}}
        <div class="p-6 border-b border-slate-700/50 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h3 class="text-2xl font-bold text-white">
                    Master <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Exercise</span>
                </h3>
                <p class="text-sm text-slate-400 mt-1">Kelola semua latihan fisik yang digunakan dalam program workout</p>
            </div>
            <a href="{{ route('admin.exercises.create') }}"
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Tambah Exercise Baru
            </a>
        </div>

        {{-- Notifikasi Sukses --}}
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

        {{-- Table Section --}}
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead class="bg-slate-800/50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Exercise</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Muscle Group</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Difficulty</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($exercises as $exercise)
                        <tr class="hover:bg-slate-700/20 transition-colors duration-300">
                            {{-- Nama + Deskripsi --}}
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                        <span class="text-2xl">💪</span>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-white">{{ $exercise->name }}</div>
                                        <div class="text-xs text-slate-400 line-clamp-2">{{ $exercise->description }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Type --}}
                            <td class="px-6 py-4 text-sm text-slate-300 capitalize">
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    {{ $exercise->type }}
                                </span>
                            </td>

                            {{-- Muscle Group --}}
                            <td class="px-6 py-4 text-sm text-slate-300 capitalize">
                                {{ $exercise->muscle_group ?? '-' }}
                            </td>

                            {{-- Difficulty --}}
                            <td class="px-6 py-4">
                                @php
                                    $diffColors = [
                                        'beginner' => 'bg-green-500/20 text-green-400 border-green-500/30',
                                        'intermediate' => 'bg-yellow-500/20 text-yellow-400 border-yellow-500/30',
                                        'advanced' => 'bg-red-500/20 text-red-400 border-red-500/30'
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full border {{ $diffColors[$exercise->difficulty] ?? 'bg-slate-500/20 text-slate-400 border-slate-500/30' }}">
                                    {{ ucfirst($exercise->difficulty) }}
                                </span>
                            </td>

                            {{-- Status --}}
                            <td class="px-6 py-4">
                                @if($exercise->status === 'active')
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                        Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-semibold rounded-full bg-slate-500/20 text-slate-400 border border-slate-500/30">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            {{-- Aksi --}}
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-3">
                                    {{-- Lihat Video (jika ada) --}}
                                    @if($exercise->video_url)
                                        <a href="{{ $exercise->video_url }}" target="_blank"
                                           class="text-blue-400 hover:text-blue-300 transition-colors"
                                           title="Lihat Video">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-4.197-2.42A1 1 0 009 9.618v4.764a1 1 0 001.555.832l4.197-2.42a1 1 0 000-1.664z"/>
                                            </svg>
                                        </a>
                                    @endif

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.exercises.edit', $exercise) }}"
                                       class="text-green-400 hover:text-green-300 transition-colors"
                                       title="Edit Exercise">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                  a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.exercises.destroy', $exercise) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus exercise \"{{ $exercise->name }}\"?')"
                                            class="text-red-400 hover:text-red-300 transition-colors"
                                            title="Hapus Exercise">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7
                                                      m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-14 h-14 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M14.752 11.168l-4.197-2.42A1 1 0 009 9.618v4.764a1 1 0 001.555.832l4.197-2.42a1 1 0 000-1.664z"/>
                                    </svg>
                                    <p class="font-semibold text-lg">Belum ada exercise</p>
                                    <p class="text-sm text-slate-400">Mulai dengan menambahkan latihan pertama</p>
                                    <a href="{{ route('admin.exercises.create') }}"
                                       class="mt-4 px-6 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                        Tambah Exercise
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($exercises->hasPages())
            <div class="p-6 border-t border-slate-700/50">
                {{ $exercises->links() }}
            </div>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 2;
        }
    </style>
</x-layouts.admin>
