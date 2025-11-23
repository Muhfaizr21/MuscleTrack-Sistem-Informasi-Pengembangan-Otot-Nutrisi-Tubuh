@extends('layouts.trainer')

@section('title', 'Status Verifikasi & Rating')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

        {{-- 🏆 SECTION 1: STATUS VERIFIKASI TRAINER --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            🔍 Status <span class="text-gradient">Verifikasi</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Status verifikasi dan kredensial trainer Anda</p>
                    </div>
                </div>

                {{-- Status Badge --}}
                @if($verification)
                    @if($verification->status === 'approved')
                        <div class="px-6 py-3 bg-emerald-500/20 border border-emerald-500/30 rounded-xl">
                            <span class="text-emerald-400 font-bold text-lg">✅ TERVERIFIKASI</span>
                        </div>
                    @elseif($verification->status === 'rejected')
                        <div class="px-6 py-3 bg-red-500/20 border border-red-500/30 rounded-xl">
                            <span class="text-red-400 font-bold text-lg">❌ DITOLAK</span>
                        </div>
                    @else
                        <div class="px-6 py-3 bg-yellow-500/20 border border-yellow-500/30 rounded-xl">
                            <span class="text-yellow-400 font-bold text-lg">⏳ MENUNGGU</span>
                        </div>
                    @endif
                @endif
            </div>

            {{-- Content --}}
            @if($verification)
                <div class="space-y-6">
                    {{-- Status Details --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="glass rounded-2xl p-6 border border-emerald-500/10">
                            <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                                Status Pengajuan
                            </h3>
                            <p class="text-gray-300">
                                @if($verification->status === 'approved')
                                    <span class="text-emerald-400 font-semibold">✅ Disetujui</span>
                                @elseif($verification->status === 'rejected')
                                    <span class="text-red-400 font-semibold">❌ Ditolak</span>
                                @else
                                    <span class="text-yellow-400 font-semibold">⏳ Menunggu Persetujuan</span>
                                @endif
                            </p>
                        </div>

                        <div class="glass rounded-2xl p-6 border border-emerald-500/10">
                            <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal Pengajuan
                            </h3>
                            {{-- ✅ PERBAIKAN: Gunakan Carbon parse untuk format tanggal --}}
                            <p class="text-gray-300">
                                @if($verification->created_at)
                                    {{ \Carbon\Carbon::parse($verification->created_at)->format('d F Y, H:i') }}
                                @else
                                    Tanggal tidak tersedia
                                @endif
                            </p>
                        </div>
                    </div>

                    {{-- Admin Feedback --}}
                    @if($verification->admin_feedback)
                        <div class="glass rounded-2xl p-6 border border-blue-500/20">
                            <h3 class="text-white font-semibold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                                Feedback Admin
                            </h3>
                            <div class="bg-blue-500/10 rounded-xl p-4 border border-blue-500/20">
                                <p class="text-blue-400 leading-relaxed">{{ $verification->admin_feedback }}</p>
                            </div>
                        </div>
                    @endif

                    {{-- Pending Notice --}}
                    @if($verification->status === 'pending')
                        <div class="glass rounded-2xl p-6 border border-yellow-500/20">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-yellow-400 font-semibold">Menunggu Persetujuan Admin</p>
                                    <p class="text-yellow-400/70 text-sm">Pengajuan verifikasi Anda sedang dalam proses review oleh tim admin.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                {{-- Empty State --}}
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Belum Ada Pengajuan Verifikasi</h3>
                    <p class="text-emerald-400/80 mb-6">Anda belum mengajukan verifikasi sebagai trainer profesional.</p>
                    <a href="{{ route('trainer.quality.feedback.index') }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Ajukan Verifikasi Sekarang
                    </a>
                </div>
            @endif
        </div>

        {{-- ⭐ SECTION 2: RATING & ULASAN --}}
        <div class="glass-dark rounded-3xl p-8 border border-purple-500/20 shadow-2xl shadow-purple-500/10">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">⭐</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            ⭐ Rating & <span class="text-gradient">Ulasan</span>
                        </h1>
                        <p class="text-purple-400/80 text-lg mt-2">Ulasan dan penilaian dari member Anda</p>
                    </div>
                </div>

                {{-- Overall Rating --}}
                <div class="glass rounded-2xl p-6 text-center border border-purple-500/20">
                    <div class="text-3xl font-black text-white mb-1">{{ number_format($averageRating, 1) }}</div>
                    <div class="flex justify-center mb-2">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= round($averageRating) ? 'text-yellow-400' : 'text-gray-600' }} text-lg">
                                ⭐
                            </span>
                        @endfor
                    </div>
                    <div class="text-purple-400 text-sm">{{ $totalRatings }} ulasan</div>
                </div>
            </div>

            {{-- Rating Distribution --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                @foreach([5, 4, 3, 2] as $star)
                <div class="glass rounded-xl p-4 border border-purple-500/10">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= $star; $i++)
                                <span class="text-yellow-400 text-sm">⭐</span>
                            @endfor
                        </div>
                        <span class="text-white font-semibold">{{ $ratingDistribution[$star] ?? 0 }}</span>
                    </div>
                    <div class="w-full bg-gray-700 rounded-full h-2">
                        @php
                            $percentage = $totalRatings > 0 ? (($ratingDistribution[$star] ?? 0) / $totalRatings) * 100 : 0;
                        @endphp
                        <div class="bg-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Reviews List --}}
            <div class="space-y-6">
                @forelse($ratings as $rating)
                <div class="glass rounded-2xl p-6 border border-purple-500/10 hover:border-purple-500/30 transition-all duration-300 group hover:transform hover:scale-[1.02]">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">
                        {{-- User Info --}}
                        <div class="flex items-start gap-4 flex-1">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl flex items-center justify-center flex-shrink-0">
                                <span class="text-white font-bold text-sm">{{ substr($rating->user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-white font-semibold group-hover:text-purple-400 transition-colors duration-300">
                                    {{ $rating->user->name }}
                                </h3>
                                {{-- ✅ PERBAIKAN: Gunakan Carbon parse untuk format tanggal --}}
                                <p class="text-purple-400/70 text-sm mt-1">
                                    @if($rating->created_at)
                                        {{ \Carbon\Carbon::parse($rating->created_at)->format('d M Y') }}
                                    @else
                                        Tanggal tidak tersedia
                                    @endif
                                </p>

                                {{-- Comment --}}
                                @if($rating->comment)
                                <div class="mt-3 bg-purple-500/10 rounded-xl p-4 border border-purple-500/20">
                                    <p class="text-purple-400 leading-relaxed">{{ $rating->comment }}</p>
                                </div>
                                @else
                                <p class="text-gray-500 italic text-sm mt-2">Tidak ada komentar</p>
                                @endif
                            </div>
                        </div>

                        {{-- Rating Stars --}}
                        <div class="flex items-center gap-2 flex-shrink-0">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $rating->rating ? 'text-yellow-400' : 'text-gray-600' }} text-lg">
                                        ⭐
                                    </span>
                                @endfor
                            </div>
                            <span class="text-white font-bold text-lg bg-purple-500/20 px-3 py-1 rounded-full border border-purple-500/30">
                                {{ $rating->rating }}/5
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                {{-- Empty State --}}
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-purple-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-purple-500/20">
                        <span class="text-3xl">⭐</span>
                    </div>
                    <h3 class="text-xl font-bold text-white mb-2">Belum Ada Rating</h3>
                    <p class="text-purple-400/80 mb-2">Anda belum menerima rating dari member.</p>
                    <p class="text-gray-500 text-sm">Rating akan muncul di sini setelah member memberikan ulasan.</p>
                </div>
                @endforelse
            </div>

            {{-- Quick Stats --}}
            @if($totalRatings > 0)
            <div class="mt-8 pt-6 border-t border-purple-500/20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-black text-white">{{ $totalRatings }}</div>
                        <div class="text-purple-400 text-sm">Total Ulasan</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-black text-white">{{ number_format($averageRating, 1) }}</div>
                        <div class="text-purple-400 text-sm">Rating Rata-rata</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-black text-white">
                            {{ $ratingDistribution[5] ?? 0 }}
                        </div>
                        <div class="text-purple-400 text-sm">Rating 5 Bintang</div>
                    </div>
                </div>
            </div>
            @endif
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

    .glass-dark {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .glass {
        background: rgba(17, 25, 21, 0.7);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(16, 185, 129, 0.2);
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
