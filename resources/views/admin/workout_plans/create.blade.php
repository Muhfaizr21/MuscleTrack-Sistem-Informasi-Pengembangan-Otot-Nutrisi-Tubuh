<x-layouts.admin>
    <x-slot name="title">
        Buat Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Latihan Baru</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <form action="{{ route('admin.workout-plans.store') }}" method="POST">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-slate-700/50">
                <h3 class="text-2xl font-bold text-white">
                    Buat Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Latihan Baru</span>
                </h3>
                <p class="text-sm text-slate-400 mt-1">Buat template program latihan profesional untuk user</p>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <strong>Perhatian!</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Basic Information Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Dasar
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium text-slate-300 mb-2">Judul Program</label>
                            <div class="relative">
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: Full Body Beginner (3x Seminggu)">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                            <div class="relative">
                                <select name="status" id="status" required
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active (Tampilkan ke User)</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Deskripsi Program
                    </h4>
                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Program</label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="3"
                                      class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 resize-none"
                                      placeholder="Jelaskan tujuan dan manfaat program latihan ini...">{{ old('description') }}</textarea>
                            <div class="absolute top-3 left-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs text-slate-500 mt-2">Deskripsi akan membantu user memahami program latihan</p>
                    </div>
                </div>

                <!-- Fitness Goals Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Target & Fokus
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Target Fitness -->
                        <div>
                            <label for="target_fitness" class="block text-sm font-medium text-slate-300 mb-2">Target Fitness</label>
                            <div class="relative">
                                <select name="target_fitness" id="target_fitness"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih Target...</option>
                                    <option value="muscle_gain" {{ old('target_fitness') == 'muscle_gain' ? 'selected' : '' }}>Muscle Gain</option>
                                    <option value="weight_loss" {{ old('target_fitness') == 'weight_loss' ? 'selected' : '' }}>Weight Loss</option>
                                    <option value="strength" {{ old('target_fitness') == 'strength' ? 'selected' : '' }}>Strength</option>
                                    <option value="endurance" {{ old('target_fitness') == 'endurance' ? 'selected' : '' }}>Endurance</option>
                                    <option value="general_fitness" {{ old('target_fitness') == 'general_fitness' ? 'selected' : '' }}>General Fitness</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Focus Area -->
                        <div>
                            <label for="focus_area" class="block text-sm font-medium text-slate-300 mb-2">Fokus Area</label>
                            <div class="relative">
                                <select name="focus_area" id="focus_area"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih Fokus...</option>
                                    <option value="bulking" {{ old('focus_area') == 'bulking' ? 'selected' : '' }}>Bulking</option>
                                    <option value="cutting" {{ old('focus_area') == 'cutting' ? 'selected' : '' }}>Cutting</option>
                                    <option value="maintenance" {{ old('focus_area') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                    <option value="full_body" {{ old('focus_area') == 'full_body' ? 'selected' : '' }}>Full Body</option>
                                    <option value="upper_lower" {{ old('focus_area') == 'upper_lower' ? 'selected' : '' }}>Upper/Lower</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- BMI Category -->
                        <div>
                            <label for="bmi_category" class="block text-sm font-medium text-slate-300 mb-2">Kategori BMI</label>
                            <div class="relative">
                                <select name="bmi_category" id="bmi_category"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih BMI...</option>
                                    <option value="underweight" {{ old('bmi_category') == 'underweight' ? 'selected' : '' }}>Underweight</option>
                                    <option value="normal" {{ old('bmi_category') == 'normal' ? 'selected' : '' }}>Normal</option>
                                    <option value="overweight" {{ old('bmi_category') == 'overweight' ? 'selected' : '' }}>Overweight</option>
                                    <option value="obese" {{ old('bmi_category') == 'obese' ? 'selected' : '' }}>Obese</option>
                                    <option value="all" {{ old('bmi_category') == 'all' ? 'selected' : '' }}>All Categories</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Details Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                        Detail Program
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Difficulty Level -->
                        <div>
                            <label for="difficulty_level" class="block text-sm font-medium text-slate-300 mb-2">Level Kesulitan</label>
                            <div class="relative">
                                <select name="difficulty_level" id="difficulty_level"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih Level...</option>
                                    <option value="beginner" {{ old('difficulty_level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                    <option value="intermediate" {{ old('difficulty_level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                    <option value="advanced" {{ old('difficulty_level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                    <option value="all_levels" {{ old('difficulty_level') == 'all_levels' ? 'selected' : '' }}>All Levels</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Weeks -->
                        <div>
                            <label for="duration_weeks" class="block text-sm font-medium text-slate-300 mb-2">Durasi (Minggu)</label>
                            <div class="relative">
                                <input type="number" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: 4">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Minutes -->
                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium text-slate-300 mb-2">Durasi (Menit/sesi)</label>
                            <div class="relative">
                                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: 60">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-slate-800/50 px-8 py-6 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <a href="{{ route('admin.workout-plans.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar
                    </a>
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Program
                    </button>
                </div>
            </div>
        </form>
    </div>

</x-layouts.admin>
