<x-layouts.admin>
    <x-slot name="title">
        Detail Program <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">{{ $workoutPlan->title }}</span>
    </x-slot>

    <style>
        /* Custom styles */
        .gradient-text {
            background: linear-gradient(to right, #10b981, #059669) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            background-clip: text !important;
        }

        .badge-blue {
            background: rgba(59, 130, 246, 0.2) !important;
            border: 1px solid rgba(59, 130, 246, 0.3) !important;
            color: #60a5fa !important;
        }
        .badge-green {
            background: rgba(5, 150, 105, 0.2) !important;
            border: 1px solid rgba(5, 150, 105, 0.3) !important;
            color: #34d399 !important;
        }
        .badge-yellow {
            background: rgba(245, 158, 11, 0.2) !important;
            border: 1px solid rgba(245, 158, 11, 0.3) !important;
            color: #fbbf24 !important;
        }
        .badge-red {
            background: rgba(239, 68, 68, 0.2) !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
            color: #f87171 !important;
        }
        .badge-purple {
            background: rgba(168, 85, 247, 0.2) !important;
            border: 1px solid rgba(168, 85, 247, 0.3) !important;
            color: #c084fc !important;
        }

        /* Glass effect */
        .glass-card {
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(51, 65, 85, 0.5);
        }

        /* Exercise item styling */
        .exercise-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent;
        }
        .exercise-item:hover {
            border-left-color: #10b981;
            background: rgba(16, 185, 129, 0.05);
        }
    </style>

    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('admin.workout-plans.index') }}" class="ml-1 text-sm font-medium text-gray-400 hover:text-white md:ml-2">
                            Program Latihan
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-white md:ml-2">
                            {{ $workoutPlan->title }}
                        </span>
                    </div>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Header Section -->
    <div class="glass-card rounded-2xl shadow-2xl overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-700">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div class="flex-1">
                    <div class="flex items-center gap-3 mb-2">
                        <h1 class="text-3xl font-bold text-white">
                            {{ $workoutPlan->title }}
                        </h1>
                        @if($workoutPlan->status == 'active')
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-red">
                                Inactive
                            </span>
                        @endif
                    </div>
                    <p class="text-slate-300 mb-4">{{ $workoutPlan->description }}</p>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.workout-plans.edit', $workoutPlan) }}"
                           class="px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Program
                        </a>

                        <a href="{{ route('admin.workout-plans.index') }}"
                           class="px-4 py-2 rounded-lg bg-slate-700 text-slate-300 font-semibold hover:bg-slate-600 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali
                        </a>

                        <form action="{{ route('admin.workout-plans.destroy', $workoutPlan) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus program \"{{ $workoutPlan->title }}\"?')"
                                    class="px-4 py-2 rounded-lg bg-red-500/20 text-red-400 font-semibold hover:bg-red-500/30 border border-red-500/30 transition-all duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus Program
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 min-w-[200px]">
                    <div class="text-sm text-slate-400 mb-2">Program Statistics</div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Total Latihan</span>
                            <span class="text-white font-bold">{{ $workoutPlan->exercises->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Durasi</span>
                            <span class="text-white font-bold">{{ $workoutPlan->duration_weeks ?? '-' }} Minggu</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Dibuat</span>
                            <span class="text-white">{{ $workoutPlan->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Program Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Program Information Card -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Informasi Program
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Target Fitness -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Target Fitness</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-white capitalize">{{ $workoutPlan->target_fitness ?? 'General Fitness' }}</span>
                        </div>
                    </div>

                    <!-- Focus Area -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Fokus Area</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                            </svg>
                            <span class="text-white capitalize">{{ $workoutPlan->focus_area ?? 'Full Body' }}</span>
                        </div>
                    </div>

                    <!-- Difficulty Level -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Level Kesulitan</label>
                        <div class="flex items-center gap-2">
                            @if($workoutPlan->difficulty_level == 'beginner')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                    Beginner
                                </span>
                            @elseif($workoutPlan->difficulty_level == 'intermediate')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-yellow">
                                    Intermediate
                                </span>
                            @elseif($workoutPlan->difficulty_level == 'advanced')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-red">
                                    Advanced
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-purple">
                                    {{ $workoutPlan->difficulty_level ?? 'All Levels' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Duration -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Durasi Program</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-white">{{ $workoutPlan->duration_weeks ?? '4' }} Minggu</span>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Jadwal per Minggu</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-white">{{ $workoutPlan->sessions_per_week ?? '3' }} Sesi/Minggu</span>
                        </div>
                    </div>

                    <!-- Equipment -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Peralatan</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-white">{{ $workoutPlan->equipment_needed ?? 'Bodyweight' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detailed Description -->
                @if($workoutPlan->detailed_description)
                <div class="mt-6 pt-6 border-t border-slate-700">
                    <label class="text-sm text-slate-400 mb-2 block">Deskripsi Detail</label>
                    <div class="prose prose-invert max-w-none">
                        <p class="text-slate-300 whitespace-pre-line">{{ $workoutPlan->detailed_description }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Exercises List -->
            <div class="glass-card rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        Daftar Latihan
                        <span class="bg-green-500/20 text-green-400 text-sm px-2 py-1 rounded-full">
                            {{ $workoutPlan->exercises->count() }} Latihan
                        </span>
                    </h3>

                    <!-- Add Exercise Button -->
                    <button onclick="showAddExerciseModal()"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Latihan
                    </button>
                </div>

                @if($workoutPlan->exercises->count() > 0)
                <div class="space-y-3">
                    @foreach($workoutPlan->exercises as $exercise)
                    <div class="exercise-item bg-slate-800/50 border border-slate-700 rounded-lg p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="flex items-start gap-3">
                                    <!-- Exercise Number -->
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                        <span class="text-green-400 font-bold">{{ $loop->iteration }}</span>
                                    </div>

                                    <!-- Exercise Details -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            <h4 class="text-lg font-semibold text-white">{{ $exercise->name }}</h4>
                                            @if($exercise->sets && $exercise->reps)
                                            <span class="text-sm text-slate-400">
                                                {{ $exercise->sets }} set × {{ $exercise->reps }} reps
                                            </span>
                                            @endif
                                        </div>

                                        @if($exercise->description)
                                        <p class="text-slate-300 text-sm mb-2">{{ $exercise->description }}</p>
                                        @endif

                                        <!-- Exercise Metadata -->
                                        <div class="flex flex-wrap gap-2 mt-2">
                                            @if($exercise->duration_minutes)
                                            <span class="text-xs px-2 py-1 bg-blue-500/20 text-blue-400 rounded">
                                                {{ $exercise->duration_minutes }} menit
                                            </span>
                                            @endif

                                            @if($exercise->rest_seconds)
                                            <span class="text-xs px-2 py-1 bg-purple-500/20 text-purple-400 rounded">
                                                Istirahat: {{ $exercise->rest_seconds }} detik
                                            </span>
                                            @endif

                                            @if($exercise->equipment)
                                            <span class="text-xs px-2 py-1 bg-yellow-500/20 text-yellow-400 rounded">
                                                {{ $exercise->equipment }}
                                            </span>
                                            @endif

                                            @if($exercise->muscle_group)
                                            <span class="text-xs px-2 py-1 bg-red-500/20 text-red-400 rounded">
                                                {{ $exercise->muscle_group }}
                                            </span>
                                            @endif
                                        </div>

                                        <!-- Notes -->
                                        @if($exercise->notes)
                                        <div class="mt-2 p-2 bg-slate-700/50 rounded">
                                            <p class="text-xs text-slate-300 italic">"{{ $exercise->notes }}"</p>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Exercise Actions -->
                            <div class="flex items-center gap-2 ml-4">
                                <button onclick="showEditExerciseModal({{ $exercise->id }})"
                                        class="p-2 text-green-400 hover:bg-green-500/20 rounded-lg transition-colors"
                                        title="Edit Latihan">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>

                                <form action="{{ route('admin.workout-plans.exercises.destroy', [$workoutPlan, $exercise]) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus latihan \"{{ $exercise->name }}\"?')"
                                            class="p-2 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors"
                                            title="Hapus Latihan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h4 class="text-lg font-semibold text-slate-300 mb-2">Belum ada latihan</h4>
                    <p class="text-slate-500 mb-6">Tambahkan latihan pertama untuk program ini</p>
                    <button onclick="showAddExerciseModal()"
                            class="px-6 py-3 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 mx-auto">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Latihan Pertama
                    </button>
                </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Additional Info -->
        <div class="space-y-6">
            <!-- Preview Card -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Preview Program
                </h3>

                <div class="aspect-video bg-slate-800 rounded-lg mb-4 flex items-center justify-center">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto text-slate-600 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-slate-400">Preview Program</p>
                    </div>
                </div>

                <button class="w-full px-4 py-3 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    Preview sebagai User
                </button>
            </div>

            <!-- Sharing Card -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">Bagikan Program</h3>

                <div class="space-y-3">
                    <!-- Copy Link -->
                    <div class="flex items-center gap-2">
                        <div class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                            <p class="text-sm text-slate-300 truncate" id="shareLink">
                                {{ route('workout-plans.show', $workoutPlan) }}
                            </p>
                        </div>
                        <button onclick="copyShareLink()"
                                class="px-4 py-2 bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/30 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"/>
                            </svg>
                            Copy
                        </button>
                    </div>

                    <!-- Social Share -->
                    <div class="flex gap-2 pt-2">
                        <a href="https://wa.me/?text={{ urlencode('Check out this workout plan: ' . route('workout-plans.show', $workoutPlan)) }}"
                           target="_blank"
                           class="flex-1 px-3 py-2 bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/30 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.76.982.998-3.675-.236-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.9 6.994c-.004 5.45-4.438 9.88-9.888 9.88m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.333.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.333 11.893-11.893 0-3.18-1.24-6.162-3.495-8.411"/>
                            </svg>
                        </a>

                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('workout-plans.show', $workoutPlan)) }}"
                           target="_blank"
                           class="flex-1 px-3 py-2 bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 border border-blue-500/30 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">Aktivitas Terkini</h3>

                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-green-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Program dibuat</p>
                            <p class="text-xs text-slate-400">{{ $workoutPlan->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">Terakhir diperbarui</p>
                            <p class="text-xs text-slate-400">{{ $workoutPlan->updated_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-purple-500/20 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">{{ $workoutPlan->exercises->count() }} latihan ditambahkan</p>
                            <p class="text-xs text-slate-400">Total latihan dalam program</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Exercise Modal (Skeleton - perlu implementasi JS) -->
    <div id="exerciseModal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
        <div class="bg-slate-800 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <!-- Modal content akan diisi via JavaScript -->
        </div>
    </div>

    <script>
        function copyShareLink() {
            const shareLink = document.getElementById('shareLink').textContent;
            navigator.clipboard.writeText(shareLink).then(() => {
                alert('Link berhasil disalin ke clipboard!');
            });
        }

        function showAddExerciseModal() {
            // Implementasi modal untuk menambah latihan
            alert('Fitur tambah latihan akan diimplementasikan dengan modal/form');
            // Bisa menggunakan Alpine.js atau modal biasa
        }

        function showEditExerciseModal(exerciseId) {
            // Implementasi modal untuk edit latihan
            alert('Fitur edit latihan untuk ID: ' + exerciseId);
        }
    </script>

</x-layouts.admin>
