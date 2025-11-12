<x-layouts.admin>
    <x-slot name="title">
        Edit Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Nutrisi</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Edit Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Nutrisi</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Update informasi program nutrisi yang sudah ada</p>
                </div>
                <a href="{{ route('admin.nutrition-programs.index') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <form id="update-plan-form" action="{{ route('admin.nutrition-programs.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">

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

                <!-- Basic Information Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Dasar Menu
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nama Menu -->
                        <div>
                            <label for="meal_name" class="block text-sm font-medium text-green-400 mb-2">Nama Menu</label>
                            <input type="text" name="meal_name" id="meal_name" value="{{ old('meal_name', $plan->meal_name) }}" required
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400 transition-all duration-300 backdrop-blur-sm"
                                   placeholder="Misal: Dada Ayam Bakar Premium">
                        </div>

                        <!-- Target Fitness -->
                        <div>
                            <label for="target_fitness" class="block text-sm font-medium text-emerald-400 mb-2">Target Fitness</label>
                            <select name="target_fitness" id="target_fitness" required
                                    class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400 transition-all duration-300 backdrop-blur-sm">
                                <option value="">-- Pilih Target --</option>
                                <option value="cutting" {{ old('target_fitness', $plan->target_fitness) == 'cutting' ? 'selected' : '' }}>🔥 Cutting (Defisit Kalori)</option>
                                <option value="maintenance" {{ old('target_fitness', $plan->target_fitness) == 'maintenance' ? 'selected' : '' }}>⚖️ Maintenance</option>
                                <option value="bulking" {{ old('target_fitness', $plan->target_fitness) == 'bulking' ? 'selected' : '' }}>💪 Bulking (Surplus Kalori)</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Nutrition Information Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                        Informasi Nutrisi
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Kalori -->
                        <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-xl p-4">
                            <label for="calories" class="block text-sm font-medium text-orange-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"/>
                                </svg>
                                Kalori (kcal)
                            </label>
                            <input type="number" step="0.1" name="calories" id="calories" value="{{ old('calories', $plan->calories) }}" required
                                   class="w-full bg-orange-500/5 border border-orange-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-orange-400 focus:border-orange-400 transition-all">
                        </div>

                        <!-- Protein -->
                        <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-xl p-4">
                            <label for="protein" class="block text-sm font-medium text-green-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Protein (g)
                            </label>
                            <input type="number" step="0.1" name="protein" id="protein" value="{{ old('protein', $plan->protein) }}" required
                                   class="w-full bg-green-500/5 border border-green-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-green-400 focus:border-green-400 transition-all">
                        </div>

                        <!-- Karbohidrat -->
                        <div class="bg-gradient-to-br from-yellow-500/10 to-yellow-600/5 border border-yellow-500/20 rounded-xl p-4">
                            <label for="carbs" class="block text-sm font-medium text-yellow-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Karbohidrat (g)
                            </label>
                            <input type="number" step="0.1" name="carbs" id="carbs" value="{{ old('carbs', $plan->carbs) }}" required
                                   class="w-full bg-yellow-500/5 border border-yellow-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-yellow-400 focus:border-yellow-400 transition-all">
                        </div>

                        <!-- Lemak -->
                        <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 border border-red-500/20 rounded-xl p-4">
                            <label for="fat" class="block text-sm font-medium text-red-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                                Lemak (g)
                            </label>
                            <input type="number" step="0.1" name="fat" id="fat" value="{{ old('fat', $plan->fat) }}" required
                                   class="w-full bg-red-500/5 border border-red-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-red-400 focus:border-red-400 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Schedule Information Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Jadwal & Waktu Makan
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Hari -->
                        <div>
                            <label for="day_of_week" class="block text-sm font-medium text-blue-400 mb-2">Hari</label>
                            <select name="day_of_week" id="day_of_week" required
                                    class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-300 backdrop-blur-sm">
                                <option value="">-- Pilih Hari --</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ old('day_of_week', $plan->day_of_week) == $day ? 'selected' : '' }}>📅 {{ $day }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tipe Waktu Makan -->
                        <div>
                            <label for="type" class="block text-sm font-medium text-cyan-400 mb-2">Tipe Waktu Makan</label>
                            <select name="type" id="type" required
                                    class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-400 transition-all duration-300 backdrop-blur-sm">
                                <option value="">-- Pilih Tipe --</option>
                                <option value="breakfast" {{ old('type', $plan->type) == 'breakfast' ? 'selected' : '' }}>🌅 Sarapan</option>
                                <option value="lunch" {{ old('type', $plan->type) == 'lunch' ? 'selected' : '' }}>☀️ Makan Siang</option>
                                <option value="dinner" {{ old('type', $plan->type) == 'dinner' ? 'selected' : '' }}>🌙 Makan Malam</option>
                                <option value="snack" {{ old('type', $plan->type) == 'snack' ? 'selected' : '' }}>🍎 Cemilan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Footer dengan Delete dan Save Button -->
        <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 px-6 py-4 flex justify-between items-center border-t border-slate-700/30">
            <!-- Delete Button -->
            <form action="{{ route('admin.nutrition-programs.destroy', $plan) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus program ini?');" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-red-500 to-red-600 text-white font-bold shadow-lg hover:shadow-red-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Program
                </button>
            </form>

            <!-- Save Button -->
            <div class="flex gap-3">
                <a href="{{ route('admin.nutrition-programs.index') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Batal
                </a>
                <button type="submit" form="update-plan-form"
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
        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
        }

        input:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }
    </style>

</x-layouts.admin>
