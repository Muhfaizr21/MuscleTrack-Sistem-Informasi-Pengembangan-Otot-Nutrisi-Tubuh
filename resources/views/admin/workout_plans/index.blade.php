<x-layouts.admin>
    <x-slot name="title">
        Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Latihan</span>
    </x-slot>

    <!-- TAMBAHKAN CSS OVERRIDE INI DENGAN !IMPORTANT -->
    <style>
        /* OVERRIDE TOTAL - Force semua warna */
        .force-text-white { color: #ffffff !important; }
        .force-text-gray-300 { color: #d1d5db !important; }
        .force-text-gray-400 { color: #9ca3af !important; }
        .force-text-gray-500 { color: #6b7280 !important; }

        .force-bg-slate-800 { background-color: #1e293b !important; }
        .force-bg-slate-700 { background-color: #334155 !important; }
        .force-border-slate-700 { border-color: #334155 !important; }

        /* Force untuk semua elemen di dalam container */
        #workout-plans-container,
        #workout-plans-container * {
            color: #ffffff !important;
        }

        #workout-plans-container .text-slate-300 { color: #cbd5e1 !important; }
        #workout-plans-container .text-slate-400 { color: #94a3b8 !important; }
        #workout-plans-container .text-slate-500 { color: #64748b !important; }

        /* Gradient text tetap */
        .gradient-text {
            background: linear-gradient(to right, #10b981, #059669) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        /* Badge colors */
        .badge-blue {
            background: rgba(59, 130, 246, 0.2) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            color: #60a5fa !important;
        }
        .badge-green {
            background: rgba(5, 150, 105, 0.2) !important;
            border: 1px solid rgba(5, 150, 105, 0.3) !important;
            color: #34d399 !important;
        }
        .badge-yellow {
            background: rgba(245, 158, 11, 0.2) !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            color: #fbbf24 !important;
        }
        .badge-red {
            background: rgba(239, 68, 68, 0.2) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #f87171 !important;
        }
        .badge-gray {
            background: rgba(75, 85, 99, 0.2) !important;
            border: 1px solid rgba(75, 85, 99, 0.3) !important;
            color: #9ca3af !important;
        }
    </style>

    <div id="workout-plans-container" class="force-bg-slate-800 force-border-slate-700 rounded-2xl shadow-2xl overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b force-border-slate-700">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold force-text-white">
                        Master Program <span class="gradient-text">Latihan</span>
                    </h3>
                    <p class="text-sm force-text-gray-400 mt-1">Template program latihan profesional untuk user</p>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Statistics Badge -->
                    <div class="px-4 py-2 force-bg-slate-700 rounded-lg border force-border-slate-700">
                        <div class="text-sm force-text-gray-300">{{ $plans->total() }} Program</div>
                    </div>

                    <!-- Create Button -->
                    <a href="{{ route('admin.workout-plans.create') }}"
                       class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Buat Program Baru
                    </a>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="p-4 bg-green-500/20 backdrop-blur-sm text-green-300 border-b border-green-500/30">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-red-500/20 backdrop-blur-sm text-red-300 border-b border-red-500/30">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="force-bg-slate-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Program Latihan</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Target</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Fokus</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Level</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Durasi</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold force-text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($plans as $plan)
                    <tr class="border-t force-border-slate-700 hover:force-bg-slate-700 transition-colors duration-300">
                        <!-- Program Column -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold force-text-white truncate">{{ $plan->title }}</div>
                                    <div class="text-xs force-text-gray-400 mt-1 line-clamp-2">{{ $plan->description }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Target Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-blue capitalize">
                                {{ $plan->target_fitness ?? 'General' }}
                            </span>
                        </td>

                        <!-- Focus Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm force-text-gray-300 capitalize">
                            {{ $plan->focus_area ?? 'Full Body' }}
                        </td>

                        <!-- Level Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($plan->difficulty_level == 'beginner')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                    Beginner
                                </span>
                            @elseif($plan->difficulty_level == 'intermediate')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-yellow">
                                    Intermediate
                                </span>
                            @elseif($plan->difficulty_level == 'advanced')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-red">
                                    Advanced
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-gray">
                                    {{ $plan->difficulty_level ?? 'All Levels' }}
                                </span>
                            @endif
                        </td>

                        <!-- Duration Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm force-text-gray-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 force-text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                {{ $plan->duration_weeks ?? '-' }} Minggu
                            </div>
                        </td>

                        <!-- Status Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($plan->status == 'active')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-gray">
                                    Inactive
                                </span>
                            @endif
                        </td>

                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <div class="flex items-center justify-end gap-2">
                                <!-- Show Button -->
                                <a href="{{ route('admin.workout-plans.show', $plan) }}"
                                   class="p-2 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 border border-blue-500/30 rounded-lg transition-all duration-300 hover:scale-105"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Edit Button -->
                                <a href="{{ route('admin.workout-plans.edit', $plan) }}"
                                   class="p-2 bg-green-500/10 text-green-400 hover:bg-green-500/20 border border-green-500/30 rounded-lg transition-all duration-300 hover:scale-105"
                                   title="Edit Program">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.workout-plans.destroy', $plan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus program \"{{ $plan->title }}\"?')"
                                            class="p-2 bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/30 rounded-lg transition-all duration-300 hover:scale-105"
                                            title="Hapus Program">
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
                        <td colspan="7" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center force-text-gray-500">
                                <svg class="w-20 h-20 mb-4 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                <p class="text-xl font-semibold mb-2 force-text-white">Belum ada program latihan</p>
                                <p class="text-sm mb-6 force-text-gray-400">Mulai dengan membuat program latihan pertama</p>
                                <a href="{{ route('admin.workout-plans.create') }}"
                                   class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Buat Program Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($plans->hasPages())
        <div class="p-6 border-t force-border-slate-700">
            <div class="flex items-center justify-between">
                <div class="text-sm force-text-gray-400">
                    Menampilkan {{ $plans->firstItem() }} - {{ $plans->lastItem() }} dari {{ $plans->total() }} program
                </div>
                <div class="flex space-x-2">
                    {{ $plans->links() }}
                </div>
            </div>
        </div>
        @endif
    </div>

    <style>
        .line-clamp-2 {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }
        .truncate {
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    </style>

</x-layouts.admin>
