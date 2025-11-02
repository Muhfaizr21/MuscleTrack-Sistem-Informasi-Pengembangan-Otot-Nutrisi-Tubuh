@extends('layouts.user')

@section('content')
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6">

    {{-- 🧮 Info BMI --}}
    @if(isset($bmi) && $bmi)
        <div class="bg-gray-800/60 border border-gray-700/50 rounded-lg p-4 mb-6 text-white">
            <p class="text-sm">
                💪 <span class="font-semibold">BMI kamu:</span> {{ number_format($bmi, 1) }}
                (<span class="capitalize">{{ $bmiCategory }}</span>)
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Rekomendasi workout di bawah ini disesuaikan dengan kondisi tubuh kamu.
            </p>

            <ul class="mt-3 text-sm list-disc list-inside text-gray-300 space-y-1">
                @switch($bmiCategory)
                    @case('underweight')
                        <li>Fokus pada latihan compound (bench press, squat, deadlift) untuk menambah massa otot.</li>
                        <li>Kombinasikan dengan surplus kalori & protein tinggi minimal 1.6g/kg berat badan.</li>
                        <li>Prioritaskan tidur 7–9 jam untuk pemulihan optimal.</li>
                        @break

                    @case('normal')
                        <li>Pertahankan pola latihan seimbang: 3–4x/minggu full-body atau upper/lower split.</li>
                        <li>Pastikan asupan protein cukup & hidrasi optimal.</li>
                        <li>Gunakan progressive overload agar performa terus meningkat.</li>
                        @break

                    @case('overweight')
                        <li>Fokus pada latihan HIIT, sirkuit, dan full-body movement untuk membakar kalori.</li>
                        <li>Kombinasikan dengan defisit kalori ringan & asupan serat tinggi.</li>
                        <li>Jaga rutinitas latihan minimal 4–5x/minggu.</li>
                        @break

                    @case('obese')
                        <li>Mulai dengan latihan low-impact: jalan cepat, sepeda statis, atau renang.</li>
                        <li>Utamakan konsistensi & nutrisi seimbang rendah lemak jenuh.</li>
                        <li>Evaluasi progres tiap 2 minggu dengan trainer atau sistem.</li>
                        @break

                    @default
                        <li>Belum ada data BMI, silakan isi berat dan tinggi badan di profil kamu.</li>
                @endswitch
            </ul>
        </div>
    @endif

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            🏋️ Workout <span class="text-amber-400">Plans</span>
        </h2>
        <a href="{{ route('user.workouts.create') }}"
           class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
            + Tambah Workout
        </a>
    </div>

    {{-- ✅ Notifikasi Sukses --}}
    @if(session('success'))
        <div class="bg-green-500/20 border border-green-500/50 text-green-300 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Workout Plans --}}
    @if($workouts->count() > 0)
        <div class="grid md:grid-cols-2 gap-5">
            @foreach($workouts as $workout)
                @php
                    $sourceLabel = 'Sistem Otomatis';
                    $sourceClass = 'text-gray-300';
                    if ($workout->recommended_by === 'trainer' && $workout->trainer_id) {
                        $trainerName = $workout->trainer->name ?? 'Trainer Tidak Dikenal';
                        $sourceLabel = 'Trainer: ' . $trainerName;
                        $sourceClass = 'text-blue-300';
                    } elseif (in_array($workout->recommended_by, ['admin', 'system']) || $workout->recommended_by === null) {
                        $sourceLabel = 'Admin / Sistem';
                        $sourceClass = 'text-amber-300';
                    }
                    $userSchedule = $schedules->firstWhere('workout_plan_id', $workout->id);
                @endphp

                <div class="bg-gray-900/50 border border-gray-700/50 rounded-xl p-4 transition-all hover:border-amber-400/50">
                    {{-- Judul & Status --}}
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-serif text-xl font-bold text-white">{{ $workout->title }}</h3>
                            <p class="text-sm text-gray-400 italic">
                                {{ ucfirst($workout->difficulty_level ?? 'beginner') }} •
                                {{ $workout->duration_minutes ?? 30 }} menit
                            </p>
                        </div>
                        <span class="bg-amber-400/20 text-amber-300 text-xs font-semibold px-2 py-1 rounded">
                            {{ ucfirst($workout->status ?? 'active') }}
                        </span>
                    </div>

                    {{-- Deskripsi --}}
                    <p class="mt-3 text-gray-300 text-sm leading-relaxed">
                        {{ $workout->description ?? 'Panduan latihan personal dari sistem atau trainer.' }}
                    </p>

                    {{-- Info Pembuat --}}
                    <div class="mt-3 text-xs {{ $sourceClass }}">
                        🧠 Dibuat oleh <span class="font-semibold">{{ $sourceLabel }}</span>
                    </div>

                    {{-- Tombol Lihat Detail --}}
                    <div class="mt-4">
                        <a href="{{ route('user.workouts.show', $workout->id) }}"
                           class="inline-flex items-center gap-2 text-sm font-semibold text-amber-400 hover:text-amber-300 transition-all">
                            🔍 Lihat Detail
                        </a>
                    </div>

                    {{-- Jadwal Workout User --}}
                    <div class="mt-4 bg-gray-800/50 rounded-lg p-3 border border-gray-700/50">
                        @if($userSchedule)
                            <p class="text-sm text-gray-300">
                                📅 <strong class="text-white">
                                    {{ \Carbon\Carbon::parse($userSchedule->scheduled_date)->translatedFormat('l, d F Y') }}
                                </strong>
                                • ⏰ {{ \Carbon\Carbon::parse($userSchedule->scheduled_time)->format('H:i') }}
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                Status:
                                <span class="text-amber-300 font-medium">
                                    {{ ucfirst($userSchedule->status ?? 'pending') }}
                                </span>
                            </p>

                            <div class="flex gap-4 mt-3">
                                <a href="{{ route('user.workouts.edit', $userSchedule->id) }}"
                                   class="text-amber-400 text-sm font-medium hover:underline">Edit Jadwal</a>

                                <form action="{{ route('user.workouts.destroy', $userSchedule->id) }}" method="POST"
                                      onsubmit="return confirm('Hapus jadwal latihan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 text-sm font-medium hover:underline">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-400 italic">Belum ada jadwal latihan.</p>
                            <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                               class="mt-2 inline-block bg-amber-400 text-black px-3 py-1.5 rounded-lg text-sm font-bold hover:bg-amber-300 transition-all">
                                + Atur Jadwal
                            </a>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-gray-400 py-10">
            Belum ada workout plan yang tersedia.
            <p class="text-sm text-gray-500">Trainer atau sistem akan menambahkan workout sesuai kondisi kamu.</p>
        </div>
    @endif
</div>
@endsection
