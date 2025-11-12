@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-2xl p-6 max-w-xl mx-auto">
        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            🕒 Atur <span class="text-amber-400">Jadwal Workout</span>
        </h2>

        {{-- Timer Section --}}
        <div id="liveTimer"
            class="hidden mb-6 p-4 bg-gradient-to-r from-purple-600/30 to-blue-600/30 border border-purple-500/50 rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                        ⚡ Sedang Berlangsung
                    </h3>
                    <p class="text-gray-300 text-sm" id="currentWorkoutTitle"></p>
                </div>
                <div class="text-right">
                    <div id="timerDisplay" class="text-2xl font-mono font-bold text-green-400">00:00:00</div>
                    <div class="text-xs text-gray-400 mt-1" id="timerStatus">Workout dimulai</div>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button id="pauseTimer"
                    class="px-3 py-1 bg-yellow-500 hover:bg-yellow-400 text-black text-sm rounded-lg transition-all">
                    ⏸️ Jeda
                </button>
                <button id="resumeTimer"
                    class="px-3 py-1 bg-blue-500 hover:bg-blue-400 text-white text-sm rounded-lg transition-all hidden">
                    ▶️ Lanjutkan
                </button>
                <button id="stopTimer"
                    class="px-3 py-1 bg-red-500 hover:bg-red-400 text-white text-sm rounded-lg transition-all">
                    ⏹️ Selesai
                </button>
            </div>
        </div>

        <form action="{{ route('user.workouts.store') }}" method="POST" class="space-y-5" id="workoutForm">
            @csrf

            {{-- 🏋️ Pilih Workout --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">🏋️ Pilih Workout</label>
                <select name="workout_id" id="workoutSelect" required
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white text-sm px-3 py-2
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 transition-all duration-150">
                    <option value="">-- Pilih Workout --</option>

                    @forelse($workouts as $w)
                        @php
                            $labelSumber = 'Admin / Sistem';
                            if ($w->recommended_by === 'trainer' && $w->trainer_id) {
                                $trainerName = $w->trainer->name ?? 'Trainer Tidak Dikenal';
                                $labelSumber = 'Trainer: ' . $trainerName;
                            }
                        @endphp

                        <option value="{{ $w->id }}" data-duration="{{ $w->duration_minutes ?? 30 }}"
                            data-title="{{ $w->title }}" data-difficulty="{{ $w->difficulty_level ?? 'Beginner' }}"
                            {{ old('workout_id', $selectedWorkout->id ?? '') == $w->id ? 'selected' : '' }}>
                            {{ $w->title }}
                            ({{ ucfirst($w->difficulty_level ?? 'Beginner') }} • {{ $labelSumber }})
                        </option>
                    @empty
                        <option disabled>⚠️ Belum ada workout tersedia dari trainer atau admin.</option>
                    @endforelse
                </select>
                @error('workout_id')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 📅 Tanggal Latihan --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">📅 Tanggal Latihan</label>
                <input type="date" name="scheduled_date" id="scheduledDate" value="{{ old('scheduled_date') }}"
                    min="{{ now()->format('Y-m-d') }}"
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white px-3 py-2
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 transition-all duration-150" required>
                @error('scheduled_date')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ⏰ Waktu Latihan --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">⏰ Waktu Mulai Latihan</label>
                <input type="time" id="startTime" name="scheduled_time" value="{{ old('scheduled_time') }}"
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white px-3 py-2
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 transition-all duration-150" required>
                @error('scheduled_time')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror

                {{-- 💡 Estimasi waktu selesai --}}
                <p id="endTimeDisplay" class="text-xs text-gray-400 mt-2 hidden">
                    ⏳ Perkiraan selesai: <span class="text-amber-300 font-semibold" id="endTimeText"></span>
                </p>
            </div>

            {{-- 📝 Catatan Opsional --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">📝 Catatan (opsional)</label>
                <textarea name="notes" id="workoutNotes" rows="2"
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white text-sm px-3 py-2
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 placeholder-gray-500 transition-all duration-150"
                    placeholder="Contoh: fokus pada form squat...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 🔘 Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 pt-3">
                <a href="{{ route('user.workouts.index') }}"
                    class="w-full sm:w-auto px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all duration-150 text-center">
                    ⬅️ Kembali
                </a>

                <div class="flex gap-2 w-full sm:w-auto">
                    <button type="button" id="startNowBtn"
                        class="flex-1 px-4 py-2.5 rounded-md text-sm font-bold text-white bg-green-600 hover:bg-green-500 active:bg-green-700
                                   transition-all duration-150 shadow-lg shadow-green-500/20 flex items-center justify-center gap-2">
                        ⚡ Mulai Sekarang
                    </button>

                    <button type="submit" class="flex-1 px-4 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 active:bg-amber-500
                                   transition-all duration-150 shadow-lg shadow-amber-500/20">
                        💾 Simpan Jadwal
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- 🔢 Script Timer dan Waktu --}}
    <script>
        // Elements
        const workoutSelect = document.getElementById('workoutSelect');
        const startTimeInput = document.getElementById('startTime');
        const scheduledDateInput = document.getElementById('scheduledDate');
        const workoutNotes = document.getElementById('workoutNotes');
        const endTimeDisplay = document.getElementById('endTimeDisplay');
        const endTimeText = document.getElementById('endTimeText');
        const startNowBtn = document.getElementById('startNowBtn');
        const liveTimer = document.getElementById('liveTimer');
        const timerDisplay = document.getElementById('timerDisplay');
        const timerStatus = document.getElementById('timerStatus');
        const currentWorkoutTitle = document.getElementById('currentWorkoutTitle');
        const pauseTimerBtn = document.getElementById('pauseTimer');
        const resumeTimerBtn = document.getElementById('resumeTimer');
        const stopTimerBtn = document.getElementById('stopTimer');

        // Timer variables
        let timerInterval = null;
        let timerSeconds = 0;
        let isTimerRunning = false;
        let isTimerPaused = false;

        // Set current date and time as default
        function setCurrentDateTime() {
            const now = new Date();
            const dateString = now.toISOString().split('T')[0];
            const timeString = now.toTimeString().split(' ')[0].substring(0, 5);

            scheduledDateInput.value = dateString;
            startTimeInput.value = timeString;

            updateEndTime();
        }

        // Initialize with current time
        setCurrentDateTime();

        // Update end time calculation
        function updateEndTime() {
            const selectedOption = workoutSelect.options[workoutSelect.selectedIndex];
            const selectedDuration = parseInt(selectedOption?.dataset.duration || 0);

            if (!selectedDuration || !startTimeInput.value) {
                endTimeDisplay.classList.add('hidden');
                return;
            }

            const [hours, minutes] = startTimeInput.value.split(':').map(Number);
            const startDate = new Date();
            startDate.setHours(hours);
            startDate.setMinutes(minutes);

            const endDate = new Date(startDate.getTime() + selectedDuration * 60000);
            const endHours = String(endDate.getHours()).padStart(2, '0');
            const endMinutes = String(endDate.getMinutes()).padStart(2, '0');

            endTimeText.textContent = `${endHours}:${endMinutes} (${selectedDuration} menit)`;
            endTimeDisplay.classList.remove('hidden');
        }

        // Timer functions
        function startTimer() {
            if (isTimerRunning) return;

            const selectedOption = workoutSelect.options[workoutSelect.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                alert('Pilih workout terlebih dahulu!');
                return;
            }

            const workoutTitle = selectedOption.dataset.title;
            const workoutDifficulty = selectedOption.dataset.difficulty;

            // Show live timer
            currentWorkoutTitle.textContent = `${workoutTitle} (${workoutDifficulty})`;
            liveTimer.classList.remove('hidden');

            // Start timer
            isTimerRunning = true;
            isTimerPaused = false;
            timerSeconds = 0;

            timerInterval = setInterval(() => {
                if (!isTimerPaused) {
                    timerSeconds++;
                    updateTimerDisplay();
                }
            }, 1000);

            updateTimerButtons();
        }

        function pauseTimer() {
            isTimerPaused = true;
            timerStatus.textContent = 'Dijeda';
            updateTimerButtons();
        }

        function resumeTimer() {
            isTimerPaused = false;
            timerStatus.textContent = 'Berjalan';
            updateTimerButtons();
        }

        function stopTimer() {
            if (confirm('Apakah Anda yakin ingin menghentikan workout?')) {
                clearInterval(timerInterval);
                isTimerRunning = false;
                isTimerPaused = false;

                // Calculate calories burned (simple estimation)
                const minutes = Math.floor(timerSeconds / 60);
                const calories = Math.round(minutes * 8); // ~8 calories per minute for moderate exercise

                // Show summary
                timerDisplay.textContent = `Selesai!`;
                timerStatus.textContent = `Durasi: ${formatTime(timerSeconds)} • Perkiraan kalori terbakar: ${calories} kal`;

                // Hide controls
                pauseTimerBtn.classList.add('hidden');
                resumeTimerBtn.classList.add('hidden');
                stopTimerBtn.textContent = '✓ Selesai';
                stopTimerBtn.classList.add('bg-green-600', 'hover:bg-green-500');
                stopTimerBtn.classList.remove('bg-red-500', 'hover:bg-red-400');

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    liveTimer.classList.add('hidden');
                }, 5000);
            }
        }

        function updateTimerDisplay() {
            timerDisplay.textContent = formatTime(timerSeconds);
        }

        function formatTime(seconds) {
            const hrs = Math.floor(seconds / 3600);
            const mins = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }

        function updateTimerButtons() {
            if (isTimerPaused) {
                pauseTimerBtn.classList.add('hidden');
                resumeTimerBtn.classList.remove('hidden');
            } else {
                pauseTimerBtn.classList.remove('hidden');
                resumeTimerBtn.classList.add('hidden');
            }
        }

        // Event listeners
        workoutSelect.addEventListener('change', updateEndTime);
        startTimeInput.addEventListener('input', updateEndTime);

        startNowBtn.addEventListener('click', function () {
            setCurrentDateTime();

            // Auto-add note if empty
            if (!workoutNotes.value.trim()) {
                const selectedOption = workoutSelect.options[workoutSelect.selectedIndex];
                if (selectedOption && selectedOption.value) {
                    workoutNotes.value = `Workout dimulai sekarang - ${selectedOption.textContent.split('(')[0].trim()}`;
                }
            }

            // Start timer immediately
            startTimer();
        });

        pauseTimerBtn.addEventListener('click', pauseTimer);
        resumeTimerBtn.addEventListener('click', resumeTimer);
        stopTimerBtn.addEventListener('click', stopTimer);

        // Auto-update end time when page loads
        document.addEventListener('DOMContentLoaded', function () {
            updateEndTime();
        });
    </script>

    <style>
        #liveTimer {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(147, 51, 234, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(147, 51, 234, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(147, 51, 234, 0);
            }
        }

        #timerDisplay {
            text-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
        }
    </style>
@endsection