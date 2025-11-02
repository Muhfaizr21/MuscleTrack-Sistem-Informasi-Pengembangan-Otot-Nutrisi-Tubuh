@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-2xl p-6 max-w-xl mx-auto">
        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            🕒 Atur <span class="text-amber-400">Jadwal Workout</span>
        </h2>

        <form action="{{ route('user.workouts.store') }}" method="POST" class="space-y-5">
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
                <input type="date" name="scheduled_date" value="{{ old('scheduled_date') }}"
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
                <textarea name="notes" rows="2"
                    class="mt-1 block w-full bg-gray-800 border border-gray-700 rounded-lg shadow-sm text-white text-sm px-3 py-2
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 placeholder-gray-500 transition-all duration-150"
                    placeholder="Contoh: fokus pada form squat...">{{ old('notes') }}</textarea>
                @error('notes')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- 🔘 Tombol Aksi --}}
            <div class="flex justify-between items-center pt-3">
                <a href="{{ route('user.workouts.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all duration-150">
                    ⬅️ Kembali
                </a>

                <button type="submit" class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 active:bg-amber-500
                           transition-all duration-150 shadow-lg shadow-amber-500/20">
                    💾 Simpan Jadwal
                </button>
            </div>
        </form>
    </div>

    {{-- 🔢 Script Hitung Waktu Selesai --}}
    <script>
        const workoutSelect = document.getElementById('workoutSelect');
        const startTimeInput = document.getElementById('startTime');
        const endTimeDisplay = document.getElementById('endTimeDisplay');
        const endTimeText = document.getElementById('endTimeText');

        let selectedDuration = null;

        // Ambil durasi saat workout dipilih
        workoutSelect.addEventListener('change', function () {
            selectedDuration = parseInt(this.options[this.selectedIndex].dataset.duration || 0);
            updateEndTime();
        });

        // Update waktu selesai saat waktu mulai berubah
        startTimeInput.addEventListener('input', updateEndTime);

        function updateEndTime() {
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

            endTimeText.textContent = `${endHours}:${endMinutes} WIB (${selectedDuration} menit)`;
            endTimeDisplay.classList.remove('hidden');
        }
    </script>
@endsection