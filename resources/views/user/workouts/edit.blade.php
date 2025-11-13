@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            ✏️ Edit <span class="text-amber-400">Jadwal Workout</span>
        </h2>

        {{-- Timer Section --}}
        <div id="liveTimer" class="hidden mb-6 p-4 bg-gradient-to-r from-purple-600/30 to-blue-600/30 border border-purple-500/50 rounded-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-white font-bold text-lg flex items-center gap-2">
                        ⚡ Sedang Berlangsung
                    </h3>
                    <p class="text-gray-300 text-sm" id="currentWorkoutTitle">{{ $schedule->workoutplan->title ?? 'Workout' }}</p>
                </div>
                <div class="text-right">
                    <div id="timerDisplay" class="text-2xl font-mono font-bold text-green-400">00:00:00</div>
                    <div class="text-xs text-gray-400 mt-1" id="timerStatus">Workout dimulai</div>
                </div>
            </div>
            <div class="mt-3 flex gap-2">
                <button id="pauseTimer" class="px-3 py-1 bg-yellow-500 hover:bg-yellow-400 text-black text-sm rounded-lg transition-all">
                    ⏸️ Jeda
                </button>
                <button id="resumeTimer" class="px-3 py-1 bg-blue-500 hover:bg-blue-400 text-white text-sm rounded-lg transition-all hidden">
                    ▶️ Lanjutkan
                </button>
                <button id="stopTimer" class="px-3 py-1 bg-red-500 hover:bg-red-400 text-white text-sm rounded-lg transition-all">
                    ⏹️ Selesai
                </button>
            </div>
        </div>

        <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-5 text-white mb-6">
            {{-- Info Workout --}}
            <h3 class="text-xl font-semibold">{{ $schedule->workoutplan->title ?? 'Workout Tidak Dikenal' }}</h3>
            <p class="text-gray-400 text-sm italic">
                Level: {{ ucfirst($schedule->workoutplan->difficulty_level ?? 'Beginner') }} •
                Durasi: {{ $schedule->workoutplan->duration_minutes ?? 30 }} menit
            </p>

            <p class="mt-3 text-sm text-gray-300 leading-relaxed">
                {{ $schedule->workoutplan->description ?? 'Panduan latihan personal dari sistem atau trainer.' }}
            </p>

            {{-- Info Pembuat --}}
            @if($schedule->workoutplan->trainer_id)
                <p class="mt-3 text-xs text-blue-300">
                    🧠 Dibuat oleh Trainer: <span class="font-semibold">{{ $schedule->workoutplan->trainer->name ?? 'Tidak Diketahui' }}</span>
                </p>
            @else
                <p class="mt-3 text-xs text-amber-300">
                    🧠 Dibuat oleh Admin / Sistem
                </p>
            @endif

            {{-- Notes Rekomendasi --}}
            @if(isset($bmiCategory))
                <div class="mt-4 text-gray-200 text-sm">
                    <p class="font-semibold mb-1">📋 Catatan Rekomendasi:</p>
                    <ul class="list-disc list-inside text-gray-300 space-y-1">
                        @switch($bmiCategory)
                            @case('underweight')
                                <li>Prioritaskan latihan beban untuk menambah massa otot.</li>
                                <li>Pastikan konsumsi kalori & protein mencukupi.</li>
                                <li>Istirahat cukup untuk pemulihan otot.</li>
                                @break
                            @case('normal')
                                <li>Pertahankan rutinitas latihan dan pola makan seimbang.</li>
                                <li>Lakukan progresif overload untuk menjaga hasil.</li>
                                @break
                            @case('overweight')
                                <li>Gabungkan latihan beban & cardio intensitas sedang.</li>
                                <li>Fokus pada defisit kalori dan kontrol gula.</li>
                                @break
                            @case('obese')
                                <li>Mulai dengan latihan ringan low-impact & konsisten.</li>
                                <li>Fokus pada nutrisi dan hidrasi.</li>
                                @break
                        @endswitch
                    </ul>
                </div>
            @endif
        </div>

        {{-- Form Edit Jadwal --}}
        <form action="{{ route('user.workouts.update', $schedule->id) }}" method="POST" id="workoutForm">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="scheduled_date" class="block text-sm text-amber-400 mb-1">📅 Tanggal</label>
                    <input type="date" id="scheduled_date" name="scheduled_date"
                        value="{{ $schedule->scheduled_date }}"
                        min="{{ now()->format('Y-m-d') }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-amber-400 focus:border-amber-400 transition-all duration-150" required>
                </div>

                <div>
                    <label for="scheduled_time" class="block text-sm text-amber-400 mb-1">⏰ Waktu Mulai</label>
                    <input type="time" id="scheduled_time" name="scheduled_time"
                        value="{{ $schedule->scheduled_time }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-amber-400 focus:border-amber-400 transition-all duration-150" required>
                    
                    {{-- Estimasi waktu selesai --}}
                    <p id="endTimeDisplay" class="text-xs text-gray-400 mt-2">
                        ⏳ Perkiraan selesai: <span class="text-amber-300 font-semibold" id="endTimeText">
                            {{ calculateEndTime($schedule->scheduled_time, $schedule->workoutplan->duration_minutes ?? 30) }}
                        </span>
                    </p>
                </div>

                <div>
                    <label for="notes" class="block text-sm text-amber-400 mb-1">📝 Catatan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-amber-400 focus:border-amber-400 transition-all duration-150 placeholder-gray-500"
                        placeholder="Tambahkan catatan tentang workout ini...">{{ $schedule->notes }}</textarea>
                </div>

                {{-- Status Workout --}}
                <div>
                    <label class="block text-sm text-amber-400 mb-1">📊 Status Workout</label>
                    <div class="flex gap-4 mt-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="pending" 
                                {{ $schedule->status === 'pending' ? 'checked' : '' }}
                                class="text-amber-400 bg-gray-800 border-gray-700 focus:ring-amber-400">
                            <span class="ml-2 text-white">⏳ Tertunda</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="status" value="completed" 
                                {{ $schedule->status === 'completed' ? 'checked' : '' }}
                                class="text-amber-400 bg-gray-800 border-gray-700 focus:ring-amber-400">
                            <span class="ml-2 text-white">✅ Selesai</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center gap-3 mt-6">
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

                    <button type="submit" 
                        class="flex-1 px-4 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 active:bg-amber-500
                               transition-all duration-150 shadow-lg shadow-amber-500/20">
                        💾 Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- 🔢 Script Timer dan Waktu dengan LocalStorage --}}
    <script>
        // Elements
        const scheduledDateInput = document.getElementById('scheduled_date');
        const scheduledTimeInput = document.getElementById('scheduled_time');
        const notesInput = document.getElementById('notes');
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
        const statusRadios = document.querySelectorAll('input[name="status"]');

        // Workout duration from PHP
        const workoutDuration = {{ $schedule->workoutplan->duration_minutes ?? 30 }};
        const scheduleId = {{ $schedule->id }};

        // Timer variables
        let timerInterval = null;
        let timerSeconds = 0;
        let isTimerRunning = false;
        let isTimerPaused = false;
        let timerStartTime = null;

        // LocalStorage keys
        const TIMER_KEY = `workout_timer_${scheduleId}`;
        const TIMER_START_KEY = `workout_start_${scheduleId}`;
        const TIMER_PAUSED_KEY = `workout_paused_${scheduleId}`;

        // Initialize timer from localStorage
        function initializeTimerFromStorage() {
            const savedTimer = localStorage.getItem(TIMER_KEY);
            const savedStartTime = localStorage.getItem(TIMER_START_KEY);
            const savedPaused = localStorage.getItem(TIMER_PAUSED_KEY);

            if (savedTimer && savedStartTime) {
                timerSeconds = parseInt(savedTimer);
                timerStartTime = parseInt(savedStartTime);
                
                if (savedPaused === 'true') {
                    // Timer was paused
                    isTimerRunning = true;
                    isTimerPaused = true;
                    showTimer();
                    updateTimerDisplay();
                    updateTimerButtons();
                    timerStatus.textContent = 'Dijeda - Sesi disimpan';
                } else {
                    // Timer was running - calculate elapsed time
                    const now = Math.floor(Date.now() / 1000);
                    const elapsedSeconds = now - timerStartTime;
                    timerSeconds += elapsedSeconds;
                    
                    isTimerRunning = true;
                    isTimerPaused = false;
                    showTimer();
                    startTimerInterval();
                    timerStatus.textContent = 'Berjalan - Dilanjutkan dari sesi sebelumnya';
                }
                
                // Set status to in_progress
                setStatus('in_progress');
            }
        }

        // Save timer state to localStorage
        function saveTimerState() {
            if (isTimerRunning) {
                localStorage.setItem(TIMER_KEY, timerSeconds.toString());
                
                if (!isTimerPaused) {
                    localStorage.setItem(TIMER_START_KEY, Math.floor(Date.now() / 1000).toString());
                } else {
                    localStorage.removeItem(TIMER_START_KEY);
                }
                
                localStorage.setItem(TIMER_PAUSED_KEY, isTimerPaused.toString());
            }
        }

        // Clear timer state from localStorage
        function clearTimerState() {
            localStorage.removeItem(TIMER_KEY);
            localStorage.removeItem(TIMER_START_KEY);
            localStorage.removeItem(TIMER_PAUSED_KEY);
        }

        // Show timer UI
        function showTimer() {
            liveTimer.classList.remove('hidden');
        }

        // Hide timer UI
        function hideTimer() {
            liveTimer.classList.add('hidden');
        }

        // Set current date and time as default
        function setCurrentDateTime() {
            const now = new Date();
            const dateString = now.toISOString().split('T')[0];
            const timeString = now.toTimeString().split(' ')[0].substring(0, 5);
            
            scheduledDateInput.value = dateString;
            scheduledTimeInput.value = timeString;
            
            updateEndTime();
        }

        // Update end time calculation
        function updateEndTime() {
            if (!scheduledTimeInput.value) return;

            const [hours, minutes] = scheduledTimeInput.value.split(':').map(Number);
            const startDate = new Date();
            startDate.setHours(hours);
            startDate.setMinutes(minutes);

            const endDate = new Date(startDate.getTime() + workoutDuration * 60000);
            const endHours = String(endDate.getHours()).padStart(2, '0');
            const endMinutes = String(endDate.getMinutes()).padStart(2, '0');

            endTimeText.textContent = `${endHours}:${endMinutes} (${workoutDuration} menit)`;
        }

        // Timer functions
        function startTimer() {
            if (isTimerRunning) return;

            // Show live timer
            showTimer();
            
            // Set status to in_progress
            setStatus('in_progress');
            
            // Start timer
            isTimerRunning = true;
            isTimerPaused = false;
            timerStartTime = Math.floor(Date.now() / 1000);
            
            startTimerInterval();
            saveTimerState();
            
            updateTimerButtons();
            
            // Auto-add note if empty
            if (!notesInput.value.trim()) {
                const now = new Date();
                const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                notesInput.value = `Workout dimulai pada ${timeString} - ${currentWorkoutTitle.textContent}`;
            }
        }

        function startTimerInterval() {
            timerInterval = setInterval(() => {
                if (!isTimerPaused) {
                    timerSeconds++;
                    updateTimerDisplay();
                    saveTimerState(); // Save every second for accuracy
                }
            }, 1000);
        }

        function pauseTimer() {
            isTimerPaused = true;
            clearInterval(timerInterval);
            timerInterval = null;
            timerStatus.textContent = 'Dijeda';
            updateTimerButtons();
            saveTimerState();
        }

        function resumeTimer() {
            isTimerPaused = false;
            timerStartTime = Math.floor(Date.now() / 1000);
            startTimerInterval();
            timerStatus.textContent = 'Berjalan';
            updateTimerButtons();
            saveTimerState();
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
                
                // Set status to completed
                setStatus('completed');
                
                // Add completion note
                const completionNote = `\n\n[Workout selesai] Durasi: ${formatTime(timerSeconds)}, Perkiraan kalori terbakar: ${calories} kal`;
                notesInput.value += completionNote;
                
                // Hide controls
                pauseTimerBtn.classList.add('hidden');
                resumeTimerBtn.classList.add('hidden');
                stopTimerBtn.textContent = '✓ Selesai';
                stopTimerBtn.classList.add('bg-green-600', 'hover:bg-green-500');
                stopTimerBtn.classList.remove('bg-red-500', 'hover:bg-red-400');
                
                // Clear localStorage
                clearTimerState();
                
                // Auto-hide after 5 seconds
                setTimeout(() => {
                    hideTimer();
                }, 5000);
            }
        }

        function setStatus(status) {
            statusRadios.forEach(radio => {
                if (status === 'in_progress') {
                    // Create in_progress radio if not exists
                    if (!document.querySelector('input[value="in_progress"]')) {
                        const newRadio = document.createElement('label');
                        newRadio.className = 'inline-flex items-center';
                        newRadio.innerHTML = `
                            <input type="radio" name="status" value="in_progress" checked 
                                class="text-amber-400 bg-gray-800 border-gray-700 focus:ring-amber-400">
                            <span class="ml-2 text-white">⚡ Sedang Berlangsung</span>
                        `;
                        document.querySelector('.flex.gap-4.mt-2').appendChild(newRadio);
                    } else {
                        document.querySelector('input[value="in_progress"]').checked = true;
                    }
                }
                radio.checked = radio.value === status;
            });
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
        scheduledTimeInput.addEventListener('input', updateEndTime);
        
        startNowBtn.addEventListener('click', function() {
            setCurrentDateTime();
            startTimer();
        });

        pauseTimerBtn.addEventListener('click', pauseTimer);
        resumeTimerBtn.addEventListener('click', resumeTimer);
        stopTimerBtn.addEventListener('click', stopTimer);

        // Save timer state before page unload
        window.addEventListener('beforeunload', function() {
            if (isTimerRunning) {
                saveTimerState();
            }
        });

        // Auto-update end time when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateEndTime();
            
            // Initialize timer from localStorage
            initializeTimerFromStorage();
            
            // Show timer if workout is in progress in database
            @if($schedule->status === 'in_progress')
                if (!isTimerRunning) {
                    // If not running from localStorage, show the option to continue
                    liveTimer.classList.remove('hidden');
                    timerDisplay.textContent = '00:00:00';
                    timerStatus.textContent = 'Siap untuk melanjutkan?';
                    setStatus('in_progress');
                }
            @endif
        });

        // Prevent form submission if timer is running
        document.getElementById('workoutForm').addEventListener('submit', function(e) {
            if (isTimerRunning && !confirm('Timer masih berjalan. Yakin ingin menyimpan?')) {
                e.preventDefault();
            } else {
                // Clear timer state on form submit if timer is not running
                if (!isTimerRunning) {
                    clearTimerState();
                }
            }
        });
    </script>

    <style>
        #liveTimer {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(147, 51, 234, 0.4); }
            70% { box-shadow: 0 0 0 10px rgba(147, 51, 234, 0); }
            100% { box-shadow: 0 0 0 0 rgba(147, 51, 234, 0); }
        }
        
        #timerDisplay {
            text-shadow: 0 0 10px rgba(34, 197, 94, 0.5);
        }
        
        input[type="radio"] {
            border-color: #6b7280;
        }
        
        input[type="radio"]:checked {
            background-color: #f59e0b;
            border-color: #f59e0b;
        }
    </style>
@endsection

@php
    function calculateEndTime($startTime, $duration) {
        if (!$startTime) return '-';
        
        $start = DateTime::createFromFormat('H:i:s', $startTime);
        if (!$start) $start = DateTime::createFromFormat('H:i', $startTime);
        
        if ($start) {
            $end = clone $start;
            $end->modify("+{$duration} minutes");
            return $end->format('H:i') . " ({$duration} menit)";
        }
        
        return '-';
    }
@endphp