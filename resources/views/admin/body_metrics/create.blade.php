<x-layouts.admin>
    <x-slot name="title">
        Tambah Log <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Body Metric</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-4xl mx-auto">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Tambah Log <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Body Metric</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Catat progres fisik dan body metrics user</p>
                </div>
                <a href="{{ route('admin.body-metrics.index') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Daftar
                </a>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('admin.body-metrics.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
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

                <!-- User & Date Information Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi User & Tanggal
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Selection -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-green-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Pilih User (Member)
                            </label>
                            <select name="user_id" id="user_id" required
                                    class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400 transition-all duration-300 backdrop-blur-sm">
                                <option value="">-- Pilih User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date Selection -->
                        <div>
                            <label for="recorded_at" class="block text-sm font-medium text-emerald-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                Tanggal Pencatatan
                            </label>
                            <input type="datetime-local" name="recorded_at" id="recorded_at" value="{{ old('recorded_at', now()->format('Y-m-d\TH:i')) }}" required
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400 transition-all duration-300 backdrop-blur-sm">
                        </div>
                    </div>
                </div>

                <!-- Body Metrics Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-orange-400 rounded-full"></div>
                        Body Metrics & Measurements
                    </h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Weight -->
                        <div class="bg-gradient-to-br from-orange-500/10 to-orange-600/5 border border-orange-500/20 rounded-xl p-4">
                            <label for="weight" class="block text-sm font-medium text-orange-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                                </svg>
                                Berat Badan (kg)
                            </label>
                            <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}"
                                   class="w-full bg-orange-500/5 border border-orange-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-orange-400 focus:border-orange-400 transition-all">
                        </div>

                        <!-- Height -->
                        <div class="bg-gradient-to-br from-blue-500/10 to-blue-600/5 border border-blue-500/20 rounded-xl p-4">
                            <label for="height" class="block text-sm font-medium text-blue-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                                Tinggi Badan (cm)
                            </label>
                            <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}"
                                   class="w-full bg-blue-500/5 border border-blue-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-blue-400 focus:border-blue-400 transition-all">
                        </div>

                        <!-- Body Fat -->
                        <div class="bg-gradient-to-br from-red-500/10 to-red-600/5 border border-red-500/20 rounded-xl p-4">
                            <label for="body_fat" class="block text-sm font-medium text-red-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
                                </svg>
                                Lemak Tubuh (%)
                            </label>
                            <input type="number" step="0.1" name="body_fat" id="body_fat" value="{{ old('body_fat') }}"
                                   class="w-full bg-red-500/5 border border-red-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-red-400 focus:border-red-400 transition-all">
                        </div>

                        <!-- Muscle Mass -->
                        <div class="bg-gradient-to-br from-green-500/10 to-green-600/5 border border-green-500/20 rounded-xl p-4">
                            <label for="muscle_mass" class="block text-sm font-medium text-green-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Massa Otot (kg)
                            </label>
                            <input type="number" step="0.1" name="muscle_mass" id="muscle_mass" value="{{ old('muscle_mass') }}"
                                   class="w-full bg-green-500/5 border border-green-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-green-400 focus:border-green-400 transition-all">
                        </div>

                        <!-- Waist -->
                        <div class="bg-gradient-to-br from-purple-500/10 to-purple-600/5 border border-purple-500/20 rounded-xl p-4">
                            <label for="waist" class="block text-sm font-medium text-purple-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                                </svg>
                                Lingkar Pinggang (cm)
                            </label>
                            <input type="number" step="0.1" name="waist" id="waist" value="{{ old('waist') }}"
                                   class="w-full bg-purple-500/5 border border-purple-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-purple-400 focus:border-purple-400 transition-all">
                        </div>

                        <!-- Arm -->
                        <div class="bg-gradient-to-br from-cyan-500/10 to-cyan-600/5 border border-cyan-500/20 rounded-xl p-4">
                            <label for="arm" class="block text-sm font-medium text-cyan-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Lingkar Lengan (cm)
                            </label>
                            <input type="number" step="0.1" name="arm" id="arm" value="{{ old('arm') }}"
                                   class="w-full bg-cyan-500/5 border border-cyan-500/30 rounded-lg px-3 py-2 text-white focus:outline-none focus:ring-1 focus:ring-cyan-400 focus:border-cyan-400 transition-all">
                        </div>
                    </div>
                </div>

                <!-- Photo Progress Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                        Foto Progress (Opsional)
                    </h4>

                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <input type="file" name="photo_progress" id="photo_progress" accept="image/*"
                                   class="w-full text-sm text-slate-400
                                          file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0
                                          file:text-sm file:font-semibold file:transition-all file:duration-300
                                          file:bg-gradient-to-r file:from-yellow-500/20 file:to-yellow-600/10
                                          file:text-yellow-400 file:border file:border-yellow-500/30
                                          hover:file:bg-yellow-500/30 hover:file:shadow-yellow-500/20
                                          hover:file:transform hover:file:-translate-y-0.5">
                        </div>
                        <div class="w-16 h-16 bg-slate-700/50 rounded-xl border border-slate-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Unggah foto progress untuk dokumentasi visual perkembangan user</p>
                </div>
            </div>

            <!-- Footer dengan CTA Button -->
            <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 px-6 py-4 flex justify-end border-t border-slate-700/30">
                <div class="flex gap-3">
                    <a href="{{ route('admin.body-metrics.index') }}"
                       class="px-6 py-3 rounded-xl bg-gradient-to-r from-slate-700 to-slate-600 text-white font-bold shadow-lg hover:shadow-slate-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </a>
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Log Body Metric
                    </button>
                </div>
            </div>
        </form>
    </div>

    <style>
        input:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        /* Custom file input styling */
        input[type="file"]::-webkit-file-upload-button {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.2), rgba(202, 138, 4, 0.1));
            border: 1px solid rgba(234, 179, 8, 0.3);
            color: rgb(250, 204, 21);
            padding: 12px 24px;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        input[type="file"]::-webkit-file-upload-button:hover {
            background: linear-gradient(135deg, rgba(234, 179, 8, 0.3), rgba(202, 138, 4, 0.2));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(234, 179, 8, 0.2);
        }
    </style>

</x-layouts.admin>
