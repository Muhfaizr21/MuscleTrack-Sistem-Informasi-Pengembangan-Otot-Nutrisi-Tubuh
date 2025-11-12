<x-layouts.admin>
    <x-slot name="title">
        Edit <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Goal</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-2xl mx-auto">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Edit <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Goal</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Update informasi goal dan target fitness</p>
                </div>
                <a href="{{ route('admin.goals.index') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <form id="update-goal-form" action="{{ route('admin.goals.update', $goal) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-8">

                @if ($errors->any())
                    <div class="p-4 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Goal Information Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6 space-y-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Goal
                    </h4>

                    <!-- Nama Goal -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-green-400 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Nama Goal
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name', $goal->name) }}" required
                               class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400 transition-all duration-300 backdrop-blur-sm"
                               placeholder="Misal: Bulking (Muscle Gain), Weight Loss, Maintenance">
                        <p class="text-xs text-slate-500 mt-2">Nama goal yang jelas dan deskriptif</p>
                    </div>

                    <!-- Deskripsi Goal -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-emerald-400 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                            </svg>
                            Deskripsi Goal (Opsional)
                        </label>
                        <textarea name="description" id="description" rows="4"
                                  class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400 transition-all duration-300 backdrop-blur-sm resize-none"
                                  placeholder="Jelaskan detail goal, target yang ingin dicapai, atau panduan untuk user...">{{ old('description', $goal->description) }}</textarea>
                        <p class="text-xs text-slate-500 mt-2">Deskripsi membantu user memahami tujuan goal</p>
                    </div>
                </div>

                <!-- Goal Stats Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Informasi Goal
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                            <div class="text-slate-400 text-xs">Dibuat Pada</div>
                            <div class="font-semibold text-white mt-1">{{ $goal->created_at->format('d M Y, H:i') }}</div>
                        </div>
                        <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                            <div class="text-slate-400 text-xs">Terakhir Diupdate</div>
                            <div class="font-semibold text-white mt-1">{{ $goal->updated_at->format('d M Y, H:i') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Footer dengan Delete dan Save Button -->
        <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 px-6 py-4 flex justify-between items-center border-t border-slate-700/30">
            <!-- Delete Button -->
            <form action="{{ route('admin.goals.destroy', $goal) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus goal \"{{ $goal->name }}\"?');" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white font-bold shadow-lg hover:shadow-red-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Goal
                </button>
            </form>

            <!-- Save Button -->
            <div class="flex gap-3">
                <a href="{{ route('admin.goals.index') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" form="update-goal-form"
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </div>
    </div>

    <style>
        input:focus, textarea:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        textarea {
            resize: none;
        }

        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.5);
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.5);
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.7);
        }
    </style>

</x-layouts.admin>
