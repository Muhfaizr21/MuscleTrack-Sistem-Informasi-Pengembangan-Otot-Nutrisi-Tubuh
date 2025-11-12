@extends('layouts.user')
@section('title', 'My Trainer')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Section -->
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex flex-col lg:flex-row items-center gap-8">
                    <!-- Avatar -->
                    <div class="relative">
                        @if($trainer->avatar)
                            <img src="{{ asset('storage/' . $trainer->avatar) }}" alt="{{ $trainer->name }}"
                                class="w-32 h-32 rounded-2xl object-cover border-4 border-emerald-400/20 shadow-lg">
                        @else
                            <div
                                class="w-32 h-32 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-4xl font-bold text-white shadow-lg border-4 border-emerald-400/20">
                                {{ strtoupper(substr($trainer->name, 0, 1)) }}
                            </div>
                        @endif
                        <!-- Verification Badge -->
                        @if($trainer->verification_status === 'approved')
                            <div
                                class="absolute -bottom-2 -right-2 bg-emerald-500 text-white p-2 rounded-full shadow-lg border border-emerald-400">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Trainer Info -->
                    <div class="flex-1 text-center lg:text-left">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-4 mb-4">
                            <h1 class="text-3xl font-black text-white">Trainer Saya: {{ $trainer->name }}</h1>
                            <div class="flex items-center gap-2 justify-center lg:justify-start">
                                @php
                                    $averageRating = \App\Models\Feedback::where('trainer_id', $trainer->id)->avg('rating');
                                    $ratingCount = \App\Models\Feedback::where('trainer_id', $trainer->id)->count();
                                @endphp
                                @if($averageRating > 0)
                                    <div
                                        class="flex items-center gap-1 bg-emerald-500/20 px-3 py-1 rounded-full border border-emerald-500/30">
                                        <svg class="w-4 h-4 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-emerald-400 font-semibold text-sm">
                                            {{ number_format($averageRating, 1) }} ({{ $ratingCount }} rating)
                                        </span>
                                    </div>
                                @endif
                                <span
                                    class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium border border-blue-500/30">
                                    {{ $trainer->trainerProfile->specialization ?? 'Personal Trainer' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-emerald-400/80 text-lg mb-4 leading-relaxed">
                            {{ $trainer->trainerProfile->bio ?? 'Trainer profesional yang berdedikasi untuk membantu Anda mencapai tujuan kebugaran.' }}
                        </p>

                        <!-- Status Akses -->
                        <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                            <span
                                class="bg-emerald-500/20 text-emerald-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 border border-emerald-500/30">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Trainer Aktif
                            </span>
                            @if($premiumAccess)
                                <span
                                    class="bg-purple-500/20 text-purple-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 border border-purple-500/30">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Akses Premium - Berakhir
                                    {{ \Carbon\Carbon::parse($premiumAccess->end_date)->format('d M Y') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Experience -->
                <div class="glass rounded-2xl p-6 border border-emerald-500/20 hover-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="bg-emerald-500/20 p-3 rounded-xl border border-emerald-500/30">
                            <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-emerald-400/80 text-sm">Pengalaman</p>
                            <p class="text-2xl font-bold text-white">{{ $trainer->trainerProfile->experience_years ?? '0' }}
                                Tahun</p>
                        </div>
                    </div>
                </div>

                <!-- Certifications -->
                <div class="glass rounded-2xl p-6 border border-blue-500/20 hover-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-500/20 p-3 rounded-xl border border-blue-500/30">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-blue-400/80 text-sm">Sertifikasi</p>
                            <p class="text-2xl font-bold text-white">
                                @if($trainer->trainerProfile && $trainer->trainerProfile->certifications)
                                    Tersedia
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Age -->
                <div class="glass rounded-2xl p-6 border border-green-500/20 hover-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="bg-green-500/20 p-3 rounded-xl border border-green-500/30">
                            <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-green-400/80 text-sm">Usia</p>
                            <p class="text-2xl font-bold text-white">{{ $trainer->age ?? 'N/A' }} Tahun</p>
                        </div>
                    </div>
                </div>

                <!-- Rating -->
                <div class="glass rounded-2xl p-6 border border-purple-500/20 hover-glow transition-all duration-300">
                    <div class="flex items-center gap-4">
                        <div class="bg-purple-500/20 p-3 rounded-xl border border-purple-500/30">
                            <svg class="w-6 h-6 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-purple-400/80 text-sm">Rating</p>
                            <p class="text-2xl font-bold text-white">{{ number_format($averageRating, 1) }}/5</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Cards -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <!-- Quick Actions -->
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6">
                    <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"
                                clip-rule="evenodd" />
                        </svg>
                        Akses Cepat
                    </h3>
                    <div class="space-y-4">
                        <a href="{{ route('user.chat.index') }}"
                            class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-2xl hover:bg-emerald-500/20 transition-all duration-300 group">
                            <div class="bg-emerald-500/20 p-2 rounded-xl">
                                <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-semibold">Chat dengan Trainer</p>
                                <p class="text-emerald-400/70 text-sm">Konsultasi langsung dengan trainer Anda</p>
                            </div>
                            <svg class="w-5 h-5 text-emerald-400 transform group-hover:translate-x-1 transition-transform"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>

                        <a href="{{ route('user.workouts.index') }}"
                            class="flex items-center gap-3 p-4 bg-blue-500/10 border border-blue-500/20 rounded-2xl hover:bg-blue-500/20 transition-all duration-300 group">
                            <div class="bg-blue-500/20 p-2 rounded-xl">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-semibold">Program Workout</p>
                                <p class="text-blue-400/70 text-sm">Lihat program latihan Anda</p>
                            </div>
                            <svg class="w-5 h-5 text-blue-400 transform group-hover:translate-x-1 transition-transform"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>

                        <a href="{{ route('user.nutrition.index') }}"
                            class="flex items-center gap-3 p-4 bg-purple-500/10 border border-purple-500/20 rounded-2xl hover:bg-purple-500/20 transition-all duration-300 group">
                            <div class="bg-purple-500/20 p-2 rounded-xl">
                                <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M18.894 11.443a1 1 0 00-1.257.143l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 00-1.257-.143 1 1 0 00-.143 1.257l4 4a3 3 0 004.242 0l4-4a1 1 0 00.143-1.257z" />
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="text-white font-semibold">Program Nutrition</p>
                                <p class="text-purple-400/70 text-sm">Lihat panduan nutrisi Anda</p>
                            </div>
                            <svg class="w-5 h-5 text-purple-400 transform group-hover:translate-x-1 transition-transform"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Rating & Actions -->
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6">
                    <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Beri Penilaian
                    </h3>

                    @if($hasRated)
                        <div class="text-center py-6">
                            <div class="bg-emerald-500/20 border border-emerald-500/30 rounded-2xl p-4 mb-4">
                                <p class="text-emerald-400 font-semibold">✅ Anda sudah memberikan rating untuk trainer ini</p>
                            </div>
                            <a href="{{ route('user.training.my-ratings') }}"
                                class="inline-flex items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                                Lihat Rating Saya
                            </a>
                        </div>
                    @else
                        <div class="text-center py-6">
                            <p class="text-emerald-400/80 mb-6">Bagikan pengalaman Anda dengan trainer ini</p>
                            <a href="{{ route('user.training.rate', $trainer->id) }}"
                                class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow mb-4">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                Beri Rating & Ulasan
                            </a>
                        </div>
                    @endif

                    <!-- Switch Trainer Option -->
                    <div class="mt-6 pt-6 border-t border-emerald-500/20">
                        <h4 class="text-lg font-semibold text-white mb-3">Kelola Trainer</h4>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('user.training.switch-trainer') }}"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-2xl transition-all duration-300 hover-glow text-center">
                                Ganti Trainer
                            </a>
                            <a href="{{ route('user.training.history') }}"
                                class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-4 rounded-2xl border border-gray-600 transition-all duration-300 text-center">
                                Riwayat Trainer
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            @if($trainer->trainerProfile)
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6 mb-8">
                    <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Informasi Detail Trainer
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if($trainer->trainerProfile->certifications)
                            <div class="space-y-2">
                                <p class="text-emerald-400/80 text-sm font-semibold">Sertifikasi:</p>
                                <p class="text-white">{{ $trainer->trainerProfile->certifications }}</p>
                            </div>
                        @endif
                        @if($trainer->trainerProfile->specialization)
                            <div class="space-y-2">
                                <p class="text-emerald-400/80 text-sm font-semibold">Spesialisasi:</p>
                                <p class="text-white">{{ $trainer->trainerProfile->specialization }}</p>
                            </div>
                        @endif
                        @if($trainer->trainerProfile->bio)
                            <div class="space-y-2 md:col-span-2">
                                <p class="text-emerald-400/80 text-sm font-semibold">Tentang Trainer:</p>
                                <p class="text-white leading-relaxed">{{ $trainer->trainerProfile->bio }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Access Information -->
            @if($premiumAccess)
                <div class="glass-dark rounded-3xl border border-purple-500/20 shadow-2xl shadow-purple-500/10 p-6">
                    <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Informasi Akses Premium
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="space-y-2">
                            <p class="text-purple-400/80 text-sm font-semibold">Mulai Akses:</p>
                            <p class="text-white">{{ \Carbon\Carbon::parse($premiumAccess->start_date)->format('d M Y') }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-purple-400/80 text-sm font-semibold">Berakhir Pada:</p>
                            <p class="text-white">{{ \Carbon\Carbon::parse($premiumAccess->end_date)->format('d M Y') }}</p>
                        </div>
                        <div class="space-y-2">
                            <p class="text-purple-400/80 text-sm font-semibold">Status:</p>
                            <span
                                class="bg-emerald-500/20 text-emerald-400 px-3 py-1 rounded-full text-sm font-medium border border-emerald-500/30">
                                Aktif
                            </span>
                        </div>
                    </div>
                    @php
                        $daysLeft = \Carbon\Carbon::now()->diffInDays($premiumAccess->end_date, false);
                    @endphp
                    @if($daysLeft > 0 && $daysLeft <= 7)
                        <div class="mt-4 bg-amber-500/20 border border-amber-500/30 rounded-2xl p-4">
                            <p class="text-amber-400 text-sm">
                                ⚠️ Akses premium Anda akan berakhir dalam {{ $daysLeft }} hari.
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <style>
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

        .hover-glow:hover {
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
@endsection