@extends('layouts.trainer')

@section('title', 'Status Verifikasi & Rating')

@section('content')
<div class="space-y-8">

    {{-- 🏋️ SECTION 1: STATUS VERIFIKASI TRAINER --}}
    <div class="relative max-w-6xl mx-auto p-6 md:p-8 rounded-2xl border border-emerald-400/20
        bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70
        backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)]">

        {{-- Header: Futuristik Emerald Glow --}}
        <div class="flex items-center mb-6">
            <div class="w-2 h-10 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
            <h1 class="text-3xl font-semibold text-white tracking-wide drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
                🔍 Status <span class="text-emerald-400">Verifikasi Trainer</span>
            </h1>
        </div>

        {{-- Logika Status --}}
        @if($verification)
            <div class="space-y-5 text-gray-200">
                <p class="text-lg">
                    <strong class="text-white/90">Status Pengajuan:</strong>
                    @if($verification->status === 'approved')
                        <span class="ml-2 font-semibold text-emerald-400 drop-shadow-[0_0_5px_rgba(16,185,129,0.7)]">
                            ✅ DISETUJUI
                        </span>
                    @elseif($verification->status === 'rejected')
                        <span class="ml-2 font-semibold text-pink-500 drop-shadow-[0_0_6px_rgba(236,72,153,0.7)]">
                            ❌ DITOLAK
                        </span>
                    @else
                        <span class="ml-2 font-semibold text-yellow-400 drop-shadow-[0_0_6px_rgba(250,204,21,0.7)]">
                            ⏳ MENUNGGU
                        </span>
                    @endif
                </p>

                {{-- Feedback Admin --}}
                @if($verification->admin_feedback)
                    <div class="mt-3 p-5 rounded-xl border border-emerald-500/30
                        bg-gradient-to-br from-gray-800/70 to-gray-900/50 backdrop-blur-lg
                        shadow-inner shadow-emerald-500/10">
                        <strong class="text-emerald-300">💬 Feedback Admin:</strong>
                        <p class="text-gray-300 mt-2 leading-relaxed">{{ $verification->admin_feedback }}</p>
                    </div>
                @endif

                <div class="border-t border-emerald-400/20 pt-3 text-sm text-gray-400">
                    📅 Dikirim pada: {{ $verification->created_at->format('d M Y, H:i') }}
                </div>

                @if($verification->status === 'pending')
                    <div class="text-yellow-400 animate-pulse mt-3">
                        ⏳ Menunggu persetujuan admin...
                    </div>
                @endif
            </div>

        @else
            {{-- Empty State --}}
            <div class="text-center py-8">
                <p class="text-gray-400 text-lg mb-3">
                    Anda belum mengajukan verifikasi.
                </p>
                <a href="{{ route('trainer.quality.feedback.index') }}"
                   class="inline-block px-6 py-2 rounded-full bg-gradient-to-r
                   from-emerald-500 via-emerald-400 to-green-500 text-black font-semibold
                   hover:shadow-[0_0_15px_rgba(16,185,129,0.7)] transition-all duration-300">
                    🚀 Ajukan Verifikasi Sekarang
                </a>
            </div>
        @endif
    </div>

    {{-- ⭐ SECTION 2: RATING & ULASAN --}}
    <div class="relative max-w-6xl mx-auto p-6 md:p-8 rounded-2xl border border-emerald-400/20
        bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70
        backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)]">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-2 h-10 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                <h1 class="text-3xl font-semibold text-white tracking-wide drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
                    ⭐ Rating & <span class="text-emerald-400">Ulasan</span>
                </h1>
            </div>

            {{-- Statistik Rating --}}
            <div class="text-right">
                <div class="text-2xl font-bold text-emerald-400">{{ number_format($averageRating, 1) }}/5.0</div>
                <div class="text-gray-400 text-sm">{{ $totalRatings }} ulasan</div>
            </div>
        </div>

        {{-- Ringkasan Statistik --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            @foreach([5, 4, 3, 2] as $star)
            <div class="bg-gray-800/50 rounded-lg p-4 border border-emerald-400/20">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        @for($i = 1; $i <= $star; $i++)
                            <span class="text-yellow-400">⭐</span>
                        @endfor
                    </div>
                    <span class="text-white font-semibold">{{ $ratingDistribution[$star] ?? 0 }}</span>
                </div>
                <div class="w-full bg-gray-700 rounded-full h-2 mt-2">
                    @php
                        $percentage = $totalRatings > 0 ? (($ratingDistribution[$star] ?? 0) / $totalRatings) * 100 : 0;
                    @endphp
                    <div class="bg-emerald-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Daftar Ulasan --}}
        <div class="space-y-6">
            @forelse($ratings as $rating)
            <div class="bg-gray-800/30 rounded-xl p-6 border border-emerald-400/10
                hover:border-emerald-400/30 transition-all duration-300">

                {{-- Header Ulasan --}}
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-400 to-emerald-600
                            rounded-full flex items-center justify-center text-white font-bold">
                            {{ substr($rating->user->name, 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-white font-semibold">{{ $rating->user->name }}</h3>
                            <p class="text-gray-400 text-sm">
                                {{ \Carbon\Carbon::parse($rating->created_at)->format('d M Y') }}
                            </p>
                        </div>
                    </div>

                    {{-- Rating Stars --}}
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-600' }}">
                                ⭐
                            </span>
                        @endfor
                        <span class="text-white ml-2 font-semibold">{{ $rating->rating }}/5</span>
                    </div>
                </div>

                {{-- Komentar --}}
                @if($rating->comment)
                <div class="bg-gray-900/50 rounded-lg p-4 border-l-4 border-emerald-400">
                    <p class="text-gray-200 leading-relaxed">{{ $rating->comment }}</p>
                </div>
                @else
                <p class="text-gray-500 italic">Tidak ada komentar</p>
                @endif
            </div>
            @empty
            {{-- Empty State --}}
            <div class="text-center py-12">
                <div class="text-6xl mb-4">⭐</div>
                <p class="text-gray-400 text-lg mb-6">
                    Belum ada rating untuk Anda.
                </p>
                <p class="text-gray-500">
                    Rating akan muncul di sini setelah user memberikan ulasan.
                </p>
            </div>
            @endforelse
        </div>


    </div>

</div>
@endsection
