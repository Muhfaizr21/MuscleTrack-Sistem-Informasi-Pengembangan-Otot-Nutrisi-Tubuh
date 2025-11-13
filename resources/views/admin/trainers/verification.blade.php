<x-layouts.admin>
    <x-slot name="title">
        Verifikasi <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

            <!-- Header -->
            <div class="p-6 border-b border-slate-700/50">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div>
                        <h3 class="text-2xl font-bold text-white">
                            Verifikasi <span class="bg-gradient-to-r from-orange-400 to-amber-500 bg-clip-text text-transparent">Trainer</span>
                        </h3>
                        <p class="text-sm text-slate-400 mt-1">Tinjau dan verifikasi profil trainer</p>
                    </div>
                    <a href="{{ route('admin.trainers.show', $trainer) }}"
                       class="px-4 py-2 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Detail
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.trainers.verification.update', $trainer) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="p-8 space-y-8">
                    <!-- Trainer Info -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-white">Informasi Trainer</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-slate-400">Nama</label>
                                    <p class="text-white font-semibold">{{ $trainer->name }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Email</label>
                                    <p class="text-white font-semibold">{{ $trainer->email }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Bergabung</label>
                                    <p class="text-white font-semibold">{{ $trainer->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-white">Profil Trainer</h4>
                            <div class="space-y-3">
                                <div>
                                    <label class="text-sm text-slate-400">Spesialisasi</label>
                                    <p class="text-white font-semibold">{{ $trainer->trainerProfile->specialization ?? '-' }}</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Pengalaman</label>
                                    <p class="text-white font-semibold">{{ $trainer->trainerProfile->experience_years ?? 0 }} Tahun</p>
                                </div>
                                <div>
                                    <label class="text-sm text-slate-400">Sertifikasi</label>
                                    <p class="text-white text-sm">
                                        @if($trainer->trainerProfile && $trainer->trainerProfile->certifications)
                                            {{ $trainer->trainerProfile->certifications }}
                                        @else
                                            Tidak ada sertifikasi
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($trainer->trainerProfile && $trainer->trainerProfile->bio)
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-white">Bio Trainer</h4>
                        <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/50">
                            <p class="text-white leading-relaxed">{{ $trainer->trainerProfile->bio }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Certificate File -->
                    @if($trainer->trainerVerification && $trainer->trainerVerification->certificate)
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-white">Dokumen Sertifikat</h4>
                        <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/50">
                            <div class="flex items-center gap-3">
                                <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <div>
                                    <p class="text-white font-semibold">File Sertifikat</p>
                                    <p class="text-slate-400 text-sm">Trainer telah mengunggah dokumen sertifikasi</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Verification Action -->
                    <div class="space-y-4">
                        <h4 class="text-lg font-semibold text-white">Tindakan Verifikasi</h4>

                        <!-- Status Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Approve -->
                            <label class="relative">
                                <input type="radio" name="status" value="approved"
                                       class="sr-only peer"
                                       {{ $trainer->verification_status === 'approved' ? 'checked' : '' }}>
                                <div class="p-4 border-2 border-slate-600/50 rounded-xl cursor-pointer transition-all duration-300 peer-checked:border-green-500 peer-checked:bg-green-500/10 peer-checked:shadow-lg peer-checked:shadow-green-500/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full border-2 border-slate-500 peer-checked:border-green-500 peer-checked:bg-green-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">Setujui</p>
                                            <p class="text-slate-400 text-sm">Trainer memenuhi syarat</p>
                                        </div>
                                    </div>
                                </div>
                            </label>

                            <!-- Reject -->
                            <label class="relative">
                                <input type="radio" name="status" value="rejected"
                                       class="sr-only peer"
                                       {{ $trainer->verification_status === 'rejected' ? 'checked' : '' }}>
                                <div class="p-4 border-2 border-slate-600/50 rounded-xl cursor-pointer transition-all duration-300 peer-checked:border-red-500 peer-checked:bg-red-500/10 peer-checked:shadow-lg peer-checked:shadow-red-500/20">
                                    <div class="flex items-center gap-3">
                                        <div class="w-6 h-6 rounded-full border-2 border-slate-500 peer-checked:border-red-500 peer-checked:bg-red-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white hidden peer-checked:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-white font-semibold">Tolak</p>
                                            <p class="text-slate-400 text-sm">Trainer tidak memenuhi syarat</p>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Admin Feedback -->
                        <div>
                            <label for="admin_feedback" class="block text-sm font-medium text-slate-300 mb-2">
                                Feedback Admin
                            </label>
                            <textarea name="admin_feedback" id="admin_feedback" rows="4"
                                      placeholder="Berikan alasan atau feedback untuk trainer..."
                                      class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all duration-300 resize-none">{{ old('admin_feedback', $trainer->trainerVerification->admin_feedback ?? '') }}</textarea>
                            <p class="text-xs text-slate-500 mt-1">Wajib diisi jika menolak verifikasi</p>
                        </div>
                    </div>
                </div>

                <!-- Form Footer -->
                <div class="bg-slate-800/50 px-8 py-6 border-t border-slate-700/50">
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                        <a href="{{ route('admin.trainers.show', $trainer) }}"
                           class="px-6 py-3 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Batal
                        </a>
                        <button type="submit"
                                class="px-8 py-3 rounded-xl bg-gradient-to-r from-orange-500 to-amber-600 text-white font-bold shadow-lg hover:shadow-orange-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Verifikasi
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

</x-layouts.admin>
