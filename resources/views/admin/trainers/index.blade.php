<x-layouts.admin>
    <x-slot name="title">
        Manajemen <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Daftar <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Kelola semua trainer dan verifikasi akun</p>
                </div>
                <div class="flex items-center gap-3">
                    <!-- Status Filter -->
                    <select onchange="window.location.href = this.value"
                            class="bg-slate-700/50 border border-slate-600/50 rounded-xl py-2 px-3 text-slate-200 text-sm focus:border-orange-500 focus:ring-1 focus:ring-orange-500">
                        <option value="{{ route('admin.trainers.index') }}">Semua Status</option>
                        <option value="{{ route('admin.trainers.index', ['status' => 'approved']) }}" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                        <option value="{{ route('admin.trainers.index', ['status' => 'pending']) }}" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                        <option value="{{ route('admin.trainers.index', ['status' => 'rejected']) }}" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Search Section -->
        <div class="p-6 border-b border-slate-700/50 bg-slate-800/30">
            <form action="{{ route('admin.trainers.index') }}" method="GET" class="max-w-md">
                <div class="relative">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama atau email trainer..."
                           class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-12 text-slate-200 placeholder-slate-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all duration-300">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4">
                        <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    @if(request('search'))
                        <a href="{{ route('admin.trainers.index') }}"
                           class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-500 hover:text-slate-400 transition-colors duration-300"
                           title="Clear search">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Search Results Info -->
            @if(request('search') || request('status'))
                <div class="mt-3 flex items-center gap-2 text-sm text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>
                        @if(request('search') && request('status'))
                            Menampilkan hasil untuk: "<strong>{{ request('search') }}</strong>" dengan status {{ request('status') }}
                        @elseif(request('search'))
                            Menampilkan hasil untuk: "<strong>{{ request('search') }}</strong>"
                        @elseif(request('status'))
                            Menampilkan trainer dengan status: <strong>{{ request('status') }}</strong>
                        @endif
                    </span>
                    <span class="text-slate-500">•</span>
                    <span>{{ $trainers->total() }} hasil ditemukan</span>
                </div>
            @endif
        </div>

        <!-- Success/Error Messages -->
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

        @if(session('error'))
            <div class="p-4 bg-red-500/15 backdrop-blur-sm text-red-400 border-b border-red-500/20">
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
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead class="bg-slate-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Trainer</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Spesialisasi</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Pengalaman</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Rating</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($trainers as $trainer)
                    <tr class="hover:bg-slate-700/20 transition-colors duration-300">
                        <!-- Trainer Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-orange-500/20 to-amber-600/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-semibold text-orange-400">
                                        {{ strtoupper(substr($trainer->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-white">{{ $trainer->name }}</div>
                                    <div class="text-sm text-slate-400">{{ $trainer->email }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Specialization Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            {{ $trainer->trainerProfile->specialization ?? '-' }}
                        </td>

                        <!-- Experience Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            {{ $trainer->trainerProfile->experience_years ?? 0 }} tahun
                        </td>

                        <!-- Status Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($trainer->verification_status === 'approved')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                    Disetujui
                                </span>
                            @elseif($trainer->verification_status === 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                    Menunggu
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                    Ditolak
                                </span>
                            @endif
                        </td>

                        <!-- Rating Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                                <span class="font-semibold text-amber-400">{{ $trainer->trainerProfile->rating ?? '0.00' }}</span>
                            </div>
                        </td>

                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-2">
                                <!-- View Detail -->
                                <a href="{{ route('admin.trainers.show', $trainer) }}"
                                   class="text-blue-400 hover:text-blue-300 transition-colors duration-300 p-2 rounded-lg hover:bg-slate-700/50"
                                   title="Lihat Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>

                                <!-- Verification -->
                                <a href="{{ route('admin.trainers.verification.edit', $trainer) }}"
                                   class="text-green-400 hover:text-green-300 transition-colors duration-300 p-2 rounded-lg hover:bg-slate-700/50"
                                   title="Verifikasi Trainer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </a>

                                <!-- Toggle Status -->
                                <form action="{{ route('admin.trainers.toggle-status', $trainer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="text-yellow-400 hover:text-yellow-300 transition-colors duration-300 p-2 rounded-lg hover:bg-slate-700/50"
                                            title="{{ $trainer->verification_status === 'approved' ? 'Nonaktifkan' : 'Aktifkan' }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Delete -->
                                <form action="{{ route('admin.trainers.destroy', $trainer) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus trainer {{ $trainer->name }}? Tindakan ini tidak dapat dibatalkan!')"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-300 p-2 rounded-lg hover:bg-slate-700/50"
                                            title="Hapus Trainer">
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
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-20 h-20 mb-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-1.657-.672-3.157-1.757-4.243M17 20h-2m2-2v-2a3 3 0 00-3-3h-2a3 3 0 00-3 3v2m2 4v-4m4 4v-4m-4 4H7m0 0v-2a3 3 0 013-3h2a3 3 0 013 3v2m0 4v-4m-4 4H7m0 0H3v-2a3 3 0 015.356-1.857M3 20v-2c0-1.657.672-3.157 1.757-4.243M3 20h2M3 18v-2a3 3 0 013-3h2a3 3 0 013 3v2m-4 4v-4"/>
                                </svg>
                                @if(request('search') || request('status'))
                                    <p class="text-lg font-semibold">Tidak ada hasil pencarian</p>
                                    <p class="text-sm mt-1">Tidak ditemukan trainer yang sesuai dengan kriteria</p>
                                    <a href="{{ route('admin.trainers.index') }}"
                                       class="mt-4 px-6 py-2 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 text-white font-semibold hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5">
                                        Tampilkan Semua Trainer
                                    </a>
                                @else
                                    <p class="text-lg font-semibold">Belum ada trainer terdaftar</p>
                                    <p class="text-sm mt-1">Trainer akan muncul di sini setelah mendaftar</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($trainers->hasPages())
        <div class="p-6 border-t border-slate-700/50">
            {{ $trainers->links() }}
        </div>
        @endif
    </div>

</x-layouts.admin>
