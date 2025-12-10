@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header Section --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                            <span class="text-2xl">💪</span>
                        </div>
                        <div>
                            <h1 class="text-3xl sm:text-4xl font-black text-white">
                                Detail <span class="text-gradient">Workout</span>
                            </h1>
                            <p class="text-emerald-400/80 text-lg mt-2">Instruksi lengkap latihan dan tutorial gerakan</p>
                        </div>
                    </div>
                    <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                        class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd" />
                        </svg>
                        Jadwalkan Workout Ini
                    </a>
                </div>
            </div>

            {{-- Workout Overview --}}
            <div class="glass-dark rounded-3xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- Workout Info --}}
                    <div>
                        <h2 class="text-2xl font-black text-white mb-2">{{ $workout->title }}</h2>
                        <p class="text-emerald-400/80 text-lg mb-4">{{ $workout->description }}</p>

                        <div class="flex flex-wrap gap-4 mb-4">
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 text-sm font-bold">Level:</span>
                                <span
                                    class="text-white text-sm font-medium capitalize">{{ $workout->difficulty_level ?? 'Pemula' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 text-sm font-bold">Durasi:</span>
                                <span class="text-white text-sm font-medium">{{ $totalDuration ?? 0 }} menit</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-emerald-400 text-sm font-bold">Latihan:</span>
                                <span class="text-white text-sm font-medium">{{ $exerciseCount ?? 0 }} latihan</span>
                            </div>
                            @isset($totalCalories)
                                <div class="flex items-center gap-2">
                                    <span class="text-emerald-400 text-sm font-bold">Kalori:</span>
                                    <span class="text-white text-sm font-medium">{{ round($totalCalories) }} kkal</span>
                                </div>
                            @endisset
                        </div>

                        <div class="flex items-center gap-2 text-sm text-emerald-400">
                            <span>Dibuat oleh:</span>
                            <span class="font-bold text-white">{{ $trainerName ?? 'Sistem' }}</span>
                        </div>
                    </div>

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-2 gap-4">
                        <div class="glass rounded-xl p-4 text-center border border-emerald-500/10">
                            <div class="text-2xl font-black text-emerald-400 mb-1">{{ $exerciseCount ?? 0 }}</div>
                            <div class="text-xs text-emerald-400/80">Total Latihan</div>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-emerald-500/10">
                            <div class="text-2xl font-black text-blue-400 mb-1">{{ $totalDuration ?? 0 }}</div>
                            <div class="text-xs text-blue-400/80">Menit</div>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-emerald-500/10">
                            <div class="text-2xl font-black text-amber-400 mb-1 capitalize">{{ $workout->difficulty_level ?? 'pemula' }}</div>
                            <div class="text-xs text-amber-400/80">Tingkat Kesulitan</div>
                        </div>
                        <div class="glass rounded-xl p-4 text-center border border-emerald-500/10">
                            <div class="text-2xl font-black text-purple-400 mb-1">{{ $workout->duration_weeks ?? 4 }}</div>
                            <div class="text-xs text-purple-400/80">Minggu</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BMI Recommendations --}}
            @isset($bmiCategory)
                <div class="glass-dark rounded-3xl p-6 border border-amber-500/20 shadow-xl shadow-amber-500/10 mb-8">
                    <h3 class="text-lg font-black text-white mb-4 flex items-center gap-2">
                        <span class="text-amber-400">🎯 Rekomendasi Personalisasi</span>
                    </h3>
                    <div class="space-y-3">
                        @switch($bmiCategory)
                            @case('underweight')
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                                    <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-amber-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Fokus pada latihan compound dengan beban sedang-berat</p>
                                        <p class="text-amber-400/70 text-sm">Bench press, squat, deadlift untuk membangun massa otot secara efektif</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                                    <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-amber-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Kombinasikan dengan surplus kalori & asupan protein tinggi</p>
                                        <p class="text-amber-400/70 text-sm">Minimal 1.6g/kg berat badan protein untuk pertumbuhan otot optimal</p>
                                    </div>
                                </div>
                            @break

                            @case('normal')
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                    <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-emerald-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Pertahankan pola latihan seimbang dengan progressive overload</p>
                                        <p class="text-emerald-400/70 text-sm">3-4x/minggu full-body atau upper/lower split untuk hasil berkelanjutan</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-500/5 border border-emerald-500/10">
                                    <div class="w-6 h-6 bg-emerald-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-emerald-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Fokus pada form dan teknik yang benar</p>
                                        <p class="text-emerald-400/70 text-sm">Kualitas lebih penting dari kuantitas untuk kemajuan jangka panjang</p>
                                    </div>
                                </div>
                            @break

                            @case('overweight')
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-blue-500/5 border border-blue-500/10">
                                    <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-blue-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Tekankan HIIT dan circuit training full-body</p>
                                        <p class="text-blue-400/70 text-sm">Gerakan compound untuk pembakaran kalori maksimal dan boost metabolik</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-blue-500/5 border border-blue-500/10">
                                    <div class="w-6 h-6 bg-blue-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-blue-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Pertahankan konsistensi workout dan defisit kalori ringan</p>
                                        <p class="text-blue-400/70 text-sm">Minimal 4-5 kali per minggu dengan recovery yang tepat</p>
                                    </div>
                                </div>
                            @break

                            @case('obese')
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10">
                                    <div class="w-6 h-6 bg-red-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-red-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Mulai dengan latihan low-impact dan progresi bertahap</p>
                                        <p class="text-red-400/70 text-sm">Jalan kaki, sepeda statis, atau berenang untuk membangun fondasi</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-3 p-3 rounded-xl bg-red-500/5 border border-red-500/10">
                                    <div class="w-6 h-6 bg-red-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                        <span class="text-red-400 text-sm">•</span>
                                    </div>
                                    <div>
                                        <p class="text-white font-medium">Fokus pada konsistensi daripada intensitas</p>
                                        <p class="text-red-400/70 text-sm">Bangun kebiasaan berkelanjutan dengan evaluasi progres reguler</p>
                                    </div>
                                </div>
                            @break
                        @endswitch
                    </div>
                </div>
            @endisset

            {{-- Exercises Section --}}
            <div class="space-y-6">
                <h2 class="text-2xl font-black text-white mb-4 flex items-center gap-2">
                    <span class="text-gradient">Instruksi Latihan</span>
                    <span class="text-emerald-400/60 text-lg">({{ $exerciseCount ?? 0 }} latihan)</span>
                </h2>

                {{-- Workout Exercises (from workout_exercises table) --}}
                @if($workout->workoutExercises->count() > 0)
                    @foreach($workout->workoutExercises as $index => $exercise)
                        <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-xl shadow-emerald-500/10 overflow-hidden">
                            <div class="p-6">
                                {{-- Exercise Header --}}
                                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-emerald-400 text-lg font-black">#{{ $index + 1 }}</span>
                                            <h3 class="text-xl font-black text-white">{{ $exercise->name }}</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            @if($exercise->type)
                                                <span
                                                    class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 capitalize">
                                                    {{ $exercise->type }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-white">
                                        @if($exercise->sets)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-emerald-400">{{ $exercise->sets }}</span>
                                                <span class="text-xs text-emerald-400/80">Set</span>
                                            </div>
                                        @endif
                                        @if($exercise->reps)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-blue-400">{{ $exercise->reps }}</span>
                                                <span class="text-xs text-blue-400/80">Repetisi</span>
                                            </div>
                                        @endif
                                        @if($exercise->rest_seconds)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-amber-400">{{ $exercise->rest_seconds }}</span>
                                                <span class="text-xs text-amber-400/80">Istirahat</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Exercise Instructions --}}
                                <div class="glass rounded-xl p-4 border border-emerald-500/10 mb-4">
                                    <h4 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0118 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        Catatan Latihan
                                    </h4>
                                    <p class="text-emerald-400/80 text-sm leading-relaxed">
                                        @if($exercise->type === 'cardio')
                                            Fokus pada kecepatan konsisten dan pernapasan yang benar selama durasi latihan.
                                        @elseif($exercise->type === 'strength')
                                            Kontrol gerakan, fokus pada form, dan pertahankan ketegangan selama set.
                                        @elseif($exercise->type === 'core')
                                            Aktifkan core selama gerakan dan hindari ketegangan di leher.
                                        @else
                                            Lakukan setiap repetisi dengan gerakan terkontrol dan form yang benar.
                                        @endif
                                    </p>
                                </div>

                                {{-- Video Tutorial Placeholder --}}
                                <div class="glass rounded-xl p-4 border border-emerald-500/10">
                                    <h4 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path
                                                d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                                        </svg>
                                        Tutorial Gerakan
                                    </h4>
                                    <div
                                        class="aspect-w-16 aspect-h-9 bg-gray-800/50 rounded-lg flex items-center justify-center border border-emerald-500/20">
                                        <div class="text-center">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-12 w-12 text-emerald-400/50 mx-auto mb-2" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <p class="text-emerald-400/60 text-sm">Video tutorial tersedia di library latihan</p>
                                            <p class="text-emerald-400/40 text-xs mt-1">Konsultasi dengan trainer untuk demonstrasi form</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- Exercises from exercises table (many-to-many) --}}
                @if($workout->exercises->count() > 0)
                    @foreach($workout->exercises as $index => $exercise)
                        <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-xl shadow-emerald-500/10 overflow-hidden">
                            <div class="p-6">
                                {{-- Exercise Header --}}
                                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4 mb-6">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <span class="text-emerald-400 text-lg font-black">#{{ $index + 1 + $workout->workoutExercises->count() }}</span>
                                            <h3 class="text-xl font-black text-white">{{ $exercise->name }}</h3>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span
                                                class="text-xs font-medium px-2.5 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 capitalize">
                                                {{ $exercise->type }}
                                            </span>
                                            <span
                                                class="text-xs font-medium px-2.5 py-1 rounded-full bg-blue-500/10 text-blue-400 border border-blue-500/20 capitalize">
                                                {{ $exercise->muscle_group }}
                                            </span>
                                            <span
                                                class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-500/10 text-amber-400 border border-amber-500/20 capitalize">
                                                {{ $exercise->difficulty }}
                                            </span>
                                            @if($exercise->equipment)
                                                <span
                                                    class="text-xs font-medium px-2.5 py-1 rounded-full bg-gray-500/10 text-gray-400 border border-gray-500/20">
                                                    {{ $exercise->equipment }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-4 text-sm text-white">
                                        {{-- PERBAIKAN: Gunakan null-safe operator untuk pivot --}}
                                        @if($exercise->pivot && $exercise->pivot->sets)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-emerald-400">{{ $exercise->pivot->sets }}</span>
                                                <span class="text-xs text-emerald-400/80">Set</span>
                                            </div>
                                        @endif
                                        @if($exercise->pivot && $exercise->pivot->reps)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-blue-400">{{ $exercise->pivot->reps }}</span>
                                                <span class="text-xs text-blue-400/80">Repetisi</span>
                                            </div>
                                        @endif
                                        @if($exercise->pivot && $exercise->pivot->duration)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-amber-400">{{ $exercise->pivot->duration }}</span>
                                                <span class="text-xs text-amber-400/80">Detik</span>
                                            </div>
                                        @endif
                                        @if($exercise->pivot && $exercise->pivot->rest_interval)
                                            <div class="text-center">
                                                <span class="block text-2xl font-black text-purple-400">{{ $exercise->pivot->rest_interval }}</span>
                                                <span class="text-xs text-purple-400/80">Istirahat</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Exercise Content --}}
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                    {{-- Instructions & Details --}}
                                    <div class="space-y-4">
                                        @if($exercise->description)
                                            <div>
                                                <h4 class="text-sm font-bold text-white mb-2">Deskripsi</h4>
                                                <p class="text-emerald-400/80 text-sm leading-relaxed">{{ $exercise->description }}</p>
                                            </div>
                                        @endif

                                        @if($exercise->instructions)
                                            <div>
                                                <h4 class="text-sm font-bold text-white mb-2">Instruksi</h4>
                                                <div class="text-emerald-400/80 text-sm leading-relaxed space-y-2">
                                                    {!! nl2br(e($exercise->instructions)) !!}
                                                </div>
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between pt-4 border-t border-emerald-500/20">
                                            <div class="flex items-center gap-4 text-sm">
                                                @if($exercise->calories_burned)
                                                    <span class="text-white">
                                                        <span class="font-bold text-emerald-400">{{ $exercise->calories_burned }}</span> kkal/menit
                                                    </span>
                                                @endif
                                                @if($exercise->duration)
                                                    <span class="text-white">
                                                        <span class="font-bold text-blue-400">{{ $exercise->duration }}</span> detik
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Video Tutorial Section --}}
                                    <div>
                                        {{-- Video Tutorial --}}
                                        @if($exercise->video_url)
                                            <div>
                                                <h4 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                                                    </svg>
                                                    Video Tutorial
                                                </h4>
                                                <div
                                                    class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden bg-gray-800/50 border border-emerald-500/20">
                                                    @php
                                                        // Parse YouTube URL untuk mendapatkan video ID
                                                        $videoUrl = $exercise->video_url;
                                                        $videoId = null;

                                                        if (str_contains($videoUrl, 'youtube.com/watch?v=')) {
                                                            parse_str(parse_url($videoUrl, PHP_URL_QUERY), $params);
                                                            $videoId = $params['v'] ?? null;
                                                        } elseif (str_contains($videoUrl, 'youtu.be/')) {
                                                            $videoId = substr(parse_url($videoUrl, PHP_URL_PATH), 1);
                                                        } elseif (str_contains($videoUrl, 'youtube.com/embed/')) {
                                                            $path = parse_url($videoUrl, PHP_URL_PATH);
                                                            $videoId = str_replace('/embed/', '', $path);
                                                        }
                                                    @endphp

                                                    @if($videoId)
                                                        <iframe src="https://www.youtube.com/embed/{{ $videoId }}?rel=0&showinfo=0&modestbranding=1"
                                                            frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen class="w-full h-48 rounded-lg" loading="lazy"
                                                            referrerpolicy="no-referrer-when-downgrade"
                                                            title="Video tutorial: {{ $exercise->name }}">
                                                        </iframe>
                                                    @else
                                                        {{-- Fallback: Tampilkan link --}}
                                                        <div class="w-full h-48 flex items-center justify-center">
                                                            <div class="text-center p-4">
                                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                                    class="h-12 w-12 text-emerald-400/50 mx-auto mb-2"
                                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="1"
                                                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="1"
                                                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                <p class="text-emerald-400/80 text-sm mb-2">Video tutorial tersedia</p>
                                                                <a href="{{ $videoUrl }}" target="_blank"
                                                                    rel="noopener noreferrer"
                                                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3"
                                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            stroke-width="2"
                                                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                    </svg>
                                                                    Buka di YouTube
                                                                </a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if($videoId)
                                                    <p class="text-emerald-400/60 text-xs mt-1 text-center">Tonton video tutorial untuk form yang benar</p>
                                                @endif
                                            </div>
                                        @else
                                            {{-- No Video Available --}}
                                            <div class="glass rounded-xl p-4 border border-emerald-500/10">
                                                <h4 class="text-sm font-bold text-white mb-3 flex items-center gap-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path
                                                            d="M2 6a2 2 0 012-2h6a2 2 0 012 2v8a2 2 0 01-2 2H4a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v8a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                                                    </svg>
                                                    Tutorial Gerakan
                                                </h4>
                                                <div
                                                    class="aspect-w-16 aspect-h-9 bg-gray-800/50 rounded-lg flex items-center justify-center border border-emerald-500/20">
                                                    <div class="text-center p-4">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-12 w-12 text-emerald-400/50 mx-auto mb-2" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1"
                                                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="1"
                                                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                        </svg>
                                                        <p class="text-emerald-400/80 text-sm">Video tutorial belum tersedia</p>
                                                        <p class="text-emerald-400/60 text-xs mt-1">Konsultasi dengan trainer untuk demonstrasi form yang benar</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                        {{-- Additional Tips --}}
                                        <div class="mt-4 glass rounded-xl p-4 border border-emerald-500/10">
                                            <h4 class="text-sm font-bold text-white mb-2 flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-amber-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0118 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                Tips & Keamanan
                                            </h4>
                                            <ul class="text-emerald-400/80 text-sm space-y-2">
                                                @if($exercise->type === 'strength')
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Lakukan pemanasan yang cukup sebelum memulai</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Gunakan beban yang sesuai dengan level Anda</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Pertahankan form yang benar selama setiap repetisi</span>
                                                    </li>
                                                @elseif($exercise->type === 'cardio')
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Mulai dengan intensitas sedang dan tingkatkan secara bertahap</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Pastikan tetap terhidrasi selama sesi latihan</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Dengarkan tubuh Anda dan istirahat saat diperlukan</span>
                                                    </li>
                                                @else
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Fokus pada gerakan terkontrol</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Bernapas secara konsisten selama latihan</span>
                                                    </li>
                                                    <li class="flex items-start gap-2">
                                                        <span class="text-emerald-400">•</span>
                                                        <span>Berhenti jika merasakan sakit tajam</span>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{-- No Exercises Message --}}
                @if($workout->exercises->count() === 0 && $workout->workoutExercises->count() === 0)
                    <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 text-center">
                        <div class="w-16 h-16 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                            <span class="text-2xl">💪</span>
                        </div>
                        <h3 class="text-lg font-bold text-white mb-2">Belum Ada Latihan Ditambahkan</h3>
                        <p class="text-emerald-400/80 mb-4">Rencana workout ini belum memiliki latihan yang dikonfigurasi.</p>
                    </div>
                @endif
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row gap-4 justify-between items-center mt-8">
                <a href="{{ route('user.workouts.index') }}"
                    class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-gray-400 hover:text-white transition-all duration-300 border border-gray-600 hover:bg-gray-700/50 w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Workouts
                </a>
                <a href="{{ route('user.workouts.create', ['workout_id' => $workout->id]) }}"
                    class="group flex items-center gap-2 px-8 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 w-full sm:w-auto justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd" />
                    </svg>
                    Jadwalkan Workout Ini
                </a>
            </div>
        </div>
    </div>

    <style>
        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .glass {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .animate-glow {
            animation: glow 2s ease-in-out infinite alternate;
        }

        @keyframes glow {
            from {
                box-shadow: 0 0 10px rgba(16, 185, 129, 0.4);
            }

            to {
                box-shadow: 0 0 20px rgba(16, 185, 129, 0.6), 0 0 30px rgba(16, 185, 129, 0.4);
            }
        }
    </style>
@endsection
