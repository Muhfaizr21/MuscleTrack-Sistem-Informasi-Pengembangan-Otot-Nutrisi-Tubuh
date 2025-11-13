@extends('layouts.trainer')

@section('title', 'Nutrisi & Suplemen Member')

@section('content')

{{-- ✅ Toast Notification (Neon Emerald) --}}
@if(session('success'))
    <div id="toast-success"
         class="fixed inset-0 flex justify-center items-center bg-black/60 z-50 animate-fade-in">
        <div class="bg-emerald-600/90 text-white px-6 py-4 rounded-xl shadow-lg flex items-center space-x-3 transform transition-all scale-100 animate-pop-in border border-emerald-400/40 backdrop-blur-md">
            <span class="text-2xl">✅</span>
            <p class="text-lg font-medium">{{ session('success') }}</p>
        </div>
    </div>

    <script>
        setTimeout(() => {
            const toast = document.getElementById('toast-success');
            if (toast) {
                toast.classList.add('animate-fade-out');
                setTimeout(() => toast.remove(), 500);
            }
        }, 3000);
    </script>

    <style>
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes fadeOut { from { opacity: 1; } to { opacity: 0; } }
        @keyframes popIn { 0% { transform: scale(0.85); opacity: 0; } 100% { transform: scale(1); opacity: 1; } }
        .animate-fade-in { animation: fadeIn 0.4s ease-out forwards; }
        .animate-fade-out { animation: fadeOut 0.4s ease-in forwards; }
        .animate-pop-in { animation: popIn 0.3s ease-out forwards; }
    </style>
@endif

{{-- 🌌 Panel Utama (Glassmorphism Futuristik) --}}
<div class="bg-black/60 backdrop-blur-xl border border-gray-700/50 shadow-inner sm:rounded-2xl p-8 space-y-8">

    {{-- 🧠 Header --}}
    <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
        <h1 class="font-semibold text-3xl text-white tracking-wide drop-shadow-lg">
            🥗 Nutrisi & Suplemen —
            <span class="bg-gradient-to-r from-emerald-400 via-cyan-400 to-blue-500 text-transparent bg-clip-text font-extrabold">
                {{ $member->name }}
            </span>
        </h1>

        <a href="{{ route('trainer.programs.nutrition.edit', ['memberId' => $member->id]) }}"
           class="px-5 py-2.5 rounded-lg text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-cyan-500 hover:from-cyan-500 hover:to-emerald-400
                  shadow-[0_0_10px_rgba(0,255,200,0.4)] transition-all">
            ✏️ Edit Nutrisi
        </a>
    </div>

    {{-- 🍱 Nutrisi Plan --}}
    <div class="bg-gray-900/40 border border-gray-700/50 rounded-xl p-6 backdrop-blur-md shadow-lg">
        <h2 class="text-2xl font-bold text-white mb-5">
            🍱 Rencana <span class="text-emerald-400">Nutrisi</span>
        </h2>

        @if($nutritionPlan)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-sm">
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Menu</span>
                    <span class="text-base font-medium text-gray-100">{{ $nutritionPlan->meal_name }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Target</span>
                    <span class="text-base font-medium text-gray-100 capitalize">{{ $nutritionPlan->target_fitness }}</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Kalori</span>
                    <span class="text-base font-medium text-emerald-400">{{ $nutritionPlan->calories }} kcal</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Protein</span>
                    <span class="text-base font-medium text-cyan-400">{{ $nutritionPlan->protein }} g</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Karbohidrat</span>
                    <span class="text-base font-medium text-pink-400">{{ $nutritionPlan->carbs }} g</span>
                </div>
                <div>
                    <span class="block text-xs text-gray-400 uppercase">Lemak</span>
                    <span class="text-base font-medium text-yellow-400">{{ $nutritionPlan->fat }} g</span>
                </div>
            </div>
        @else
            <p class="text-gray-400 italic">Belum ada rencana nutrisi untuk member ini.</p>
        @endif
    </div>

    {{-- 💊 Suplemen --}}
    <div class="bg-gray-900/40 border border-gray-700/50 rounded-xl p-6 backdrop-blur-md shadow-lg">
        <h2 class="text-2xl font-bold text-white mb-5">
            💊 Rekomendasi <span class="text-emerald-400">Suplemen</span>
        </h2>

        @if($supplements->count())
            <ul class="divide-y divide-gray-700/50">
                @foreach($supplements as $supplement)
                    <li class="py-4">
                        <strong class="text-emerald-400 font-semibold drop-shadow-md">{{ $supplement->name }}</strong>
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
