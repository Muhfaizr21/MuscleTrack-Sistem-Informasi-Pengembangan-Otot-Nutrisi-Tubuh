@php
// Function untuk ekstrak ID YouTube
function extractYouTubeId($url) {
    if (!$url) return null;

    $patterns = [
        '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i',
        '/youtube\.com\/embed\/([^"&?\/\s]{11})/i',
        '/youtube\.com\/v\/([^"&?\/\s]{11})/i',
        '/youtube\.com\/watch\?v=([^"&?\/\s]{11})/i'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $url, $matches)) {
            return $matches[1] ?? null;
        }
    }

    return null;
}
@endphp

<x-layouts.admin>
    <x-slot name="title">Edit Program Latihan</x-slot>

    <style>
        /* OVERRIDE UNTUK MENGGANTI WARNA TEXT DI BACKGROUND HITAM */
        .force-white { color: #ffffff !important; }
        .force-gray-300 { color: #d1d5db !important; }
        .force-gray-400 { color: #9ca3af !important; }
        .force-gray-500 { color: #6b7280 !important; }

        /* Override untuk form */
        .force-input-text { color: #d1d5db !important; }
        .force-input-placeholder::placeholder { color: #6b7280 !important; }

        /* Override border colors */
        .force-border-slate-600 { border-color: #4b5563 !important; }
        .force-border-slate-700 { border-color: #374151 !important; }

        /* Badge colors */
        .badge-green {
            background: rgba(5, 150, 105, 0.2) !important;
            border: 1px solid rgba(5, 150, 105, 0.3) !important;
            color: #34d399 !important;
        }
        .badge-blue {
            background: rgba(59, 130, 246, 0.2) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            color: #60a5fa !important;
        }
        .badge-red {
            background: rgba(239, 68, 68, 0.2) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #f87171 !important;
        }
        .badge-yellow {
            background: rgba(245, 158, 11, 0.2) !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            color: #fbbf24 !important;
        }

        /* Loading overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #10b981;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Loading Overlay -->
    <div id="loadingOverlay" class="loading-overlay">
        <div class="loading-spinner"></div>
        <p class="text-white text-lg font-semibold">Menyimpan data...</p>
    </div>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">
        <form action="{{ route('admin.workout-plans.update', $workoutPlan) }}" method="POST" id="workoutPlanForm" onsubmit="showLoading()">
            @csrf
            @method('PUT')

            <!-- Header -->
            <div class="p-6 border-b force-border-slate-700">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-bold force-white">Edit Program Latihan</h3>
                        <p class="text-sm force-gray-400 mt-1">{{ $workoutPlan->title }}</p>
                    </div>
                </div>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">
                @if ($errors->any())
                    <div class="bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">Ada kesalahan dalam pengisian form:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1 force-gray-300 ml-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('success'))
                    <div class="bg-green-500/15 backdrop-blur-sm text-green-400 border border-green-500/20 p-4 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Debug Info (Hanya di development) -->
                @if(config('app.debug'))
                <div class="bg-yellow-500/10 border border-yellow-500/20 p-4 rounded-xl">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="font-semibold text-yellow-400">Debug Info</span>
                    </div>
                    <div class="text-sm force-gray-300">
                        <p>Exercise Count: {{ count($workoutPlan->workoutExercises) }}</p>
                        <p>Form Action: {{ route('admin.workout-plans.update', $workoutPlan) }}</p>
                        <p>Method: PUT</p>
                    </div>
                </div>
                @endif

                <!-- Basic Info -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Dasar
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="title" class="block text-sm font-medium force-gray-300 mb-2">
                                Judul Program *
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title', $workoutPlan->title) }}" required
                                   class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500">
                            @error('title')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="status" class="block text-sm font-medium force-gray-300 mb-2">
                                Status *
                            </label>
                            <select name="status" id="status" required
                                    class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                <option value="active" {{ old('status', $workoutPlan->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $workoutPlan->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="draft" {{ old('status', $workoutPlan->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                            @error('status')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Deskripsi Program
                    </h4>
                    <div>
                        <label for="description" class="block text-sm font-medium force-gray-300 mb-2">
                            Deskripsi Program
                        </label>
                        <textarea name="description" id="description" rows="3"
                                  class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-y">{{ old('description', $workoutPlan->description) }}</textarea>
                        @error('description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Fields -->
                <div>
                    <h4 class="text-lg font-semibold force-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-emerald-400 rounded-full"></div>
                        Detail Tambahan
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="target_fitness" class="block text-sm font-medium force-gray-300 mb-2">
                                Target Fitness
                            </label>
                            <select name="target_fitness" id="target_fitness"
                                    class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                <option value="">Pilih Target...</option>
                                <option value="muscle_gain" {{ old('target_fitness', $workoutPlan->target_fitness) == 'muscle_gain' ? 'selected' : '' }}>Muscle Gain</option>
                                <option value="fat_loss" {{ old('target_fitness', $workoutPlan->target_fitness) == 'fat_loss' ? 'selected' : '' }}>Fat Loss</option>
                                <option value="bulking" {{ old('target_fitness', $workoutPlan->target_fitness) == 'bulking' ? 'selected' : '' }}>Bulking</option>
                                <option value="cutting" {{ old('target_fitness', $workoutPlan->target_fitness) == 'cutting' ? 'selected' : '' }}>Cutting</option>
                                <option value="maintain" {{ old('target_fitness', $workoutPlan->target_fitness) == 'maintain' ? 'selected' : '' }}>Maintain</option>
                                <option value="endurance" {{ old('target_fitness', $workoutPlan->target_fitness) == 'endurance' ? 'selected' : '' }}>Endurance</option>
                                <option value="strength" {{ old('target_fitness', $workoutPlan->target_fitness) == 'strength' ? 'selected' : '' }}>Strength</option>
                                <option value="general_fitness" {{ old('target_fitness', $workoutPlan->target_fitness) == 'general_fitness' ? 'selected' : '' }}>General Fitness</option>
                            </select>
                            @error('target_fitness')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="focus_area" class="block text-sm font-medium force-gray-300 mb-2">
                                Fokus Area
                            </label>
                            <select name="focus_area" id="focus_area"
                                    class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                <option value="">Pilih Fokus...</option>
                                <option value="foundation" {{ old('focus_area', $workoutPlan->focus_area) == 'foundation' ? 'selected' : '' }}>Foundation</option>
                                <option value="upper_lower_split" {{ old('focus_area', $workoutPlan->focus_area) == 'upper_lower_split' ? 'selected' : '' }}>Upper/Lower Split</option>
                                <option value="core_endurance" {{ old('focus_area', $workoutPlan->focus_area) == 'core_endurance' ? 'selected' : '' }}>Core Endurance</option>
                                <option value="full_body" {{ old('focus_area', $workoutPlan->focus_area) == 'full_body' ? 'selected' : '' }}>Full Body</option>
                                <option value="push_pull_legs" {{ old('focus_area', $workoutPlan->focus_area) == 'push_pull_legs' ? 'selected' : '' }}>Push/Pull/Legs</option>
                                <option value="cardio_focus" {{ old('focus_area', $workoutPlan->focus_area) == 'cardio_focus' ? 'selected' : '' }}>Cardio Focus</option>
                                <option value="mobility" {{ old('focus_area', $workoutPlan->focus_area) == 'mobility' ? 'selected' : '' }}>Mobility</option>
                            </select>
                            @error('focus_area')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="difficulty_level" class="block text-sm font-medium force-gray-300 mb-2">
                                Level Kesulitan *
                            </label>
                            <select name="difficulty_level" id="difficulty_level" required
                                    class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                <option value="">Pilih Level...</option>
                                <option value="beginner" {{ old('difficulty_level', $workoutPlan->difficulty_level) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('difficulty_level', $workoutPlan->difficulty_level) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('difficulty_level', $workoutPlan->difficulty_level) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                <option value="expert" {{ old('difficulty_level', $workoutPlan->difficulty_level) == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                            @error('difficulty_level')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Duration Fields -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="duration_weeks" class="block text-sm font-medium force-gray-300 mb-2">
                            Durasi (Minggu) *
                        </label>
                        <input type="number" name="duration_weeks" id="duration_weeks" min="1" max="52" required
                               value="{{ old('duration_weeks', $workoutPlan->duration_weeks) }}"
                               class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        @error('duration_weeks')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium force-gray-300 mb-2">
                            Durasi (Menit/sesi) *
                        </label>
                        <input type="number" name="duration_minutes" id="duration_minutes" min="10" max="180" required
                               value="{{ old('duration_minutes', $workoutPlan->duration_minutes) }}"
                               class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        @error('duration_minutes')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Additional Settings -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="sessions_per_week" class="block text-sm font-medium force-gray-300 mb-2">
                            Sesi per Minggu
                        </label>
                        <input type="number" name="sessions_per_week" id="sessions_per_week" min="1" max="14"
                               value="{{ old('sessions_per_week', $workoutPlan->sessions_per_week ?? 3) }}"
                               class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        @error('sessions_per_week')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="equipment_needed" class="block text-sm font-medium force-gray-300 mb-2">
                            Peralatan
                        </label>
                        <input type="text" name="equipment_needed" id="equipment_needed"
                               value="{{ old('equipment_needed', $workoutPlan->equipment_needed) }}"
                               class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        @error('equipment_needed')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium force-gray-300 mb-2">&nbsp;</label>
                        <div class="flex items-center h-full">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_premium" value="1"
                                       {{ old('is_premium', $workoutPlan->is_premium ?? false) ? 'checked' : '' }}
                                       class="sr-only peer">
                                <div class="relative w-11 h-6 bg-slate-700 rounded-full peer-checked:bg-green-600 transition-colors">
                                    <div class="absolute top-[2px] left-[2px] bg-white w-5 h-5 rounded-full transition-transform peer-checked:translate-x-5"></div>
                                </div>
                                <span class="ml-3 force-gray-300">Premium Program</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Detailed Description & Notes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="detailed_description" class="block text-sm font-medium force-gray-300 mb-2">
                            Deskripsi Detail
                        </label>
                        <textarea name="detailed_description" id="detailed_description" rows="4"
                                  class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-y">{{ old('detailed_description', $workoutPlan->detailed_description) }}</textarea>
                        @error('detailed_description')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="notes" class="block text-sm font-medium force-gray-300 mb-2">
                            Catatan Internal
                        </label>
                        <textarea name="notes" id="notes" rows="4"
                                  class="w-full bg-slate-700/50 border force-border-slate-600 rounded-xl py-3 px-4 force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-y">{{ old('notes', $workoutPlan->notes) }}</textarea>
                        @error('notes')
                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Exercises Section -->
                <div class="border-t force-border-slate-700 pt-8">
                    <h4 class="text-lg font-semibold force-white mb-6 flex items-center gap-2">
                        <div class="w-2 h-2 bg-amber-400 rounded-full"></div>
                        Daftar Gerakan Latihan
                    </h4>

                    <div class="mb-6 p-4 bg-slate-800/30 rounded-xl border force-border-slate-700">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="force-gray-300 text-sm">
                                <span class="font-semibold">Note:</span> Minimal 1 latihan diperlukan.
                            </span>
                        </div>
                    </div>

                    <div id="exercises-list">
                        @forelse($workoutPlan->exercises as $index => $exercise)
                            <div class="exercise-item bg-slate-800/40 p-5 rounded-xl mb-4 border force-border-slate-700 hover:border-green-500/30 transition-colors duration-300">
                                <div class="flex justify-between items-center mb-4">
                                    <h5 class="text-lg font-semibold force-white">
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500/20 text-green-400 rounded-full text-sm mr-2">
                                            {{ $index + 1 }}
                                        </span>
                                        Latihan {{ $index + 1 }}
                                    </h5>
                                    <button type="button" onclick="removeExercise(this)"
                                            class="px-3 py-1.5 badge-red hover:bg-red-500/30 transition-colors flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </div>

                                <!-- Hidden ID untuk update existing exercise -->
                                <input type="hidden" name="exercises[{{ $index }}][id]" value="{{ $exercise->id }}">

                                <!-- Basic Exercise Info -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Nama Gerakan *
                                        </label>
                                        <input type="text" name="exercises[{{ $index }}][name]"
                                               value="{{ old("exercises.$index.name", $exercise->name) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                               required>
                                        @error("exercises.$index.name")
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Tipe
                                        </label>
                                        <select name="exercises[{{ $index }}][type]"
                                                class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                            <option value="strength" {{ old("exercises.$index.type", $exercise->type) == 'strength' ? 'selected' : '' }}>Strength</option>
                                            <option value="cardio" {{ old("exercises.$index.type", $exercise->type) == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                            <option value="core" {{ old("exercises.$index.type", $exercise->type) == 'core' ? 'selected' : '' }}>Core</option>
                                            <option value="flexibility" {{ old("exercises.$index.type", $exercise->type) == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                            <option value="warmup" {{ old("exercises.$index.type", $exercise->type) == 'warmup' ? 'selected' : '' }}>Warmup</option>
                                            <option value="cooldown" {{ old("exercises.$index.type", $exercise->type) == 'cooldown' ? 'selected' : '' }}>Cooldown</option>
                                        </select>
                                        @error("exercises.$index.type")
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium force-gray-300 mb-2">
                                        Deskripsi Singkat
                                    </label>
                                    <textarea name="exercises[{{ $index }}][description]" rows="2"
                                              class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                              placeholder="Deskripsi latihan...">{{ old("exercises.$index.description", $exercise->description) }}</textarea>
                                </div>

                                <!-- Video URL -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium force-gray-300 mb-2">
                                        URL Video Demonstrasi
                                    </label>
                                    <div class="flex items-center gap-2">
                                        <input type="url" name="exercises[{{ $index }}][video_url]"
                                               value="{{ old("exercises.$index.video_url", $exercise->video_url) }}"
                                               class="flex-1 px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                               placeholder="https://youtube.com/watch?v=..."
                                               onchange="updateVideoPreview(this.value, {{ $index }})">
                                        <button type="button" onclick="previewVideo('{{ $exercise->video_url }}', {{ $index }})"
                                                class="px-4 py-2.5 badge-blue hover:bg-blue-500/30 transition-colors flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Preview
                                        </button>
                                    </div>
                                    <p class="text-xs force-gray-500 mt-1">Support YouTube URL</p>

                                    <!-- Video Preview Area -->
                                    <div id="video-preview-{{ $index }}" class="mt-3 {{ $exercise->video_url ? '' : 'hidden' }}">
                                        @if($exercise->video_url)
                                        <div class="bg-slate-800/50 rounded-lg p-3 border force-border-slate-700">
                                            <p class="text-sm force-gray-400 mb-2">Preview Video:</p>
                                            @php
                                                $videoId = extractYouTubeId($exercise->video_url);
                                            @endphp
                                            @if($videoId)
                                                <div class="aspect-video">
                                                    <iframe src="https://www.youtube.com/embed/{{ $videoId }}"
                                                            class="w-full h-full rounded"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen>
                                                    </iframe>
                                                </div>
                                            @else
                                                <div class="aspect-video bg-slate-900 rounded flex items-center justify-center">
                                                    <div class="text-center">
                                                        <svg class="w-12 h-12 force-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                        </svg>
                                                        <p class="force-gray-500 text-sm">Video: {{ Str::limit($exercise->video_url, 50) }}</p>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Instructions -->
                                <div class="mb-4">
                                    <label class="block text-sm font-medium force-gray-300 mb-2">
                                        Instruksi (Opsional)
                                    </label>
                                    <textarea name="exercises[{{ $index }}][instructions]" rows="2"
                                              class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                              placeholder="Contoh: Pastikan punggung tetap lurus...">{{ old("exercises.$index.instructions", $exercise->instructions) }}</textarea>
                                </div>

                                <!-- Muscle Group & Equipment -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Muscle Group
                                        </label>
                                        <input type="text" name="exercises[{{ $index }}][muscle_group]"
                                               value="{{ old("exercises.$index.muscle_group", $exercise->muscle_group) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                               placeholder="Chest, Back, Legs...">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Equipment
                                        </label>
                                        <input type="text" name="exercises[{{ $index }}][equipment]"
                                               value="{{ old("exercises.$index.equipment", $exercise->equipment) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                               placeholder="Dumbbell, Barbell, Bodyweight...">
                                    </div>
                                </div>

                                <!-- Sets, Reps, Rest, Duration -->
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Sets
                                        </label>
                                        <input type="number" name="exercises[{{ $index }}][sets]" min="1" max="20"
                                               value="{{ old("exercises.$index.sets", $exercise->sets) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        @error("exercises.$index.sets")
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Reps
                                        </label>
                                        <input type="text" name="exercises[{{ $index }}][reps]"
                                               value="{{ old("exercises.$index.reps", $exercise->reps) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                               placeholder="10-12 atau 30 detik">
                                        @error("exercises.$index.reps")
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Duration (min)
                                        </label>
                                        <input type="number" name="exercises[{{ $index }}][duration_minutes]" min="1" max="60"
                                               value="{{ old("exercises.$index.duration_minutes", $exercise->duration_minutes) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                               placeholder="Opsional">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium force-gray-300 mb-2">
                                            Rest (detik)
                                        </label>
                                        <input type="number" name="exercises[{{ $index }}][rest_seconds]" min="0" max="600"
                                               value="{{ old("exercises.$index.rest_seconds", $exercise->rest_seconds) }}"
                                               class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                        @error("exercises.$index.rest_seconds")
                                            <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Notes -->
                                <div class="mt-4">
                                    <label class="block text-sm font-medium force-gray-300 mb-2">
                                        Catatan Latihan
                                    </label>
                                    <textarea name="exercises[{{ $index }}][notes]" rows="2"
                                              class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                              placeholder="Tips tambahan...">{{ old("exercises.$index.notes", $exercise->notes) }}</textarea>
                                </div>

                                <!-- Order -->
                                <input type="hidden" name="exercises[{{ $index }}][order]" value="{{ $index + 1 }}">
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-16 h-16 mx-auto force-gray-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="force-gray-400 mb-4">Belum ada latihan dalam program ini</p>
                                <button type="button" onclick="addExercise()"
                                        class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500/20 to-emerald-600/20 text-green-400 border border-green-500/30 hover:bg-green-500/30 transition-colors flex items-center gap-2 mx-auto">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Tambah Latihan Pertama
                                </button>
                            </div>
                        @endforelse
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center mt-6">
                        <button type="button" onclick="addExercise()"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500/20 to-emerald-600/20 text-green-400 border border-green-500/30 hover:bg-green-500/30 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Tambah Gerakan
                        </button>
                        <button type="button" onclick="validateForm()"
                                class="px-6 py-3 rounded-xl bg-gradient-to-r from-blue-500/20 to-indigo-600/20 text-blue-400 border border-blue-500/30 hover:bg-blue-500/30 transition-colors flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Validasi Form
                        </button>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-slate-800/50 px-8 py-6 border-t force-border-slate-700">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <div class="flex gap-3">
                        <a href="{{ route('admin.workout-plans.index') }}"
                           class="px-6 py-3 rounded-xl border force-border-slate-600 force-gray-300 hover:force-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>

                        <a href="{{ route('admin.workout-plans.show', $workoutPlan) }}"
                           class="px-6 py-3 rounded-xl border force-border-slate-600 force-gray-300 hover:force-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                            Preview
                        </a>
                    </div>

                    <div class="flex gap-3">
                        <button type="button" onclick="resetForm()"
                                class="px-6 py-3 rounded-xl border force-border-slate-600 force-gray-300 hover:force-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </button>

                        <button type="submit" id="submitBtn"
                                class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        let exerciseIndex = {{ count($workoutPlan->workoutExercises) }};

        function addExercise() {
            const container = document.getElementById('exercises-list');

            // Cek jika container kosong (no exercises)
            if (container.querySelector('.text-center')) {
                container.innerHTML = '';
            }

            const html = `
                <div class="exercise-item bg-slate-800/40 p-5 rounded-xl mb-4 border force-border-slate-700 hover:border-green-500/30 transition-colors duration-300">
                    <div class="flex justify-between items-center mb-4">
                        <h5 class="text-lg font-semibold force-white">
                            <span class="inline-flex items-center justify-center w-6 h-6 bg-green-500/20 text-green-400 rounded-full text-sm mr-2">
                                ${exerciseIndex + 1}
                            </span>
                            Latihan Baru
                        </h5>
                        <button type="button" onclick="removeExercise(this)"
                                class="px-3 py-1.5 badge-red hover:bg-red-500/30 transition-colors flex items-center gap-1">
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
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                   required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Tipe</label>
                            <select name="exercises[${exerciseIndex}][type]"
                                    class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                                <option value="strength">Strength</option>
                                <option value="cardio">Cardio</option>
                                <option value="core">Core</option>
                                <option value="flexibility">Flexibility</option>
                                <option value="warmup">Warmup</option>
                                <option value="cooldown">Cooldown</option>
                            </select>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium force-gray-300 mb-2">Deskripsi Singkat</label>
                        <textarea name="exercises[${exerciseIndex}][description]" rows="2"
                                  class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                  placeholder="Deskripsi latihan..."></textarea>
                    </div>

                    <!-- Video URL -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium force-gray-300 mb-2">URL Video Demonstrasi</label>
                        <div class="flex items-center gap-2">
                            <input type="url" name="exercises[${exerciseIndex}][video_url]"
                                   class="flex-1 px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                   placeholder="https://youtube.com/watch?v=..."
                                   onchange="updateVideoPreview(this.value, ${exerciseIndex})">
                            <button type="button" onclick="previewVideo('', ${exerciseIndex})" class="px-4 py-2.5 badge-blue hover:bg-blue-500/30 transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Preview
                            </button>
                        </div>
                        <p class="text-xs force-gray-500 mt-1">Support YouTube URL</p>

                        <!-- Video Preview Area -->
                        <div id="video-preview-${exerciseIndex}" class="mt-3 hidden">
                            <div class="bg-slate-800/50 rounded-lg p-3 border force-border-slate-700">
                                <p class="text-sm force-gray-400 mb-2">Preview Video:</p>
                                <div class="aspect-video bg-slate-900 rounded flex items-center justify-center">
                                    <p class="force-gray-500">Masukkan URL video untuk preview</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium force-gray-300 mb-2">Instruksi (Opsional)</label>
                        <textarea name="exercises[${exerciseIndex}][instructions]" rows="2"
                                  class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                  placeholder="Contoh: Pastikan punggung tetap lurus..."></textarea>
                    </div>

                    <!-- Muscle Group & Equipment -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Muscle Group</label>
                            <input type="text" name="exercises[${exerciseIndex}][muscle_group]"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                   placeholder="Chest, Back, Legs...">
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Equipment</label>
                            <input type="text" name="exercises[${exerciseIndex}][equipment]"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                   placeholder="Dumbbell, Barbell, Bodyweight...">
                        </div>
                    </div>

                    <!-- Sets, Reps, Rest, Duration -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Sets</label>
                            <input type="number" name="exercises[${exerciseIndex}][sets]" min="1" max="20" value="3"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Reps</label>
                            <input type="text" name="exercises[${exerciseIndex}][reps]" value="10-12"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                   placeholder="10-12 atau 30 detik">
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Duration (min)</label>
                            <input type="number" name="exercises[${exerciseIndex}][duration_minutes]" min="1" max="60"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500"
                                   placeholder="Opsional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium force-gray-300 mb-2">Rest (detik)</label>
                            <input type="number" name="exercises[${exerciseIndex}][rest_seconds]" min="0" max="600" value="60"
                                   class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text focus:border-green-500 focus:ring-1 focus:ring-green-500">
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="mt-4">
                        <label class="block text-sm font-medium force-gray-300 mb-2">Catatan Latihan</label>
                        <textarea name="exercises[${exerciseIndex}][notes]" rows="2"
                                  class="w-full px-4 py-2.5 bg-slate-700/50 border force-border-slate-600 rounded-lg force-input-text force-input-placeholder focus:border-green-500 focus:ring-1 focus:ring-green-500 resize-none"
                                  placeholder="Tips tambahan..."></textarea>
                    </div>

                    <!-- Order -->
                    <input type="hidden" name="exercises[${exerciseIndex}][order]" value="${exerciseIndex + 1}">
                </div>
            `;

            container.insertAdjacentHTML('beforeend', html);
            exerciseIndex++;
        }

        function removeExercise(button) {
            const exerciseItem = button.closest('.exercise-item');

            // Optional: Show confirmation dialog
            if (confirm('Apakah Anda yakin ingin menghapus latihan ini?')) {
                exerciseItem.remove();

                // Update exercise numbers
                updateExerciseNumbers();
            }
        }

        function updateExerciseNumbers() {
            const exercises = document.querySelectorAll('.exercise-item');
            exercises.forEach((exercise, index) => {
                const numberSpan = exercise.querySelector('span.inline-flex');
                const title = exercise.querySelector('h5');

                if (numberSpan) {
                    numberSpan.textContent = index + 1;
                }

                if (title) {
                    // Update the title text
                    const titleText = title.textContent.replace(/Latihan\s\d+/, `Latihan ${index + 1}`);
                    title.textContent = titleText;
                }

                // Update order input if exists
                const orderInput = exercise.querySelector('input[name$="[order]"]');
                if (orderInput) {
                    orderInput.value = index + 1;
                }
            });
        }

        function previewVideo(videoUrl, index) {
            const input = document.querySelector(`input[name="exercises[${index}][video_url]"]`);
            const currentUrl = videoUrl || input.value;
            const previewDiv = document.getElementById(`video-preview-${index}`);

            if (!currentUrl) {
                alert('Masukkan URL video terlebih dahulu');
                return;
            }

            // Show preview area
            previewDiv.classList.remove('hidden');

            // Get YouTube ID
            const videoId = extractYouTubeId(currentUrl);

            if (videoId) {
                const embedUrl = `https://www.youtube.com/embed/${videoId}`;
                previewDiv.innerHTML = `
                    <div class="bg-slate-800/50 rounded-lg p-3 border force-border-slate-700">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm force-gray-400">YouTube Preview:</p>
                            <button type="button" onclick="closePreview(${index})" class="text-slate-500 hover:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
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
            } else {
                previewDiv.innerHTML = `
                    <div class="bg-slate-800/50 rounded-lg p-3 border force-border-slate-700">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-sm force-gray-400">Video Preview:</p>
                            <button type="button" onclick="closePreview(${index})" class="text-slate-500 hover:text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="aspect-video bg-slate-900 rounded flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-12 h-12 force-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="force-gray-500 text-sm">Video URL: ${currentUrl.substring(0, 50)}${currentUrl.length > 50 ? '...' : ''}</p>
                            </div>
                        </div>
                    </div>
                `;
            }
        }

        function updateVideoPreview(url, index) {
            const previewDiv = document.getElementById(`video-preview-${index}`);
            if (url && previewDiv) {
                previewVideo(url, index);
            } else if (previewDiv) {
                previewDiv.classList.add('hidden');
            }
        }

        function closePreview(index) {
            const previewDiv = document.getElementById(`video-preview-${index}`);
            if (previewDiv) {
                previewDiv.classList.add('hidden');
            }
        }

        // JavaScript version of extractYouTubeId (for client-side use)
        function extractYouTubeId(url) {
            if (!url) return null;

            // Various YouTube URL patterns
            const patterns = [
                /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i,
                /youtube\.com\/embed\/([^"&?\/\s]{11})/i,
                /youtube\.com\/v\/([^"&?\/\s]{11})/i,
                /youtube\.com\/watch\?v=([^"&?\/\s]{11})/i
            ];

            for (const pattern of patterns) {
                const match = url.match(pattern);
                if (match && match[1]) {
                    return match[1];
                }
            }

            return null;
        }

        function validateForm() {
            const form = document.getElementById('workoutPlanForm');
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            let errorMessages = [];

            // Check required fields
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500', 'ring-1', 'ring-red-500');

                    const fieldName = field.name || field.id;
                    const label = field.closest('div')?.querySelector('label')?.textContent || fieldName;
                    errorMessages.push(`"${label}" harus diisi`);
                } else {
                    field.classList.remove('border-red-500', 'ring-1', 'ring-red-500');
                }
            });

            // Check at least one exercise
            const exerciseItems = document.querySelectorAll('.exercise-item');
            if (exerciseItems.length === 0) {
                isValid = false;
                errorMessages.push("Minimal 1 latihan harus ditambahkan");
            }

            // Show validation result
            if (!isValid) {
                alert(`Ada kesalahan dalam form:\n\n${errorMessages.join('\n')}`);
                return false;
            } else {
                alert('Form valid! Siap disimpan.');
                return true;
            }
        }

        function resetForm() {
            if (confirm('Apakah Anda yakin ingin mengembalikan form ke nilai awal? Perubahan yang belum disimpan akan hilang.')) {
                document.getElementById('workoutPlanForm').reset();

                // Reload the page to reset everything properly
                window.location.reload();
            }
        }

        function showLoading() {
            document.getElementById('loadingOverlay').style.display = 'flex';
            document.getElementById('submitBtn').disabled = true;
            document.getElementById('submitBtn').innerHTML = `
                <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Menyimpan...
            `;
        }

        // Initialize form validation on submit
        document.getElementById('workoutPlanForm').addEventListener('submit', function(e) {
            if (!validateForm()) {
                e.preventDefault();
                return false;
            }

            // Jika form valid, biarkan submit terjadi
            showLoading();
            return true;
        });

        // Auto-close video preview when clicking outside
        document.addEventListener('click', function(e) {
            if (e.target.closest('#video-preview')) return;
            // Close all video previews when clicking outside
            document.querySelectorAll('[id^="video-preview-"]').forEach(preview => {
                if (!e.target.closest(`#${preview.id}`) && !e.target.closest('input[type="url"]')) {
                    preview.classList.add('hidden');
                }
            });
        });

        // Helper function to format exercise data for debugging
        function debugExerciseData() {
            const exercises = [];
            document.querySelectorAll('.exercise-item').forEach((item, index) => {
                const inputs = item.querySelectorAll('input, select, textarea');
                const exercise = {};

                inputs.forEach(input => {
                    const name = input.name.replace(/exercises\[\d+\]\[/, '').replace(']', '');
                    exercise[name] = input.value;
                });

                exercises.push(exercise);
            });

            console.log('Exercises Data:', exercises);
            return exercises;
        }
    </script>

</x-layouts.admin>
