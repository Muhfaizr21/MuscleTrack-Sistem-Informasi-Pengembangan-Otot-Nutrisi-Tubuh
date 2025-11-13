@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-2xl p-6 max-w-xl mx-auto">
        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            🕒 Atur <span class="text-amber-400">Jadwal Workout</span>
        </h2>

        {{-- Auto-save Status --}}
        <div id="autoSaveStatus" class="hidden mb-4 p-3 bg-emerald-500/10 border border-emerald-500/20 rounded-lg">
            <div class="flex items-center gap-2 text-emerald-400 text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                        clip-rule="evenodd" />
                </svg>
                <span>Data tersimpan otomatis</span>
                <div class="ml-auto text-xs text-emerald-400/60" id="lastSaved"></div>
            </div>
        </div>

        {{-- Recovery Notification --}}
        <div id="recoveryNotification" class="hidden mb-4 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg">
            <div class="flex items-start gap-3">
                <div class="w-6 h-6 bg-blue-500/20 rounded-full flex items-center justify-center mt-0.5">
                    <span class="text-blue-400 text-sm">💾</span>
                </div>
                <div class="flex-1">
                    <h4 class="text-blue-400 font-bold text-sm mb-1">Data Ditemukan!</h4>
                    <p class="text-blue-400/80 text-xs mb-2">Kami menemukan data yang belum tersimpan dari sesi sebelumnya.
                    </p>
                    <div class="flex gap-2">
                        <button id="restoreData"
                            class="px-3 py-1 bg-blue-500 hover:bg-blue-400 text-white text-xs rounded-lg transition-all">
                            Pulihkan Data
                        </button>
                        <button id="discardData"
                            class="px-3 py-1 bg-gray-600 hover:bg-gray-500 text-white text-xs rounded-lg transition-all">
                            Hapus
                        </button>
                    </div>
                </div>
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
                                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 transition-all duration-150"
                    required>
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

                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 active:bg-amber-500
                                                   transition-all duration-150 shadow-lg shadow-amber-500/20">
                    💾 Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

    {{-- 🔢 Script Auto-save Sederhana --}}
    <script>
        // Storage keys
        const STORAGE_KEYS = {
            FORM_DATA: 'workout_form_data',
            LAST_SAVED: 'workout_last_saved'
        };

        // Elements
        const workoutSelect = document.getElementById('workoutSelect');
        const startTimeInput = document.getElementById('startTime');
        const scheduledDateInput = document.getElementById('scheduledDate');
        const workoutNotes = document.getElementById('workoutNotes');
        const endTimeDisplay = document.getElementById('endTimeDisplay');
        const endTimeText = document.getElementById('endTimeText');
        const autoSaveStatus = document.getElementById('autoSaveStatus');
        const lastSaved = document.getElementById('lastSaved');
        const recoveryNotification = document.getElementById('recoveryNotification');
        const restoreDataBtn = document.getElementById('restoreData');
        const discardDataBtn = document.getElementById('discardData');

        // Initialize
        function initialize() {
            setCurrentDateTime();
            checkForRecoveryData();
            startAutoSave();
            updateEndTime();
        }

        // Check for recovery data
        function checkForRecoveryData() {
            const savedData = getStoredData(STORAGE_KEYS.FORM_DATA);
            if (savedData && Object.keys(savedData).length > 0) {
                recoveryNotification.classList.remove('hidden');
            }
        }

        // Auto-save functionality
        function startAutoSave() {
            // Save immediately
            saveFormData();

            // Set up interval for auto-save (every 10 seconds)
            setInterval(() => {
                saveFormData();
            }, 10000);
        }

        // Save form data to localStorage
        function saveFormData() {
            const formData = {
                workout_id: workoutSelect.value,
                scheduled_date: scheduledDateInput.value,
                scheduled_time: startTimeInput.value,
                notes: workoutNotes.value,
                last_saved: new Date().toISOString()
            };

            localStorage.setItem(STORAGE_KEYS.FORM_DATA, JSON.stringify(formData));
            localStorage.setItem(STORAGE_KEYS.LAST_SAVED, new Date().toISOString());
            showAutoSaveStatus();
        }

        // Get stored data
        function getStoredData(key) {
            try {
                const data = localStorage.getItem(key);
                return data ? JSON.parse(data) : null;
            } catch (error) {
                console.error('Error reading from localStorage:', error);
                return null;
            }
        }

        // Show auto-save status
        function showAutoSaveStatus() {
            const savedTime = getStoredData(STORAGE_KEYS.LAST_SAVED);
            if (savedTime) {
                const time = new Date(savedTime);
                lastSaved.textContent = `Terakhir disimpan: ${time.toLocaleTimeString()}`;
            }
            autoSaveStatus.classList.remove('hidden');

            // Hide after 3 seconds
            setTimeout(() => {
                autoSaveStatus.classList.add('hidden');
            }, 3000);
        }

        // Clear all stored data
        function clearStoredData() {
            Object.values(STORAGE_KEYS).forEach(key => {
                localStorage.removeItem(key);
            });
        }

        // Set current date and time as default
        function setCurrentDateTime() {
            const now = new Date();
            const dateString = now.toISOString().split('T')[0];
            const timeString = now.toTimeString().split(' ')[0].substring(0, 5);

            // Only set if no value exists
            if (!scheduledDateInput.value) {
                scheduledDateInput.value = dateString;
            }
            if (!startTimeInput.value) {
                startTimeInput.value = timeString;
            }

            updateEndTime();
        }

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

        // Restore saved data
        function restoreSavedData() {
            const savedData = getStoredData(STORAGE_KEYS.FORM_DATA);
            if (savedData) {
                if (savedData.workout_id) workoutSelect.value = savedData.workout_id;
                if (savedData.scheduled_date) scheduledDateInput.value = savedData.scheduled_date;
                if (savedData.scheduled_time) startTimeInput.value = savedData.scheduled_time;
                if (savedData.notes) workoutNotes.value = savedData.notes;

                updateEndTime();
                recoveryNotification.classList.add('hidden');
                showAutoSaveStatus();
            }
        }

        // Event listeners
        workoutSelect.addEventListener('change', function () {
            updateEndTime();
            saveFormData();
        });

        startTimeInput.addEventListener('input', function () {
            updateEndTime();
            saveFormData();
        });

        scheduledDateInput.addEventListener('input', saveFormData);
        workoutNotes.addEventListener('input', saveFormData);

        // Recovery buttons
        restoreDataBtn.addEventListener('click', restoreSavedData);
        discardDataBtn.addEventListener('click', function () {
            clearStoredData();
            recoveryNotification.classList.add('hidden');
        });

        // Form submit handler
        document.getElementById('workoutForm').addEventListener('submit', function () {
            // Clear stored data on successful form submission
            clearStoredData();
        });

        // Initialize when page loads
        document.addEventListener('DOMContentLoaded', initialize);
    </script>

    <style>
        #autoSaveStatus {
            transition: all 0.3s ease;
        }

        #recoveryNotification {
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endsection