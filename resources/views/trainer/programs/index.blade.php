@extends('layouts.trainer')

@section('title', 'Daftar Program Latihan Member')

@section('content')
<div class="bg-white shadow rounded-lg p-8 relative">

    {{-- ✅ Toast Notification (tengah layar) --}}
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
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
            @keyframes fadeOut {
                from { opacity: 1; }
                to { opacity: 0; }
            }
            @keyframes popIn {
                0% { transform: scale(0.8); opacity: 0; }
                100% { transform: scale(1); opacity: 1; }
            }

            .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
            .animate-fade-out { animation: fadeOut 0.4s ease-in forwards; }
            .animate-pop-in { animation: popIn 0.3s ease-out forwards; }
        </style>
    @endif

    {{-- Judul Halaman --}}
    <h1 class="text-2xl font-bold text-blue-700 mb-6 text-center">
        🏋️ Daftar Program Latihan Member
    </h1>

    {{-- Tabel daftar member --}}
    @if($members->count())
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg text-sm">
                <thead class="bg-gray-100">
                    <tr class="text-left font-semibold text-gray-700">
                        <th class="px-4 py-3 border-b">Nama Member</th>
                        <th class="px-4 py-3 border-b">Status Program</th>
                        <th class="px-4 py-3 border-b">Durasi (Minggu)</th>
                        <th class="px-4 py-3 border-b text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        @php
                            $plan = $member->workoutPlans->last() ?? null;
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 border-b font-medium text-gray-800">
                                {{ $member->name }}
                            </td>
                            <td class="px-4 py-3 border-b text-gray-600">
                                {{ $plan ? $plan->title : 'Belum ada program' }}
                            </td>
                            <td class="px-4 py-3 border-b text-gray-600">
                                {{ $plan?->duration_weeks ?? '-' }}
                            </td>
                            <td class="px-4 py-3 border-b text-center">
                                <a href="{{ route('trainer.programs.edit', ['memberId' => $member->id]) }}"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                                    ✏️ Edit Program
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500 mt-4 text-center">Belum ada member yang terdaftar di bawah bimbingan Anda.</p>
    @endif
</div>
@endsection
