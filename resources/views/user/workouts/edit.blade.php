@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            ✏️ Edit <span class="text-amber-400">Jadwal Workout</span>
        </h2>

        <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-5 text-white">
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
        <form action="{{ route('user.workouts.update', $schedule->id) }}" method="POST" class="mt-6">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <div>
                    <label for="scheduled_date" class="block text-sm text-gray-400 mb-1">📅 Tanggal</label>
                    <input type="date" id="scheduled_date" name="scheduled_date"
                        value="{{ $schedule->scheduled_date }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-amber-400 focus:border-amber-400" required>
                </div>

                <div>
                    <label for="scheduled_time" class="block text-sm text-gray-400 mb-1">⏰ Waktu</label>
                    <input type="time" id="scheduled_time" name="scheduled_time"
                        value="{{ $schedule->scheduled_time }}"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-amber-400 focus:border-amber-400" required>
                </div>

                <div>
                    <label for="notes" class="block text-sm text-gray-400 mb-1">📝 Catatan (Opsional)</label>
                    <textarea id="notes" name="notes" rows="3"
                        class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:ring-amber-400 focus:border-amber-400">{{ $schedule->notes }}</textarea>
                </div>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('user.workouts.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                    ⬅️ Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection
