<x-layouts.admin>
    <x-slot name="title">
        Detail <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Pesan</span>
    </x-slot>

    <!-- Header Section -->
    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6 mb-6">
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-white">
                    Detail <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Pesan</span>
                </h1>
                <p class="text-sm text-slate-400 mt-2">Informasi lengkap pesan dari form kontak</p>
            </div>
            <a href="{{ route('admin.contact.index') }}"
               class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali ke Daftar Pesan
            </a>
        </div>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Message Information Card -->
        <div class="p-6 md:p-8 space-y-8">

            <!-- Sender Information -->
            <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    Informasi Pengirim
                </h4>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500/20 to-teal-600/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-slate-400">Nama Pengirim</div>
                                <div class="text-lg font-semibold text-white">{{ $message->name }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500/20 to-cyan-600/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-slate-400">Email Pengirim</div>
                                <div class="text-lg font-semibold text-white">{{ $message->email }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-orange-500/20 to-amber-600/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-slate-400">Waktu Kirim</div>
                                <div class="text-lg font-semibold text-white">{{ $message->created_at->format('d M Y, H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500/20 to-pink-600/20 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm text-slate-400">Subjek Pesan</div>
                                <div class="text-lg font-semibold text-white">{{ $message->subject ?? '(Tidak ada subjek)' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Message Content -->
            <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                    Isi Pesan
                </h4>

                <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-600/30">
                    <div class="text-slate-300 leading-relaxed whitespace-pre-wrap text-lg">
                        {{ $message->message }}
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer dengan Delete Button -->
        <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 px-6 py-4 flex justify-between items-center border-t border-slate-700/30">
            <div class="text-sm text-slate-400">
                Pesan ID: #{{ $message->id }}
            </div>

            <div class="flex gap-3">
                <form action="{{ route('admin.contact.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus pesan ini?')" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white font-bold shadow-lg hover:shadow-red-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                        Hapus Pesan
                    </button>
                </form>
            </div>
        </div>
    </div>

    <style>
        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        .whitespace-pre-wrap {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>

</x-layouts.admin>
