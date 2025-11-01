@extends('layouts.trainer')

@section('title', 'Edit Nutrisi & Suplemen')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-8 space-y-10 relative">

    {{-- ✅ Flash Notification --}}
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

    {{-- Header --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">
            ✏️ Edit Nutrisi & Suplemen — {{ $member->name }}
        </h1>
        <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $member->id]) }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm px-4 py-2 rounded-lg transition">
            ⬅️ Kembali ke Daftar
        </a>
    </div>

    {{-- 🍱 Edit Nutrition Form --}}
    <div class="border border-green-200 bg-green-50 p-6 rounded-xl shadow-sm">
        <h2 class="text-xl font-semibold text-green-700 mb-4">🍱 Ubah Rencana Nutrisi</h2>

        <form action="{{ route('trainer.programs.nutrition.update', ['memberId' => $member->id]) }}"
              method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="meal_name" value="{{ old('meal_name', $nutritionPlan->meal_name ?? '') }}"
                    placeholder="Nama Menu / Makanan"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-green-400">
                <input type="number" name="calories" value="{{ old('calories', $nutritionPlan->calories ?? '') }}"
                    placeholder="Kalori (kcal)"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-green-400">
                <input type="number" name="protein" value="{{ old('protein', $nutritionPlan->protein ?? '') }}"
                    placeholder="Protein (g)"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-green-400">
                <input type="number" name="carbs" value="{{ old('carbs', $nutritionPlan->carbs ?? '') }}"
                    placeholder="Karbohidrat (g)"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-green-400">
                <input type="number" name="fat" value="{{ old('fat', $nutritionPlan->fat ?? '') }}"
                    placeholder="Lemak (g)"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-green-400">
                <input type="text" name="target_fitness" value="{{ old('target_fitness', $nutritionPlan->target_fitness ?? '') }}"
                    placeholder="Target Fitness (Bulking, Cutting, dll)"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-green-400">
            </div>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-green-600 hover:bg-green-700 text-white font-medium px-6 py-2 rounded-lg transition">
                    💾 Simpan Perubahan Nutrisi
                </button>
            </div>
        </form>
    </div>

    {{-- 💊 Tambah Suplemen Baru --}}
    <div class="border border-purple-200 bg-purple-50 p-6 rounded-xl shadow-sm">
        <h2 class="text-xl font-semibold text-purple-700 mb-4">💊 Tambah / Edit Suplemen</h2>

        <form action="{{ route('trainer.programs.nutrition.supplement.store', ['memberId' => $member->id]) }}"
              method="POST" class="space-y-3">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input type="text" name="name" placeholder="Nama Suplemen"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-purple-400">
                <input type="text" name="recommended_dose" placeholder="Dosis (misal: 1 scoop/hari)"
                    class="border p-2 rounded w-full focus:ring-2 focus:ring-purple-400">
            </div>
            <textarea name="description" placeholder="Deskripsi / manfaat suplemen..."
                class="border p-2 rounded w-full focus:ring-2 focus:ring-purple-400"></textarea>

            <div class="flex justify-end">
                <button type="submit"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-medium px-6 py-2 rounded-lg transition">
                    ➕ Tambah Suplemen
                </button>
            </div>
        </form>

        {{-- Daftar Suplemen --}}
        @if($supplements->count())
            <ul class="mt-6 divide-y divide-gray-200">
                @foreach($supplements as $supplement)
                    <li class="py-3 flex justify-between items-start">
                        <div>
                            <strong class="text-purple-700 text-lg">{{ $supplement->name }}</strong>
                            <p class="text-sm text-gray-600 mt-1">{{ $supplement->description }}</p>
                            @if($supplement->recommended_dose)
                                <p class="text-xs text-gray-500 mt-1">💧 Dosis: {{ $supplement->recommended_dose }}</p>
                            @endif
                        </div>

                        <form action="{{ route('trainer.programs.nutrition.supplement.destroy', ['memberId' => $member->id, 'supplementId' => $supplement->id]) }}"
                              method="POST" onsubmit="return confirm('Hapus suplemen ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-1.5 rounded-lg text-sm transition">
                                🗑️ Hapus
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 italic">Belum ada suplemen untuk member ini.</p>
        @endif
    </div>

</div>
@endsection
