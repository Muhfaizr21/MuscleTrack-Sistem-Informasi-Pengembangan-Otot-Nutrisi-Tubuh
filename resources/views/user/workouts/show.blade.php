@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            📘 Detail <span class="text-amber-400">Workout Plan</span>
        </h2>

        <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-5 text-white">
            {{-- Judul --}}
            <h3 class="text-2xl font-semibold">{{ $workout->title }}</h3>
            <p class="text-gray-400 text-sm italic mb-3">
                Level: {{ ucfirst($workout->difficulty_level ?? 'Beginner') }} •
                Durasi: {{ $workout->duration_minutes ?? 30 }} menit
            </p>

            {{-- Deskripsi --}}
            <p class="text-sm text-gray-300 leading-relaxed">
                {{ $workout->description ?? 'Tidak ada deskripsi latihan.' }}
            </p>

            {{-- Info Trainer --}}
            @if($workout->trainer_id)
                <p class="mt-3 text-xs text-blue-300">
                    🧠 Dibuat oleh Trainer: <span class="font-semibold">{{ $workout->trainer->name ?? 'Tidak Dikenal' }}</span>
                </p>
            @else
                <p class="mt-3 text-xs text-amber-300">
                    🧠 Dibuat oleh Admin / Sistem
                </p>
            @endif

            {{-- Catatan Rekomendasi --}}
            @if(isset($bmiCategory))
                <div class="mt-5">
                    <p class="text-sm font-semibold text-amber-400 mb-2">📋 Catatan Rekomendasi Sesuai Kondisi Tubuh:</p>
                    <ul class="list-disc list-inside text-gray-300 text-sm space-y-1">
                        @switch($bmiCategory)
                            @case('underweight')
                                <li>Gunakan beban sedang-berat dan makan lebih banyak kalori.</li>
                                <li>Latihan 3–4x/minggu dengan fokus compound movement.</li>
                                @break
                            @case('normal')
                                <li>Pertahankan keseimbangan latihan dan asupan nutrisi.</li>
                                <li>Perhatikan bentuk latihan untuk hasil maksimal.</li>
                                @break
                            @case('overweight')
                                <li>Latihan lebih sering dengan intensitas moderat.</li>
                                <li>Jaga defisit kalori dan istirahat cukup.</li>
                                @break
                            @case('obese')
                                <li>Mulai perlahan dan konsisten.</li>
                                <li>Prioritaskan aktivitas low-impact (jalan, sepeda, renang).</li>
                                @break
                        @endswitch
                    </ul>
                </div>
            @endif
        </div>

        <div class="flex justify-between items-center mt-6">
            <a href="{{ route('user.workouts.index') }}"
                class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                ⬅️ Kembali
            </a>

            <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                🗓️ Buat Jadwal Latihan
            </a>
        </div>
    </div>
@endsection
