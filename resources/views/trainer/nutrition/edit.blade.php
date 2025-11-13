@extends('layouts.trainer')

@section('title', 'Edit Nutrisi & Suplemen')

@section('content')
    {{-- ✅ Flash Notification --}}
    @if(session('success') || session('error'))
        <div id="flash-message"
             class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-lg text-white shadow-lg
                 {{ session('success') ? 'bg-emerald-600/90' : 'bg-red-600/90' }}">
            {{ session('success') ?? session('error') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('flash-message')?.remove(), 3000);
        </script>
    @endif

    {{-- 🧊 Panel Transparan Glassmorphism --}}
    <div class="bg-black/60 backdrop-blur-xl border border-gray-700/40 shadow-inner sm:rounded-xl p-6 md:p-8 space-y-8">

        {{-- 🧠 Header --}}
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <h1 class="font-serif text-3xl font-bold text-white tracking-wide">
                ✏️ Edit Nutrisi — <span class="bg-gradient-to-r from-emerald-400 to-cyan-400 bg-clip-text text-transparent">
                    {{ $member->name }}
                </span>
            </h1>
            <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $member->id]) }}"
               class="text-sm text-gray-400 hover:text-emerald-400 transition-all">
                ⬅️ Kembali ke Daftar
            </a>
        </div>

        {{-- 🍱 Edit Nutrition Form --}}
        <div class="bg-gray-900/50 border border-gray-700/40 rounded-lg p-6 shadow-md shadow-emerald-500/10">
            <h2 class="font-serif text-2xl font-bold text-white mb-4">
                🍱 Ubah Rencana <span class="text-emerald-400">Nutrisi</span>
            </h2>

            <form action="{{ route('trainer.programs.nutrition.update', ['memberId' => $member->id]) }}"
                  method="POST" class="space-y-4">
                @csrf

                {{-- Input Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                    <div>
                        <label for="meal_name" class="block text-sm font-medium text-gray-300">Nama Menu / Makanan</label>
                        <input type="text" name="meal_name" id="meal_name" value="{{ old('meal_name', $nutritionPlan->meal_name ?? '') }}"
                            placeholder="Misal: Dada Ayam & Nasi Merah"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-emerald-400 focus:ring-emerald-400 placeholder-gray-500">
                    </div>
                    <div>
                        <label for="target_fitness" class="block text-sm font-medium text-gray-300">Target Fitness</label>
                        <input type="text" name="target_fitness" id="target_fitness" value="{{ old('target_fitness', $nutritionPlan->target_fitness ?? '') }}"
                            placeholder="Misal: bulking, cutting, maintenance"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-cyan-400 focus:ring-cyan-400 placeholder-gray-500">
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-3">
                    <div>
                        <label for="calories" class="block text-sm font-medium text-cyan-400">Kalori (kcal)</label>
                        <input type="number" step="0.1" name="calories" id="calories" value="{{ old('calories', $nutritionPlan->calories ?? '') }}"
                            placeholder="2500"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-cyan-400 focus:ring-cyan-400">
                    </div>
                    <div>
                        <label for="protein" class="block text-sm font-medium text-emerald-400">Protein (g)</label>
                        <input type="number" step="0.1" name="protein" id="protein" value="{{ old('protein', $nutritionPlan->protein ?? '') }}"
                            placeholder="150"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-emerald-400 focus:ring-emerald-400">
                    </div>
                    <div>
                        <label for="carbs" class="block text-sm font-medium text-pink-400">Karbohidrat (g)</label>
                        <input type="number" step="0.1" name="carbs" id="carbs" value="{{ old('carbs', $nutritionPlan->carbs ?? '') }}"
                            placeholder="200"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-pink-400 focus:ring-pink-400">
                    </div>
                    <div>
                        <label for="fat" class="block text-sm font-medium text-red-400">Lemak (g)</label>
                        <input type="number" step="0.1" name="fat" id="fat" value="{{ old('fat', $nutritionPlan->fat ?? '') }}"
                            placeholder="60"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-red-400 focus:ring-red-400">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-md text-sm font-bold text-black bg-gradient-to-r from-emerald-400 to-cyan-400 hover:from-emerald-300 hover:to-cyan-300 transition-all shadow-lg shadow-emerald-500/30">
                        💾 Simpan Nutrisi
                    </button>
                </div>
            </form>
        </div>

        {{-- 💊 Tambah Suplemen Baru --}}
        <div class="bg-gray-900/50 border border-gray-700/40 rounded-lg p-6 shadow-md shadow-emerald-500/10">
            <h2 class="font-serif text-2xl font-bold text-white mb-4">
                💊 Tambah <span class="text-cyan-400">Suplemen</span>
            </h2>

            <form action="{{ route('trainer.programs.nutrition.supplement.store', ['memberId' => $member->id]) }}"
                  method="POST" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Nama Suplemen</label>
                        <input type="text" name="name" id="name" placeholder="Misal: Whey Protein"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-emerald-400 focus:ring-emerald-400">
                    </div>
                    <div>
                        <label for="recommended_dose" class="block text-sm font-medium text-gray-300">Dosis</label>
                        <input type="text" name="recommended_dose" id="recommended_dose" placeholder="Misal: 1 scoop/hari"
                            class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-cyan-400 focus:ring-cyan-400">
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi / Manfaat</label>
                    <textarea name="description" id="description" placeholder="Deskripsi / manfaat suplemen..." rows="3"
                        class="mt-1 block w-full bg-gray-800/60 border border-gray-700 rounded-md text-white focus:border-emerald-400 focus:ring-emerald-400"></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-md text-sm font-bold text-black bg-gradient-to-r from-emerald-400 to-cyan-400 hover:from-emerald-300 hover:to-cyan-300 transition-all shadow-lg shadow-emerald-500/30">
                        ➕ Tambah Suplemen
                    </button>
                </div>
            </form>

            {{-- Daftar Suplemen --}}
            @if($supplements->count())
                <div class="mt-6 border-t border-gray-700/40">
                    <h3 class="font-serif text-lg font-bold text-white pt-5 mb-3">Daftar Suplemen Saat Ini</h3>
                    <ul class="divide-y divide-gray-700/40">
                        @foreach($supplements as $supplement)
                            <li class="py-4 flex justify-between items-start gap-4">
                                <div>
                                    <strong class="text-emerald-400 font-semibold text-base">{{ $supplement->name }}</strong>
                                    <p class="text-sm text-gray-300 mt-1">{{ $supplement->description }}</p>
                                    @if($supplement->recommended_dose)
                                        <p class="text-xs text-gray-400 mt-1">💧 <span class="font-medium">Dosis:</span> {{ $supplement->recommended_dose }}</p>
                                    @endif
                                </div>

                                <form action="{{ route('trainer.programs.nutrition.supplement.destroy', ['memberId' => $member->id, 'supplementId' => $supplement->id]) }}"
                                      method="POST" onsubmit="return confirm('Hapus suplemen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-500 hover:text-red-400 text-sm font-medium transition-colors whitespace-nowrap">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <p class="text-gray-400 italic text-center pt-4 border-t border-gray-700/40 mt-6">
                    Belum ada suplemen untuk member ini.
                </p>
            @endif
        </div>
    </div>
@endsection
