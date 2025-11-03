@extends('layouts.trainer')

@section('title', 'Daftar Program Latihan Member')

@section('content')

    {{-- ✅ Toast Notification (Ini sudah "ciamik" dan tidak perlu diubah) --}}
    @if(session('success'))
        <div id="toast-success"
             class="fixed inset-0 flex justify-center items-center bg-black/40 z-50 animate-fade-in">
            <div class="bg-green-500 text-white px-6 py-4 rounded-xl shadow-lg flex items-center space-x-3 transform transition-all scale-100 animate-pop-in">
                <span class="text-2xl">✅</span>
                <p class="text-lg font-medium">{{ session('success') }}</p>
            </div>
        </div>

        <script>
            // Hilangkan toast setelah 3 detik
            setTimeout(() => {
                const toast = document.getElementById('toast-success');
                if (toast) {
                    toast.classList.add('animate-fade-out');
                    setTimeout(() => toast.remove(), 500);
                }
            }, 3000);
        </script>

        {{-- Animasi sederhana dengan Tailwind + keyframes custom --}}
        <style>
            @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
            @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
            @keyframes popIn { 0% { transform: scale(0.8); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
            .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
            .animate-fade-out { animation: fadeOut 0.4s ease-in forwards; }
            .animate-pop-in { animation: popIn 0.3s ease-out forwards; }
        </style>
    @endif

    {{-- 🏋️ Header (Style "Dark Premium") --}}
    <h1 class="font-serif text-3xl font-bold text-white mb-6">
        🏋️ Program <span class="text-amber-400">Latihan Member</span>
    </h1>

    {{-- ✅ Panel Kaca "Liar" (Menggantikan bg-white) --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">

        {{-- Logika @if Anda aman --}}
        @if($members->count())
            <div class="overflow-x-auto">
                {{-- Tabel Dark Mode --}}
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-900/50">
                        <tr class="text-left font-semibold text-gray-400">
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Nama Member</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Status Program</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider">Durasi (Minggu)</th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">

                        {{-- Logika @foreach dan @php Anda aman --}}
                        @foreach($members as $member)
                            @php
                                $plan = $member->workoutPlans->last() ?? null;
                            @endphp
                            <tr class="hover:bg-gray-800/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-white">{{ $member->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $plan ? $plan->title : 'Belum ada program' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                                    {{ $plan?->duration_weeks ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    {{-- Link (Style "Dark Premium") --}}
                                    <a href="{{ route('trainer.programs.edit', ['memberId' => $member->id]) }}"
                                       class="text-amber-400 hover:text-amber-300 font-medium text-sm">
                                        ✏️ Edit Program
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            {{-- Empty State (Style "Dark Premium") --}}
            <p class="text-gray-400 italic text-center p-6">Belum ada member yang terdaftar di bawah bimbingan Anda.</p>
        @endif
    </div>
@endsection
