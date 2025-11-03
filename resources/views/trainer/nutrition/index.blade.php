@extends('layouts.trainer')

@section('title', 'Nutrisi & Suplemen Member')

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

{{-- ✅ Panel Kaca "Liar" (Menggantikan bg-white) --}}
<div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 md:p-8 space-y-6">

    {{-- 🏋️ Header (Style "Dark Premium") --}}
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <h1 class="font-serif text-3xl font-bold text-white">
            🥗 Nutrisi & Suplemen — <span class="text-amber-400">{{ $member->name }}</span>
        </h1>
        {{-- Tombol (Style "Ciamik") --}}
        <a href="{{ route('trainer.programs.nutrition.edit', ['memberId' => $member->id]) }}"
           class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300
                  transition-all shadow-lg shadow-amber-500/20 text-center">
            ✏️ Edit Nutrisi
        </a>
    </div>

    {{-- 🍱 Nutrisi (Sub-Panel "Dark Premium") --}}
    <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-6">
        <h2 class="font-serif text-2xl font-bold text-white mb-4">
            🍱 Rencana <span class="text-amber-400">Nutrisi</span>
        </h2>

        @if($nutritionPlan)
            {{-- Tampilan data "Ciamik" menggunakan grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Menu</span>
                    <span class="text-base font-medium text-gray-200">{{ $nutritionPlan->meal_name }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Target</span>
                    <span class="text-base font-medium text-gray-200 capitalize">{{ $nutritionPlan->target_fitness }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Kalori</span>
                    <span class="text-base font-medium text-amber-400">{{ $nutritionPlan->calories }} kcal</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Protein</span>
                    <span class="text-base font-medium text-green-400">{{ $nutritionPlan->protein }} g</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Karbohidrat</span>
                    <span class="text-base font-medium text-yellow-400">{{ $nutritionPlan->carbs }} g</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Lemak</span>
                    <span class="text-base font-medium text-red-400">{{ $nutritionPlan->fat }} g</span>
                </div>
            </div>
        @else
            <p class="text-gray-400 italic">Belum ada rencana nutrisi untuk member ini.</p>
        @endif
    </div>

    {{-- 💊 Suplemen (Sub-Panel "Dark Premium") --}}
    <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-6">
        <h2 class="font-serif text-2xl font-bold text-white mb-4">
            💊 Rekomendasi <span class="text-amber-400">Suplemen</span>
        </h2>

        @if($supplements->count())
            <ul class="divide-y divide-gray-700/50">
                @foreach($supplements as $supplement)
                    <li class="py-4">
                        <strong class="text-amber-400 font-semibold">{{ $supplement->name }}</strong>
                        <p class="text-sm text-gray-300 mt-1">{{ $supplement->description }}</p>
                        @if($supplement->recommended_dose)
                            <p class="text-xs text-gray-400 mt-1">💧 <span class="font-medium">Dosis:</span> {{ $supplement->recommended_dose }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-400 italic">Belum ada rekomendasi suplemen.</p>
        @endif
    </div>

</div>
@endsection
