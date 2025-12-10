<div class="exercise-item bg-slate-800/50 border border-slate-700 rounded-lg p-4" data-exercise-id="{{ $exercise->id }}">
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
            <button onclick="showEditExerciseModal({{ $exercise->id }})" class="p-2 text-green-400 hover:bg-green-500/20 rounded-lg transition-colors" title="Edit Latihan">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
            </button>

            <button onclick="deleteExercise({{ $exercise->id }}, '{{ addslashes($exercise->name) }}')" class="p-2 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors" title="Hapus Latihan">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
            </button>
        </div>
    </div>
</div>