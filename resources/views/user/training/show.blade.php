@extends('layouts.user')
@section('title', 'Detail Trainer')

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">
        <!-- Header Card -->
        <div
            class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-2xl overflow-hidden mb-8">
            <div class="p-8">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <!-- Avatar -->
                    <div class="relative">
                        @if($trainer->avatar)
                            <img src="{{ asset('storage/' . $trainer->avatar) }}" alt="{{ $trainer->name }}"
                                class="w-32 h-32 rounded-2xl object-cover border-4 border-amber-400/20 shadow-lg">
                        @else
                            <div
                                class="w-32 h-32 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl flex items-center justify-center text-4xl font-bold text-white shadow-lg border-4 border-amber-400/20">
                                {{ strtoupper(substr($trainer->name, 0, 1)) }}
                            </div>
                        @endif
                        <!-- Verification Badge -->
                        @if($trainer->verification_status === 'approved')
                            <div class="absolute -bottom-2 -right-2 bg-green-500 text-white p-2 rounded-full shadow-lg">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Trainer Info -->
                    <div class="flex-1 text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-4 mb-4">
                            <h1 class="text-3xl font-bold text-white">{{ $trainer->name }}</h1>
                            <div class="flex items-center gap-2 justify-center md:justify-start">
                                @if($trainer->trainerProfile && $trainer->trainerProfile->rating > 0)
                                    <div class="flex items-center gap-1 bg-amber-400/20 px-3 py-1 rounded-full">
                                        <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                        <span class="text-amber-400 font-semibold text-sm">
                                            {{ number_format($trainer->trainerProfile->rating, 1) }}
                                        </span>
                                    </div>
                                @endif
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium">
                                    {{ $trainer->trainerProfile->specialization ?? 'Personal Trainer' }}
                                </span>
                            </div>
                        </div>

                        <p class="text-gray-300 text-lg mb-4 leading-relaxed">
                            {{ $trainer->trainerProfile->bio ?? 'Trainer profesional yang berdedikasi untuk membantu Anda mencapai tujuan kebugaran.' }}
                        </p>

                        <!-- Status Badge -->
                        <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                            @if($trainer->verification_status === 'approved')
                                <span
                                    class="bg-green-500/20 text-green-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Trainer Terverifikasi
                                </span>
                            @elseif($trainer->verification_status === 'pending')
                                <span
                                    class="bg-yellow-500/20 text-yellow-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Menunggu Verifikasi
                                </span>
                            @else
                                <span
                                    class="bg-red-500/20 text-red-400 px-4 py-2 rounded-full text-sm font-medium flex items-center gap-2">
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
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Experience -->
            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-amber-100 text-sm">Pengalaman</p>
                        <p class="text-2xl font-bold">{{ $trainer->trainerProfile->experience_years ?? '0' }} Tahun</p>
                    </div>
                </div>
            </div>

            <!-- Certifications -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-blue-100 text-sm">Sertifikasi</p>
                        <p class="text-2xl font-bold">
                            @if($trainer->trainerProfile && $trainer->trainerProfile->certifications)
                                Tersedia
                            @else
                                Tidak Ada
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Age -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-green-100 text-sm">Usia</p>
                        <p class="text-2xl font-bold">{{ $trainer->age ?? 'N/A' }} Tahun</p>
                    </div>
                </div>
            </div>

            <!-- Physical Stats -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                <div class="flex items-center gap-4">
                    <div class="bg-white/20 p-3 rounded-xl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-purple-100 text-sm">Tinggi/Berat</p>
                        <p class="text-lg font-bold">
                            {{ $trainer->height ?? 'N/A' }}cm / {{ $trainer->weight ?? 'N/A' }}kg
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Info if Trainer Profile Exists -->
        @if($trainer->trainerProfile)
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-2xl p-6 mb-8">
                <h3 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                            clip-rule="evenodd" />
                    </svg>
                    Informasi Tambahan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @if($trainer->trainerProfile->certifications)
                        <div>
                            <p class="text-gray-400 text-sm">Sertifikasi Detail:</p>
                            <p class="text-white">{{ $trainer->trainerProfile->certifications }}</p>
                        </div>
                    @endif
                    @if($trainer->trainerProfile->specialization)
                        <div>
                            <p class="text-gray-400 text-sm">Spesialisasi:</p>
                            <p class="text-white">{{ $trainer->trainerProfile->specialization }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Message when no trainer profile -->
            <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-2xl p-6 mb-8">
                <div class="text-center py-8">
                    <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-300 mb-2">Profil Trainer Belum Lengkap</h3>
                    <p class="text-gray-400">Informasi detail tentang trainer ini sedang dalam proses penyempurnaan.</p>
                </div>
            </div>
        @endif

        <!-- Action Card -->
        <div class="bg-gradient-to-br from-gray-800 to-gray-900 border border-gray-700 rounded-2xl shadow-2xl p-8">
            <div class="text-center">
                <h3 class="text-2xl font-bold text-white mb-4">Mulai Perjalanan Fitness Anda</h3>
                <p class="text-gray-300 mb-6">Dapatkan bimbingan personal dari trainer profesional untuk mencapai target
                    fitness Anda</p>

                <form action="{{ route('user.training.order', $trainer->id) }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-gray-900 font-bold py-4 px-12 rounded-2xl shadow-lg transition-all duration-300 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none text-lg"
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

                @if($trainer->verification_status !== 'approved')
                    <p class="text-gray-400 text-sm mt-4">
                        Trainer ini sedang dalam proses verifikasi. Anda dapat memesan setelah trainer terverifikasi.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection