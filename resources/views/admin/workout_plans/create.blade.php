<x-layouts.admin>
    <x-slot name="title">
        Buat Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Latihan</span>
    </x-slot>

    <!-- TAMBAHKAN CSS OVERRIDE YANG SAMA -->
    <style>
        /* OVERRIDE UNTUK MENGGANTI WARNA TEXT DI BACKGROUND HITAM */
        .force-white { color: #ffffff !important; }
        .force-gray-300 { color: #d1d5db !important; }
        .force-gray-400 { color: #9ca3af !important; }
        .force-gray-500 { color: #6b7280 !important; }

        /* Override input text colors */
        .force-input-text { color: #d1d5db !important; }
        .force-input-placeholder::placeholder { color: #6b7280 !important; }

        /* Override border untuk consistency */
        .force-border-slate-600 { border-color: #4b5563 !important; }
        .force-border-slate-700 { border-color: #374151 !important; }

        /* Custom untuk form ini */
        .force-form-bg { background-color: rgba(30, 41, 59, 0.4) !important; }
    </style>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <form id="create-plan-form" action="{{ route('admin.workout-plans.store') }}" method="POST">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-slate-700/50">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold force-white">
                            Buat Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Latihan</span> Baru
                        </h3>
                        <p class="text-sm force-gray-400 mt-1">Buat template program latihan profesional untuk user</p>
                    </div>
                </div>
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
                            <strong class="force-white">Perhatian!</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 force-gray-300">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Basic Information Section -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Dasar
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Title -->
                        <div class="md:col-span-2">
                            <label for="title" class="block text-sm font-medium force-gray-300 mb-2">Judul Program</label>
                            <div class="relative">
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text force-input-placeholder placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: Full Body Beginner (3x Seminggu)">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium force-gray-300 mb-2">Status</label>
                            <div class="relative">
                                <select name="status" id="status" required
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="active">Active (Tampilkan ke User)</option>
                                    <option value="inactive">Inactive (Draft)</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description Section -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Deskripsi Program
                    </h4>
                    <div>
                        <label for="description" class="block text-sm font-medium force-gray-300 mb-2">Deskripsi Program</label>
                        <div class="relative">
                            <textarea name="description" id="description" rows="3"
                                      class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text force-input-placeholder placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 resize-none"
                                      placeholder="Jelaskan tujuan dan manfaat program latihan ini...">{{ old('description') }}</textarea>
                            <div class="absolute top-3 left-3">
                                <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <p class="text-xs force-gray-500 mt-2">Deskripsi akan membantu user memahami program latihan</p>
                    </div>
                </div>

                <!-- Fitness Goals Section -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Target & Fokus
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Target Fitness -->
                        <div>
                            <label for="target_fitness" class="block text-sm font-medium force-gray-300 mb-2">Target Fitness</label>
                            <div class="relative">
                                <select name="target_fitness" id="target_fitness"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih Target...</option>
                                    <option value="muscle_gain">Muscle Gain</option>
                                    <option value="weight_loss">Weight Loss</option>
                                    <option value="strength">Strength</option>
                                    <option value="endurance">Endurance</option>
                                    <option value="general_fitness">General Fitness</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Focus Area -->
                        <div>
                            <label for="focus_area" class="block text-sm font-medium force-gray-300 mb-2">Fokus Area</label>
                            <div class="relative">
                                <select name="focus_area" id="focus_area"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih Fokus...</option>
                                    <option value="bulking">Bulking</option>
                                    <option value="cutting">Cutting</option>
                                    <option value="maintenance">Maintenance</option>
                                    <option value="full_body">Full Body</option>
                                    <option value="upper_lower">Upper/Lower</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- BMI Category -->
                        <div>
                            <label for="bmi_category" class="block text-sm font-medium force-gray-300 mb-2">Kategori BMI</label>
                            <div class="relative">
                                <select name="bmi_category" id="bmi_category"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih BMI...</option>
                                    <option value="underweight">Underweight</option>
                                    <option value="normal">Normal</option>
                                    <option value="overweight">Overweight</option>
                                    <option value="obese">Obese</option>
                                    <option value="all">All Categories</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Details Section -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                        Detail Program
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Difficulty Level -->
                        <div>
                            <label for="difficulty_level" class="block text-sm font-medium force-gray-300 mb-2">Level Kesulitan</label>
                            <div class="relative">
                                <select name="difficulty_level" id="difficulty_level"
                                        class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                                    <option value="">Pilih Level...</option>
                                    <option value="beginner">Beginner</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                    <option value="all_levels">All Levels</option>
                                </select>
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Weeks -->
                        <div>
                            <label for="duration_weeks" class="block text-sm font-medium force-gray-300 mb-2">Durasi (Minggu)</label>
                            <div class="relative">
                                <input type="number" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text force-input-placeholder placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: 4">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Duration Minutes -->
                        <div>
                            <label for="duration_minutes" class="block text-sm font-medium force-gray-300 mb-2">Durasi (Menit/sesi)</label>
                            <div class="relative">
                                <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 force-input-text force-input-placeholder placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Misal: 60">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 force-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Exercises Section -->
                <div class="border-t border-slate-700/50 pt-8">
                    <h4 class="text-lg font-semibold force-white mb-6 flex items-center gap-2">
                        <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                        Daftar Gerakan Latihan
                    </h4>

                    <div class="mb-6" id="exercises-container">
                        <!-- Container for exercises -->
                        <div id="exercises-list">
                            <!-- Will be filled by JavaScript -->
                        </div>

                        <!-- Add Exercise Button -->
                        <div class="flex justify-center mt-6">
                            <button type="button" onclick="addExercise()"
                                    class="px-5 py-2.5 bg-gradient-to-r from-green-500/20 to-emerald-600/20 text-green-400 border border-green-500/30 rounded-xl hover:bg-green-500/30 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Tambah Gerakan
                            </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-slate-800/50 px-8 py-6 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.workout-plans.index') }}"
                           class="px-6 py-3 rounded-xl border border-slate-600/50 force-gray-300 hover:force-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>

                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Buat Program
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- JavaScript with Video Support -->
    <script>
        let exerciseIndex = 0;

        function addExercise() {
            const container = document.getElementById('exercises-list');

            const exerciseHTML = `
                <div class="exercise-item bg-slate-800/40 p-5 rounded-xl mb-4 border border-slate-700/30 hover:border-green-500/30 transition-all duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-lg font-semibold force-white">Gerakan #${exerciseIndex + 1}</h5>
                        <button type="button" onclick="removeExercise(this)"
                                class="px-3 py-1.5 bg-red-500/20 text-red-400 border border-red-500/30 rounded-lg hover:bg-red-500/30 transition-colors flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Hapus
                        </button>
                    </div>

                    <!-- Basic Exercise Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Nama Gerakan *</label>
                            <input type="text" name="exercises[${exerciseIndex}][name]"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text placeholder-gray-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all"
                                   placeholder="Push Up, Squat, etc" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Tipe Gerakan</label>
                            <select name="exercises[${exerciseIndex}][type]"
                                    class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all">
                                <option value="strength">Strength</option>
                                <option value="cardio">Cardio</option>
                                <option value="core">Core</option>
                                <option value="flexibility">Flexibility</option>
                                <option value="balance">Balance</option>
                            </select>
                        </div>
                    </div>

                    <!-- Video URL -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium force-gray-300 mb-2">URL Video Demonstrasi</label>
                        <div class="flex items-center gap-2">
                            <input type="url" name="exercises[${exerciseIndex}][video_url]"
                                   class="flex-1 px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text placeholder-gray-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all"
                                   placeholder="https://youtube.com/watch?v=... atau /storage/videos/...">
                            <button type="button" onclick="previewVideo(${exerciseIndex})" class="px-4 py-2.5 bg-blue-500/20 text-blue-400 border border-blue-500/30 rounded-lg hover:bg-blue-500/30 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Preview
                            </button>
                        </div>
                        <p class="text-xs force-gray-500 mt-1">Support YouTube URL atau video lokal</p>

                        <!-- Video Preview Area -->
                        <div id="video-preview-${exerciseIndex}" class="mt-3 hidden">
                            <div class="bg-slate-800/50 rounded-lg p-3 border border-slate-700">
                                <p class="text-sm force-gray-400 mb-2">Preview Video:</p>
                                <div class="aspect-video bg-slate-900 rounded flex items-center justify-center">
                                    <p class="force-gray-500">Video akan muncul setelah diisi</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium force-gray-300 mb-2">Instruksi (Opsional)</label>
                        <textarea name="exercises[${exerciseIndex}][instructions]" rows="2"
                                  class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text placeholder-gray-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all resize-none"
                                  placeholder="Contoh: Pastikan punggung tetap lurus, turunkan dada sampai 10cm dari lantai..."></textarea>
                    </div>

                    <!-- Sets, Reps, Rest -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Sets</label>
                            <input type="number" name="exercises[${exerciseIndex}][sets]" min="1" max="10"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all"
                                   value="3">
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Reps</label>
                            <input type="text" name="exercises[${exerciseIndex}][reps]"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text placeholder-gray-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all"
                                   placeholder="10-12 atau 30 detik" value="10-12">
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Rest (detik)</label>
                            <input type="number" name="exercises[${exerciseIndex}][rest_seconds]" min="0" max="300"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all"
                                   value="60">
                        </div>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', exerciseHTML);
            exerciseIndex++;
        }

        function removeExercise(button) {
            const exerciseItem = button.closest('.exercise-item');
            if (exerciseItem) {
                exerciseItem.remove();
                // Update exercise numbers
                updateExerciseNumbers();
            }
        }

        function updateExerciseNumbers() {
            const exerciseItems = document.querySelectorAll('.exercise-item');
            exerciseItems.forEach((item, index) => {
                const title = item.querySelector('h5');
                if (title) {
                    title.textContent = `Gerakan #${index + 1}`;
                }
            });
        }

        function previewVideo(index) {
            const videoUrl = document.querySelector(`input[name="exercises[${index}][video_url]"]`).value;
            const previewDiv = document.getElementById(`video-preview-${index}`);

            if (!videoUrl) {
                alert('Masukkan URL video terlebih dahulu');
                return;
            }

            // Show preview area
            previewDiv.classList.remove('hidden');

            // If YouTube URL
            if (videoUrl.includes('youtube.com') || videoUrl.includes('youtu.be')) {
                const videoId = extractYouTubeId(videoUrl);
                if (videoId) {
                    const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                    previewDiv.innerHTML = `
                        <div class="bg-slate-800/50 rounded-lg p-3 border border-slate-700">
                            <p class="text-sm force-gray-400 mb-2">YouTube Preview:</p>
                            <div class="aspect-video">
                                <iframe src="${embedUrl}"
                                        class="w-full h-full rounded"
                                        frameborder="0"
                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                        allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    `;
                }
            } else {
                // Local video or other URL
                previewDiv.innerHTML = `
                    <div class="bg-slate-800/50 rounded-lg p-3 border border-slate-700">
                        <p class="text-sm force-gray-400 mb-2">Video Preview:</p>
                        <div class="aspect-video bg-slate-900 rounded flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 force-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="force-gray-500 text-sm">Video dari: ${videoUrl}</p>
                                <p class="force-gray-600 text-xs mt-1">Video akan dimuat saat user menonton</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        function extractYouTubeId(url) {
            const regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#&?]*).*/;
            const match = url.match(regExp);
            return (match && match[7].length === 11) ? match[7] : false;
        }

        // Add one exercise on page load
        document.addEventListener('DOMContentLoaded', function() {
            addExercise();
        });
    </script>

    <style>
        /* Hide number input spinners */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type="number"] {
            -moz-appearance: textfield;
        }

        .exercise-item {
            transition: all 0.3s ease;
        }
    </style>

</x-layouts.admin>
