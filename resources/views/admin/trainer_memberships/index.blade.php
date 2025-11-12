<x-layouts.admin>
    <x-slot name="title">
        Manajemen <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Member Premium</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Daftar <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Member & Trainer</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Kelola penugasan member premium ke trainer profesional</p>
                </div>
                <a href="{{ route('admin.trainer-memberships.create') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tugaskan Trainer
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
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Member</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Trainer</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Bergabung</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($memberships as $membership)
                    <tr class="hover:bg-slate-700/20 transition-colors duration-300">
                        <!-- Member Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-semibold text-blue-400">
                                        {{ strtoupper(substr($membership->user->name ?? 'U', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-white">{{ $membership->user->name ?? 'User Dihapus' }}</div>
                                    <div class="text-sm text-slate-400">{{ $membership->user->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Trainer Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-semibold text-green-400">
                                        {{ strtoupper(substr($membership->trainer->name ?? 'T', 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-green-400">{{ $membership->trainer->name ?? 'Trainer Dihapus' }}</div>
                                    <div class="text-sm text-slate-400">{{ $membership->trainer->email ?? '-' }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Status Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                Active
                            </span>
                        </td>

                        <!-- Date Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                {{ $membership->created_at->format('d M Y') }}
                            </div>
                        </td>

                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="#"
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-300 flex items-center gap-1"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <form action="{{ route('admin.trainer-memberships.destroy', $membership) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus penugasan trainer {{ $membership->trainer->name ?? '' }} untuk member {{ $membership->user->name ?? '' }}?')"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-300 flex items-center gap-1"
                                            title="Hapus Penugasan">
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
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-16 h-16 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                                </svg>
                                <p class="text-lg font-semibold">Belum ada penugasan trainer</p>
                                <p class="text-sm mt-1">Mulai dengan menugaskan trainer ke member</p>
                                <a href="{{ route('admin.trainer-memberships.create') }}"
                                   class="mt-4 px-6 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tugaskan Trainer Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($memberships->hasPages())
        <div class="p-6 border-t border-slate-700/50">
            {{ $memberships->links() }}
        </div>
        @endif
    </div>

</x-layouts.admin>
