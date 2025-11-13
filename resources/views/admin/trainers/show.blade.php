<x-layouts.admin>
    <x-slot name="title">
        Detail <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h2 class="text-3xl font-bold text-white">
                    Detail <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
                </h2>
                <p class="text-slate-400 mt-1">Informasi lengkap dan statistik trainer</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.trainers.verification.edit', $trainer) }}"
                   class="px-4 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                    Verifikasi
                </a>
                <a href="{{ route('admin.trainers.index') }}"
                   class="px-4 py-2 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-500/15 backdrop-blur-sm text-green-400 border border-green-500/20 p-4 rounded-2xl">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Left Column - Profile Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Profile Card -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    <div class="p-6 border-b border-slate-700/50">
                        <h3 class="text-xl font-bold text-white">Informasi Profil</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row gap-6">
                            <!-- Avatar & Basic Info -->
                            <div class="flex-shrink-0">
                                <div class="w-24 h-24 bg-gradient-to-br from-orange-500/20 to-amber-600/20 rounded-2xl flex items-center justify-center text-2xl font-bold text-orange-400">
                                    {{ strtoupper(substr($trainer->name, 0, 1)) }}
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 space-y-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-slate-400">Nama Lengkap</label>
                                        <p class="text-white font-semibold">{{ $trainer->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-slate-400">Email</label>
                                        <p class="text-white font-semibold">{{ $trainer->email }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-slate-400">Status Verifikasi</label>
                                        <p>
                                            @if($trainer->verification_status === 'approved')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                                    Disetujui
                                                </span>
                                            @elseif($trainer->verification_status === 'pending')
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                                                    Menunggu Verifikasi
                                                </span>
                                            @else
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-500/20 text-red-400 border border-red-500/30">
                                                    Ditolak
                                                </span>
                                            @endif
                                        </p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-slate-400">Bergabung</label>
                                        <p class="text-white font-semibold">{{ $trainer->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Trainer Profile Card -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    <div class="p-6 border-b border-slate-700/50">
                        <h3 class="text-xl font-bold text-white">Profil Trainer</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        @if($trainer->trainerProfile)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="text-sm text-slate-400">Spesialisasi</label>
                                    <p class="text-white font-semibold">{{ $trainer->trainerProfile->specialization ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Pengalaman</label>
                                    <p class="text-white font-semibold">{{ $trainer->trainerProfile->experience_years ?? 0 }} Tahun</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Rating</label>
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                            <span class="text-white font-semibold">{{ $trainer->trainerProfile->rating ?? '0.00' }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Sertifikasi</label>
                                    <p class="text-white font-semibold">
                                        @if($trainer->trainerProfile->certifications)
                                            {{ Str::limit($trainer->trainerProfile->certifications, 50) }}
                                        @else
                                            -
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm text-slate-400">Bio</label>
                                <p class="text-white mt-1 leading-relaxed">
                                    {{ $trainer->trainerProfile->bio ?? 'Tidak ada bio' }}
                                </p>
                            </div>
                        @else
                            <div class="text-center py-8 text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <p>Profil trainer belum dilengkapi</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Stats & Actions -->
            <div class="space-y-6">
                <!-- Stats Card -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    <div class="p-6 border-b border-slate-700/50">
                        <h3 class="text-xl font-bold text-white">Statistik</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Total Member</span>
                            <span class="text-white font-bold text-lg">{{ $trainer->trainerMembershipsAsTrainer->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Total Feedback</span>
                            <span class="text-white font-bold text-lg">{{ $trainer->feedbacksReceived->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-400">Status</span>
                            <span class="text-white font-bold text-lg">
                                @if($trainer->trainerProfile && $trainer->trainerProfile->verified)
                                    <span class="text-green-400">Terverifikasi</span>
                                @else
                                    <span class="text-yellow-400">Belum Verifikasi</span>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    <div class="p-6 border-b border-slate-700/50">
                        <h3 class="text-xl font-bold text-white">Aksi Cepat</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <form action="{{ route('admin.trainers.toggle-status', $trainer) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                    class="w-full text-left px-4 py-3 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-yellow-500/20 flex items-center justify-center group-hover:bg-yellow-500/30">
                                        <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <span>
                                        {{ $trainer->verification_status === 'approved' ? 'Nonaktifkan' : 'Aktifkan' }} Trainer
                                    </span>
                                </div>
                            </button>
                        </form>

                        <form action="{{ route('admin.trainers.destroy', $trainer) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus trainer {{ $trainer->name }}? Tindakan ini tidak dapat dibatalkan!')"
                                    class="w-full text-left px-4 py-3 rounded-xl border border-red-600/50 text-red-400 hover:text-white hover:bg-red-500/20 transition-all duration-300 flex items-center justify-between group">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30">
                                        <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </div>
                                    <span>Hapus Trainer</span>
                                </div>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Verification Status -->
                @if($trainer->trainerVerification)
                <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
                    <div class="p-6 border-b border-slate-700/50">
                        <h3 class="text-xl font-bold text-white">Status Verifikasi</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <div>
                            <label class="text-sm text-slate-400">Status</label>
                            <p class="text-white font-semibold capitalize">{{ $trainer->trainerVerification->status }}</p>
                        </div>
                        @if($trainer->trainerVerification->admin_feedback)
                        <div>
                            <label class="text-sm text-slate-400">Feedback Admin</label>
                            <p class="text-white mt-1 text-sm">{{ $trainer->trainerVerification->admin_feedback }}</p>
                        </div>
                        @endif
                        @if($trainer->trainerVerification->verified_at)
                        <div>
                            <label class="text-sm text-slate-400">Tanggal Verifikasi</label>
                            <p class="text-white font-semibold">{{ $trainer->trainerVerification->verified_at->format('d M Y H:i') }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

</x-layouts.admin>
