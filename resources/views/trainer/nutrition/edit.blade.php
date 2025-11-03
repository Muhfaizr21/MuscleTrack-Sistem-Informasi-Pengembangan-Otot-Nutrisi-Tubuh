@extends('layouts.trainer')

@section('title', 'Edit Nutrisi & Suplemen')

@section('content')

    {{-- ✅ Flash Notification (Ini sudah "ciamik" dan tidak perlu diubah) --}}
    @if(session('success') || session('error'))
        <div id="flash-message"
             class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 rounded-lg text-white shadow-lg
                 {{ session('success') ? 'bg-green-600' : 'bg-red-600' }}">
            {{ session('success') ?? session('error') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('flash-message')?.remove(), 3000);
        </script>
    @endif

    {{-- ✅ Panel Kaca "Liar" (Menggantikan bg-white) --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 md:p-8 space-y-8">

        {{-- 🏋️ Header (Style "Dark Premium") --}}
        <div class="flex flex-col md:flex-row justify-between md:items-center gap-4">
            <h1 class="font-serif text-3xl font-bold text-white">
                ✏️ Edit Nutrisi — <span class="text-amber-400">{{ $member->name }}</span>
            </h1>
            {{-- Tombol (Style "Ciamik") --}}
            <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $member->id]) }}"
               class="text-sm text-gray-400 hover:text-white transition-all">
                ⬅️ Kembali ke Daftar
            </a>
        </div>

        {{-- 🍱 Edit Nutrition Form (Sub-Panel "Dark Premium") --}}
        <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-6">
            <h2 class="font-serif text-2xl font-bold text-white mb-4">
                🍱 Ubah Rencana <span class="text-amber-400">Nutrisi</span>
            </h2>

            {{-- Logika Form Anda aman --}}
            <form action="{{ route('trainer.programs.nutrition.update', ['memberId' => $member->id]) }}"
                  method="POST" class="space-y-4">
                @csrf

                {{-- Input "Ciamik" --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                    <div>
                        <label for="meal_name" class="block text-sm font-medium text-gray-300">Nama Menu / Makanan</label>
                        <input type="text" name="meal_name" id="meal_name" value="{{ old('meal_name', $nutritionPlan->meal_name ?? '') }}"
                            placeholder="Misal: Dada Ayam & Nasi Merah"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="target_fitness" class="block text-sm font-medium text-gray-300">Target Fitness</label>
                        <input type="text" name="target_fitness" id="target_fitness" value="{{ old('target_fitness', $nutritionPlan->target_fitness ?? '') }}"
                            placeholder="Misal: bulking, cutting, maintenance"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-x-4 gap-y-3">
                    <div>
                        <label for="calories" class="block text-sm font-medium text-amber-400">Kalori (kcal)</label>
                        <input type="number" step="0.1" name="calories" id="calories" value="{{ old('calories', $nutritionPlan->calories ?? '') }}"
                            placeholder="2500"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                     <div>
                        <label for="protein" class="block text-sm font-medium text-green-400">Protein (g)</label>
                        <input type="number" step="0.1" name="protein" id="protein" value="{{ old('protein', $nutritionPlan->protein ?? '') }}"
                            placeholder="150"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="carbs" class="block text-sm font-medium text-yellow-400">Karbohidrat (g)</label>
                        <input type="number" step="0.1" name="carbs" id="carbs" value="{{ old('carbs', $nutritionPlan->carbs ?? '') }}"
                            placeholder="200"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="fat" class="block text-sm font-medium text-red-400">Lemak (g)</label>
                        <input type="number" step="0.1" name="fat" id="fat" value="{{ old('fat', $nutritionPlan->fat ?? '') }}"
                            placeholder="60"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                        💾 Simpan Nutrisi
                    </button>
                </div>
            </form>
        </div>

        {{-- 💊 Tambah Suplemen Baru (Sub-Panel "Dark Premium") --}}
        <div class="bg-gray-900/50 border border-gray-700/50 rounded-lg p-6">
            <h2 class="font-serif text-2xl font-bold text-white mb-4">
                💊 Tambah <span class="text-amber-400">Suplemen</span>
            </h2>

            {{-- Logika Form Anda aman --}}
            <form action="{{ route('trainer.programs.nutrition.supplement.store', ['memberId' => $member->id]) }}"
                  method="POST" class="space-y-4">
                @csrf

                {{-- Input "Ciamik" --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-3">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-300">Nama Suplemen</label>
                        <input type="text" name="name" id="name" placeholder="Misal: Whey Protein"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="recommended_dose" class="block text-sm font-medium text-gray-300">Dosis</label>
                        <input type="text" name="recommended_dose" id="recommended_dose" placeholder="Misal: 1 scoop/hari"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi / Manfaat</label>
                    <textarea name="description" id="description" placeholder="Deskripsi / manfaat suplemen..." rows="3"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"></textarea>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit"
                        class="px-6 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                        ➕ Tambah Suplemen
                    </button>
                </div>
            </form>

            {{-- Daftar Suplemen (Style "Dark Premium") --}}
            @if($supplements->count())
                <div class="mt-6 border-t border-gray-700/50">
                    <h3 class="font-serif text-lg font-bold text-white pt-5 mb-3">Daftar Suplemen Saat Ini</h3>
                    <ul class="divide-y divide-gray-700/50">
                        @foreach($supplements as $supplement)
                            <li class="py-4 flex justify-between items-start gap-4">
                                <div>
                                    <strong class="text-amber-400 font-semibold text-base">{{ $supplement->name }}</strong>
                                    <p class="text-sm text-gray-300 mt-1">{{ $supplement->description }}</p>
                                    @if($supplement->recommended_dose)
                                        <p class="text-xs text-gray-400 mt-1">💧 <span class="font-medium">Dosis:</span> {{ $supplement->recommended_dose }}</p>
                                    @endif
                                </div>

                                {{-- Tombol Hapus "Ciamik" --}}
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
                <p class="text-gray-400 italic text-center pt-4 border-t border-gray-700/50 mt-6">
                    Belum ada suplemen untuk member ini.
                </p>
            @endif
        </div>

    </div>
@endsection
