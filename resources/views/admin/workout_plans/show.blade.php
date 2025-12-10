<x-layouts.admin>
    <x-slot name="title">
        Detail Program <span
            class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">{{ $workoutPlan->title }}</span>
    </x-slot>

    @push('styles')
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

            .sortable-ghost {
                opacity: 0.4;
                background: rgba(59, 130, 246, 0.1);
            }

            .sortable-chosen {
                background: rgba(59, 130, 246, 0.2);
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
        <script>
            function copyShareLink() {
                const shareLink = document.getElementById('shareLink').textContent;
                navigator.clipboard.writeText(shareLink).then(() => {
                    showToast('success', 'Link berhasil disalin ke clipboard!');
                });
            }

            function showToast(type, message) {
                const toast = document.createElement('div');
                toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
                toast.textContent = message;
                document.body.appendChild(toast);

                setTimeout(() => {
                    toast.remove();
                }, 3000);
            }

            // Modal functions
            function showAddExerciseModal() {
                const url = `{{ route('admin.workout-plans.exercises.create', $workoutPlan) }}`;

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('exerciseModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Gagal memuat form tambah latihan');
                    });
            }

            function showEditExerciseModal(exerciseId) {
                // Gunakan URL yang benar dengan exercise ID
                const url = `{{ route('admin.workout-plans.exercises.edit', [$workoutPlan, 'exercise_id']) }}`
                    .replace('exercise_id', exerciseId);

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.text();
                    })
                    .then(html => {
                        document.getElementById('modalContent').innerHTML = html;
                        document.getElementById('exerciseModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('error', 'Gagal memuat form edit');
                    });
            }

            function closeModal() {
                document.getElementById('exerciseModal').classList.add('hidden');
                document.getElementById('modalContent').innerHTML = '';
            }

            // Close modal on ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });

            // Close modal on background click
            document.getElementById('exerciseModal')?.addEventListener('click', (e) => {
                if (e.target.id === 'exerciseModal') closeModal();
            });

            // Initialize Sortable
            document.addEventListener('DOMContentLoaded', function () {
                const exerciseList = document.getElementById('exerciseList');
                if (exerciseList) {
                    new Sortable(exerciseList, {
                        animation: 150,
                        ghostClass: 'sortable-ghost',
                        chosenClass: 'sortable-chosen',
                        onEnd: function (evt) {
                            const order = Array.from(exerciseList.children).map(child => child.dataset.exerciseId);

                            fetch(`{{ route('admin.workout-plans.exercises.order.update', $workoutPlan) }}`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ order: order })
                            }).then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        // Update exercise numbers
                                        updateExerciseNumbers();
                                    }
                                });
                        }
                    });
                }
            });

            function updateExerciseNumbers() {
                const exercises = document.querySelectorAll('.exercise-item');
                exercises.forEach((exercise, index) => {
                    const numberElement = exercise.querySelector('.exercise-number');
                    if (numberElement) {
                        numberElement.textContent = index + 1;
                    }
                });
            }

            // Toggle status
            function togglePlanStatus() {
                if (confirm('Apakah Anda yakin ingin mengubah status program?')) {
                    fetch(`{{ route('admin.workout-plans.toggle-status', $workoutPlan) }}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('success', data.message);
                                // Update status badge
                                document.getElementById('statusBadge').outerHTML = data.status_badge;
                            }
                        });
                }
            }

            // Toggle premium
            function togglePremiumStatus() {
                fetch(`{{ route('admin.workout-plans.toggle-premium', $workoutPlan) }}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('success', data.message);
                            // Update premium badge if exists
                            const premiumBadge = document.getElementById('premiumBadge');
                            if (premiumBadge) {
                                premiumBadge.outerHTML = data.premium_badge;
                            }
                        }
                    });
            }

            // Delete exercise
            function deleteExercise(exerciseId, exerciseName) {
                if (confirm(`Yakin ingin menghapus latihan "${exerciseName}"?`)) {
                    // Gunakan URL yang benar dengan exercise ID
                    const url = `{{ route('admin.workout-plans.exercises.destroy', [$workoutPlan, 'exercise_id']) }}`
                        .replace('exercise_id', exerciseId);

                    fetch(url, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('success', data.message);
                                const exerciseElement = document.querySelector(`[data-exercise-id="${exerciseId}"]`);
                                if (exerciseElement) {
                                    exerciseElement.remove();
                                    updateExerciseNumbers();
                                }
                            }
                        });
                }
            }
        </script>
    @endpush

    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center text-sm font-medium text-gray-400 hover:text-white">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                            </path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <a href="{{ route('admin.workout-plans.index') }}"
                            class="ml-1 text-sm font-medium text-gray-400 hover:text-white md:ml-2">
                            Program Latihan
                        </a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"></path>
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
                        <div class="flex items-center gap-2">
                            @if($workoutPlan->status == 'active')
                                <span id="statusBadge"
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                    Active
                                </span>
                            @else
                                <span id="statusBadge"
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-red">
                                    Inactive
                                </span>
                            @endif

                            @if($workoutPlan->is_premium)
                                <span id="premiumBadge"
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-yellow">
                                    ⭐ Premium
                                </span>
                            @else
                                <span id="premiumBadge"
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-blue">
                                    📋 Standard
                                </span>
                            @endif
                        </div>
                    </div>
                    <p class="text-slate-300 mb-4">{{ $workoutPlan->description }}</p>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('admin.workout-plans.edit', $workoutPlan) }}"
                            class="px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit Program
                        </a>

                        <a href="{{ route('admin.workout-plans.index') }}"
                            class="px-4 py-2 rounded-lg bg-slate-700 text-slate-300 font-semibold hover:bg-slate-600 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>

                        <button onclick="togglePlanStatus()"
                            class="px-4 py-2 rounded-lg bg-blue-500/20 text-blue-400 font-semibold hover:bg-blue-500/30 border border-blue-500/30 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                            </svg>
                            Ubah Status
                        </button>

                        <button onclick="togglePremiumStatus()"
                            class="px-4 py-2 rounded-lg bg-yellow-500/20 text-yellow-400 font-semibold hover:bg-yellow-500/30 border border-yellow-500/30 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                            {{ $workoutPlan->is_premium ? 'Jadikan Standard' : 'Jadikan Premium' }}
                        </button>

                        <form action="{{ route('admin.workout-plans.destroy', $workoutPlan) }}" method="POST"
                            class="inline" id="deleteForm">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete()"
                                class="px-4 py-2 rounded-lg bg-red-500/20 text-red-400 font-semibold hover:bg-red-500/30 border border-red-500/30 transition-all duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Hapus Program
                            </button>
                        </form>

                        <script>
                            function confirmDelete() {
                                if (confirm('Yakin ingin menghapus program "{{ $workoutPlan->title }}"? Tindakan ini tidak dapat dibatalkan.')) {
                                    document.getElementById('deleteForm').submit();
                                }
                            }
                        </script>
                    </div>
                </div>

                <!-- Stats Card -->
                <div class="bg-slate-800/50 border border-slate-700 rounded-xl p-4 min-w-[200px]">
                    <div class="text-sm text-slate-400 mb-2">Program Statistics</div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Total Latihan</span>
                            <span class="text-white font-bold">{{ $workoutPlan->total_exercises }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Durasi</span>
                            <span class="text-white font-bold">{{ $workoutPlan->duration_weeks ?? '-' }} Minggu</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-slate-300">Sesi/Minggu</span>
                            <span class="text-white">{{ $workoutPlan->sessions_per_week ?? '3' }}</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi Program
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Target Fitness -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Target Fitness</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white capitalize">
                                @if($workoutPlan->target_fitness)
                                    {{ str_replace('_', ' ', $workoutPlan->target_fitness) }}
                                @else
                                    General Fitness
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Focus Area -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Fokus Area</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                            <span class="text-white capitalize">
                                @if($workoutPlan->focus_area)
                                    {{ str_replace('_', ' ', $workoutPlan->focus_area) }}
                                @else
                                    Full Body
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Difficulty Level -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Level Kesulitan</label>
                        <div class="flex items-center gap-2">
                            @if($workoutPlan->difficulty_level == 'beginner')
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-green">
                                    Beginner
                                </span>
                            @elseif($workoutPlan->difficulty_level == 'intermediate')
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-yellow">
                                    Intermediate
                                </span>
                            @elseif($workoutPlan->difficulty_level == 'advanced')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-red">
                                    Advanced
                                </span>
                            @else
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full badge-purple">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-white">{{ $workoutPlan->duration_weeks ?? '4' }} Minggu</span>
                        </div>
                    </div>

                    <!-- Schedule -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Jadwal per Minggu</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white">{{ $workoutPlan->sessions_per_week ?? '3' }} Sesi/Minggu</span>
                        </div>
                    </div>

                    <!-- Equipment -->
                    <div class="space-y-2">
                        <label class="text-sm text-slate-400">Peralatan</label>
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
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

                <!-- Notes -->
                @if($workoutPlan->notes)
                    <div class="mt-4 pt-4 border-t border-slate-700">
                        <label class="text-sm text-slate-400 mb-2 block">Catatan</label>
                        <div class="p-3 bg-slate-800/50 rounded-lg">
                            <p class="text-slate-300">{{ $workoutPlan->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Exercises List -->
            <div class="glass-card rounded-xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Daftar Latihan
                        <span class="bg-green-500/20 text-green-400 text-sm px-2 py-1 rounded-full">
                            {{ $workoutPlan->total_exercises }} Latihan
                        </span>
                    </h3>

                    <!-- Add Exercise Button -->
                    <button onclick="showAddExerciseModal()"
                        class="px-4 py-2 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Latihan
                    </button>
                </div>

                @if($workoutPlan->workoutExercises->count() > 0)
                    <div id="exerciseList" class="space-y-3">
                        @foreach($workoutPlan->workoutExercises as $exercise)
                            <div class="exercise-item bg-slate-800/50 border border-slate-700 rounded-lg p-4 cursor-move"
                                data-exercise-id="{{ $exercise->id }}">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-start gap-3">
                                            <!-- Exercise Number -->
                                            <div
                                                class="flex-shrink-0 w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-green-400 font-bold exercise-number">{{ $loop->iteration }}</span>
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
                                                    @if($exercise->type)
                                                        <span
                                                            class="text-xs px-2 py-1 bg-purple-500/20 text-purple-400 rounded capitalize">
                                                            {{ $exercise->type }}
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

                                                <!-- Instructions -->
                                                @if($exercise->instructions)
                                                    <div class="mt-2 p-2 bg-slate-700/50 rounded">
                                                        <p class="text-xs text-slate-300">{{ $exercise->instructions }}</p>
                                                    </div>
                                                @endif

                                                <!-- Notes -->
                                                @if($exercise->notes)
                                                    <div class="mt-2 p-2 bg-slate-700/50 rounded">
                                                        <p class="text-xs text-slate-300 italic">"{{ $exercise->notes }}"</p>
                                                    </div>
                                                @endif

                                                <!-- Video -->
                                                @if($exercise->video_url)
                                                    <div class="mt-2">
                                                        <a href="{{ $exercise->video_url }}" target="_blank"
                                                            class="text-xs text-blue-400 hover:text-blue-300 flex items-center gap-1">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                            Tonton Video Demo
                                                        </a>
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
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <button
                                            onclick="deleteExercise({{ $exercise->id }}, '{{ addslashes($exercise->name) }}')"
                                            class="p-2 text-red-400 hover:bg-red-500/20 rounded-lg transition-colors"
                                            title="Hapus Latihan">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-slate-600 mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h4 class="text-lg font-semibold text-slate-300 mb-2">Belum ada latihan</h4>
                        <p class="text-slate-500 mb-6">Tambahkan latihan pertama untuk program ini</p>
                        <button onclick="showAddExerciseModal()"
                            class="px-6 py-3 rounded-lg bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2 mx-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Latihan Pertama
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Column: Additional Info -->
        <div class="space-y-6">
            <!-- Cover Image Card -->
            @if($workoutPlan->cover_image)
                <div class="glass-card rounded-xl p-6">
                    <h3 class="text-xl font-bold text-white mb-4">Cover Image</h3>
                    <div class="aspect-video bg-slate-800 rounded-lg overflow-hidden">
                        <img src="{{ $workoutPlan->cover_image_url }}" alt="{{ $workoutPlan->title }}"
                            class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            <!-- Preview Card -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Preview Program
                </h3>

                <a href="{{ route('admin.workout-plans.preview', $workoutPlan) }}" target="_blank"
                    class="w-full block aspect-video bg-slate-800 rounded-lg mb-4 flex items-center justify-center hover:bg-slate-700 transition-colors">
                    <div class="text-center">
                        <svg class="w-16 h-16 mx-auto text-slate-600 mb-2" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <p class="text-slate-400">Preview sebagai User</p>
                    </div>
                </a>

                <button onclick="window.open('{{ route('admin.workout-plans.preview', $workoutPlan) }}', '_blank')"
                    class="w-full px-4 py-3 rounded-lg bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-semibold hover:shadow-blue-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Preview Program
                </button>
            </div>

            <!-- Quick Actions -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">Quick Actions</h3>
                <div class="space-y-3">
                    <form action="{{ route('admin.workout-plans.duplicate', $workoutPlan) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full px-4 py-2 rounded-lg bg-slate-700 text-slate-300 hover:bg-slate-600 transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2" />
                            </svg>
                            Duplicate Program
                        </button>
                    </form>

                    <a href="{{ route('admin.workout-plans.export') }}"
                        class="block w-full px-4 py-2 rounded-lg bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/30 transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export ke Excel
                    </a>
                </div>
            </div>

            <!-- Sharing Card -->
            <div class="glass-card rounded-xl p-6">
                <h3 class="text-xl font-bold text-white mb-4">Bagikan Program</h3>

                <div class="space-y-3">
                    <!-- Copy Link -->
                    <div class="flex items-center gap-2">
                        <div class="flex-1 bg-slate-800 border border-slate-700 rounded-lg px-3 py-2">
                            <p class="text-sm text-slate-300 truncate" id="shareLink">
                                {{ route('admin.workout-plans.show', $workoutPlan) }}
                            </p>
                        </div>
                        <button onclick="copyShareLink()"
                            class="px-4 py-2 bg-green-500/20 text-green-400 hover:bg-green-500/30 border border-green-500/30 rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                            </svg>
                            Copy
                        </button>
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-white">{{ $workoutPlan->total_exercises }} latihan ditambahkan</p>
                            <p class="text-xs text-slate-400">Total latihan dalam program</p>
                        </div>
                    </div>

                    @if($workoutPlan->creator)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 bg-yellow-500/20 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-white">Dibuat oleh</p>
                                <p class="text-xs text-slate-400">{{ $workoutPlan->creator->name }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Exercise Modal -->
    <div id="exerciseModal" class="hidden fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4">
        <div class="bg-slate-800 rounded-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
            <div id="modalContent"></div>
        </div>
    </div>

</x-layouts.admin>