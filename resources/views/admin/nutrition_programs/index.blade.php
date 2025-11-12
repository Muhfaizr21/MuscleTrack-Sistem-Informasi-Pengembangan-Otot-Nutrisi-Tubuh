<x-layouts.admin>
    <x-slot name="title">
        Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Nutrisi</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Nutrisi</span> (Templates)
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Template program nutrisi yang bisa dilihat oleh user</p>
                </div>
                <a href="{{ route('admin.nutrition-programs.create') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Buat Menu Baru
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
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Menu Nutrisi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Target</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Kalori</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Protein</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Karbohidrat</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Hari / Tipe</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($programs as $plan)
                    <tr class="hover:bg-slate-700/20 transition-colors duration-300">
                        <!-- Menu Column -->
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="text-sm font-semibold text-white line-clamp-1">{{ $plan->meal_name }}</div>
                                    <div class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $plan->description ?? 'Program nutrisi sehat' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Target Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($plan->target_fitness == 'MUSCLE_GAIN')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                    Muscle Gain
                                </span>
                            @elseif($plan->target_fitness == 'WEIGHT_LOSS')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    Weight Loss
                                </span>
                            @elseif($plan->target_fitness == 'MAINTENANCE')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    Maintenance
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-500/20 text-slate-400 border border-slate-500/30 uppercase">
                                    {{ $plan->target_fitness ?? 'UMUM' }}
                                </span>
                            @endif
                        </td>

                        <!-- Calories Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-orange-400">{{ $plan->calories }} kcal</div>
                                    <div class="text-xs text-slate-500">Kalori</div>
                                </div>
                            </div>
                        </td>

                        <!-- Protein Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-green-400">{{ $plan->protein }} g</div>
                                    <div class="text-xs text-slate-500">Protein</div>
                                </div>
                            </div>
                        </td>

                        <!-- Carbs Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-yellow-400">{{ $plan->carbs ?? '0' }} g</div>
                                    <div class="text-xs text-slate-500">Karbohidrat</div>
                                </div>
                            </div>
                        </td>

                        <!-- Day & Type Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-center">
                                <div class="text-sm font-semibold text-white bg-slate-700/50 rounded-lg py-1 px-3 mb-1">
                                    {{ $plan->day_of_week }}
                                </div>
                                <div class="text-xs text-slate-400 capitalize bg-slate-600/30 rounded-lg py-1 px-2">
                                    {{ $plan->type }}
                                </div>
                            </div>
                        </td>

                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.nutrition-programs.show', $plan) }}"
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-300 flex items-center gap-1"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <a href="{{ route('admin.nutrition-programs.edit', $plan) }}"
                                   class="text-green-400 hover:text-green-300 transition-colors duration-300 flex items-center gap-1"
                                   title="Edit Menu">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.nutrition-programs.destroy', $plan) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus menu \"{{ $plan->meal_name }}\"?')"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-300 flex items-center gap-1"
                                            title="Hapus Menu">
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
                        <td colspan="7" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-lg font-semibold">Belum ada program nutrisi</p>
                                <p class="text-sm mt-1">Mulai dengan membuat menu nutrisi pertama</p>
                                <a href="{{ route('admin.nutrition-programs.create') }}"
                                   class="mt-4 px-6 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Buat Menu Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($programs->hasPages())
        <div class="p-6 border-t border-slate-700/50">
            {{ $programs->links() }}
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
