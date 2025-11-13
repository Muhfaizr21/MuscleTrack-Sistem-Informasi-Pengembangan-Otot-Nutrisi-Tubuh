@extends('layouts.trainer')

@section('title', 'Status Verifikasi Trainer')

@section('content')
<div class="relative max-w-3xl mx-auto p-6 md:p-8 rounded-2xl border border-emerald-400/20
    bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70
    backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)]">

    {{-- 🏋️ Header: Futuristik Emerald Glow --}}
    <div class="flex items-center mb-6">
        <div class="w-2 h-10 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
        <h1 class="text-3xl font-semibold text-white tracking-wide drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
            🔍 Status <span class="text-emerald-400">Verifikasi Trainer</span>
        </h1>
    </div>

    {{-- 🌐 Logika Status --}}
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

            {{-- 📩 Feedback Admin --}}
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
        {{-- 🚫 Empty State --}}
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
@endsection
