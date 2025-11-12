@extends('layouts.user')
@section('title', 'Detail Trainer')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header Card -->
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
                            <h1 class="text-3xl font-black text-white">{{ $trainer->name }}</h1>
                            <div class="flex items-center gap-2 justify-center lg:justify-start">
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

                        <!-- Status Badge -->
                        <div class="flex flex-wrap gap-3 justify-center lg:justify-start">
                            @if($trainer->verification_status === 'approved')
                                <span
                                    class="bg-emerald-500/20 text-emerald-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 border border-emerald-500/30">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Trainer Terverifikasi
                                </span>
                            @elseif($trainer->verification_status === 'pending')
                                <span
                                    class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 border border-yellow-500/30">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Menunggu Verifikasi
                                </span>
                            @else
                                <span
                                    class="bg-red-500/20 text-red-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2 border border-red-500/30">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Belum Terverifikasi
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

            <!-- Additional Information -->
            @if($trainer->trainerProfile)
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6 mb-8">
                    <h3 class="text-xl font-black text-white mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                clip-rule="evenodd" />
                        </svg>
                        Informasi Detail
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
            @else
                <!-- Message when no trainer profile -->
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6 mb-8">
                    <div class="text-center py-8">
                        <svg class="w-16 h-16 text-emerald-400/60 mx-auto mb-4" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-emerald-400/80 mb-2">Profil Trainer Belum Lengkap</h3>
                        <p class="text-emerald-400/60">Informasi detail tentang trainer ini sedang dalam proses penyempurnaan.
                        </p>
                    </div>
                </div>
            @endif

            <!-- Action Section -->
            <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-8">
                <div class="text-center">
                    <h3 class="text-2xl font-black text-white mb-4">Mulai Perjalanan Fitness Anda</h3>
                    <p class="text-emerald-400/80 mb-6">Dapatkan bimbingan personal dari trainer profesional untuk mencapai
                        target fitness Anda</p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                        @if(!$hasActiveTrainer)
                            <form action="{{ route('user.training.order', $trainer->id) }}" method="POST"
                                class="w-full sm:w-auto">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white font-bold py-4 px-8 rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none text-lg border border-emerald-400/30"
                                    @if($trainer->verification_status !== 'approved') disabled @endif>
                                    @if($trainer->verification_status === 'approved')
                                        <div class="flex items-center justify-center gap-3">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Pesan Sekarang - Rp150.000
                                        </div>
                                    @else
                                        <div class="flex items-center justify-center gap-3">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M13.477 14.89A6 6 0 015.11 6.524l8.367 8.368zm1.414-1.414L6.524 5.11a6 6 0 018.367 8.367zM18 10a8 8 0 11-16 0 8 8 0 0116 0z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                            Trainer Belum Terverifikasi
                                        </div>
                                    @endif
                                </button>
                            </form>
                        @else
                            @if(Auth::user()->trainer_id == $trainer->id)
                                <!-- User already has this trainer -->
                                <div class="space-y-4 w-full">
                                    <div class="bg-emerald-500/20 border border-emerald-500/30 rounded-2xl p-4">
                                        <p class="text-emerald-400 font-semibold">✅ Anda sudah memiliki trainer ini</p>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                        <a href="{{ route('user.training.my-trainer') }}"
                                            class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 hover-glow">
                                            Lihat Profil Trainer Saya
                                        </a>
                                        @if(!$hasRated)
                                            <a href="{{ route('user.training.rate', $trainer->id) }}"
                                                class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 hover-glow">
                                                Beri Rating
                                            </a>
                                        @else
                                            <span class="bg-gray-500 text-white font-semibold py-3 px-6 rounded-xl">
                                                Sudah Memberi Rating
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <!-- User has different trainer -->
                                <div class="space-y-4 w-full">
                                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-2xl p-4">
                                        <p class="text-blue-400 font-semibold">ℹ️ Anda sudah memiliki trainer aktif</p>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                        <a href="{{ route('user.training.my-trainer') }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 hover-glow">
                                            Lihat Trainer Saya
                                        </a>
                                        <a href="{{ route('user.training.switch-trainer') }}"
                                            class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 hover-glow">
                                            Ganti Trainer
                                        </a>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <a href="{{ route('user.training.index') }}"
                            class="w-full sm:w-auto bg-gray-700 hover:bg-gray-600 text-white font-semibold py-4 px-8 rounded-2xl border border-gray-600 transition-all duration-300 text-center">
                            Kembali ke Daftar Trainer
                        </a>
                    </div>

                    @if($trainer->verification_status !== 'approved' && !$hasActiveTrainer)
                        <p class="text-emerald-400/60 text-sm mt-4">
                            Trainer ini sedang dalam proses verifikasi. Anda dapat memesan setelah trainer terverifikasi.
                        </p>
                    @endif
                </div>
            </div>

            <!-- Rating & Reviews Section -->
            @if($ratingCount > 0)
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-8 mt-8">
                    <h3 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                        Ulasan & Rating ({{ $ratingCount }})
                    </h3>

                    <!-- Average Rating -->
                    <div class="text-center mb-6">
                        <div class="text-5xl font-black text-emerald-400 mb-2">{{ number_format($averageRating, 1) }}</div>
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-8 h-8 {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-600' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-emerald-400/80">Berdasarkan {{ $ratingCount }} ulasan</p>
                    </div>
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

        .text-gradient {
            background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endsection