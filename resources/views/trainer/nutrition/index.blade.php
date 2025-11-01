@extends('layouts.trainer')

@section('title', 'Nutrisi & Suplemen Member')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-8 space-y-10 relative">

    {{-- ✅ Notifikasi --}}
    @if(session('success'))
        <div id="flash-message"
            class="fixed top-8 left-1/2 transform -translate-x-1/2 z-50 px-6 py-3 bg-green-600 text-white rounded-lg shadow-lg">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('flash-message')?.remove(), 3000);
        </script>
    @endif

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-green-700">
            🥗 Nutrisi & Suplemen — {{ $member->name }}
        </h1>
        <a href="{{ route('trainer.programs.nutrition.edit', ['memberId' => $member->id]) }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg transition">
            ✏️ Edit Nutrisi
        </a>
    </div>

    {{-- 🍱 Nutrisi --}}
    <div class="border border-green-100 bg-green-50 p-6 rounded-xl shadow-sm">
        <h2 class="text-xl font-semibold text-green-700 mb-3">🍱 Rencana Nutrisi</h2>
        @if($nutritionPlan)
            <p><strong>Menu:</strong> {{ $nutritionPlan->meal_name }}</p>
            <p><strong>Kalori:</strong> {{ $nutritionPlan->calories }} kcal</p>
            <p><strong>Protein:</strong> {{ $nutritionPlan->protein }} g</p>
            <p><strong>Karbohidrat:</strong> {{ $nutritionPlan->carbs }} g</p>
            <p><strong>Lemak:</strong> {{ $nutritionPlan->fat }} g</p>
            <p><strong>Target:</strong> {{ $nutritionPlan->target_fitness }}</p>
        @else
            <p class="text-gray-500 italic">Belum ada rencana nutrisi untuk member ini.</p>
        @endif
    </div>

    {{-- 💊 Suplemen --}}
    <div class="border border-purple-100 bg-purple-50 p-6 rounded-xl shadow-sm">
        <h2 class="text-xl font-semibold text-purple-700 mb-3">💊 Rekomendasi Suplemen</h2>
        @if($supplements->count())
            <ul class="divide-y divide-gray-200">
                @foreach($supplements as $supplement)
                    <li class="py-3">
                        <strong class="text-purple-700">{{ $supplement->name }}</strong>
                        <p class="text-sm text-gray-600">{{ $supplement->description }}</p>
                        @if($supplement->recommended_dose)
                            <p class="text-xs text-gray-500">💧 Dosis: {{ $supplement->recommended_dose }}</p>
                        @endif
                    </li>
                @endforeach
            </ul>
        @else
            <p class="text-gray-500 italic">Belum ada rekomendasi suplemen.</p>
        @endif
    </div>

</div>
@endsection
