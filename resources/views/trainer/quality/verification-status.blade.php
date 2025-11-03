@extends('layouts.trainer')

@section('title', 'Status Verifikasi Trainer')

@section('content')

    {{-- ✅ Panel Kaca "Liar" (Menggantikan bg-white) --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 md:p-8 max-w-3xl mx-auto">

        {{-- 🏋️ Header (Style "Dark Premium") --}}
        <h1 class="font-serif text-3xl font-bold text-white mb-6">
            🔍 Status <span class="text-amber-400">Verifikasi Trainer</span>
        </h1>

        {{-- Logika @if Anda aman --}}
        @if($verification)
            <div class="space-y-4">
                <p class="text-lg text-gray-300">
                    <strong>Status Pengajuan:</strong>

                    {{-- Status "Ciamik" --}}
                    @if($verification->status === 'approved')
                        <span class="font-bold text-green-400 ml-2">✅ DISETUJUI</span>
                    @elseif($verification->status === 'rejected')
                        <span class="font-bold text-red-400 ml-2">❌ DITOLAK</span>
                    @else
                        <span class="font-bold text-yellow-400 ml-2">⏳ MENUNGGU</span>
                    @endif
                </p>

                {{-- Feedback Admin (Style "Dark Premium") --}}
                @if($verification->admin_feedback)
                    <div class="mt-3 p-4 bg-gray-900/50 border border-gray-700/50 rounded-lg">
                        <strong class="text-amber-400">Feedback Admin:</strong>
                        <p class="text-gray-300 mt-1">{{ $verification->admin_feedback }}</p>
                    </div>
                @endif

                <p class="text-sm text-gray-400 pt-2 border-t border-gray-700/50">
                    Dikirim pada: {{ $verification->created_at->format('d M Y, H:i') }}
                </p>

                @if($verification->status === 'pending')
                    <p class="mt-4 text-yellow-400">⏳ Menunggu persetujuan admin...</p>
                @endif
            </div>

        @else
            {{-- Empty State (Style "Dark Premium") --}}
            <p class="text-gray-400">Anda belum mengajukan verifikasi.</p>
            <a href="{{ route('trainer.quality.feedback.index') }}"
               class="text-amber-400 hover:text-amber-300 hover:underline mt-2 inline-block">
                Klik di sini untuk mengajukan verifikasi.
            </a>
        @endif
    </div>
@endsection
