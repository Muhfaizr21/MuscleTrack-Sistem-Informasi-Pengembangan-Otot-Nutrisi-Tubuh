@extends('layouts.user')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header Section --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center animate-glow">
                        <span class="text-2xl">🥗</span>
                    </div>
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-black text-white">
                            Tracker <span class="text-gradient">Nutrisi & Protein</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Pantau asupan nutrisi harian dan target protein Anda</p>
                    </div>
                </div>
                <a href="{{ route('user.nutrition.create') }}"
                    class="group relative px-8 py-4 rounded-2xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25 flex items-center gap-3">
                    <span class="text-xl">+</span>
                    Tambah Makanan
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- ✅ Info Profil Fitness --}}
        @if($fitnessProfile)
        <div class="glass-dark rounded-2xl p-6 border border-blue-500/20 shadow-xl shadow-blue-500/10 mb-8">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center border border-blue-500/20">
                    <span class="text-xl">💪</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Rekomendasi Nutrisi Personal</h3>
                    <p class="text-blue-400/80">Disesuaikan dengan level aktivitas dan target Anda</p>
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-4 text-sm">
                <div class="flex items-center gap-3 p-3 rounded-xl bg-blue-500/5 border border-blue-500/10">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <span class="text-blue-400 text-sm">⚡</span>
                    </div>
                    <div>
                        <p class="text-white font-medium">Level Aktivitas</p>
                        <p class="text-blue-400/70 capitalize">{{ $fitnessProfile->activity_level ?? 'Belum diatur' }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-blue-500/5 border border-blue-500/10">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <span class="text-blue-400 text-sm">🎯</span>
                    </div>
                    <div>
                        <p class="text-white font-medium">Target Kalori Harian</p>
                        <p class="text-blue-400/70">{{ $fitnessProfile->daily_calorie_target ?? 'Kustom' }} kcal</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 p-3 rounded-xl bg-blue-500/5 border border-blue-500/10">
                    <div class="w-8 h-8 bg-blue-500/10 rounded-lg flex items-center justify-center">
                        <span class="text-blue-400 text-sm">💧</span>
                    </div>
                    <div>
                        <p class="text-white font-medium">Kebutuhan Air</p>
                        <p class="text-blue-400/70">{{ $nutritionTargets['water_intake'] ?? 2000 }} ml/hari</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="glass rounded-2xl p-6 border border-amber-500/20 bg-amber-500/10 mb-8">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center border border-amber-500/30">
                    <span class="text-xl">📝</span>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-amber-400">Lengkapi Profil Fitness Anda</h3>
                    <p class="text-amber-400/80">Dapatkan rekomendasi nutrisi personal dengan mengatur profil fitness</p>
                </div>
                <a href="{{ route('user.profile.edit') }}" class="ml-auto px-6 py-3 rounded-xl text-sm font-bold text-amber-400 hover:text-white hover:bg-amber-500/10 transition-all duration-300 border border-amber-500/30 hover:border-amber-500/50">
                    Atur Profil
                </a>
            </div>
        </div>
        @endif

        {{-- ✅ Pesan Sukses --}}
        @if(session('success'))
            <div class="glass rounded-2xl p-4 mb-6 border border-emerald-500/30 bg-emerald-500/10">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="text-emerald-400 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- ✅ Pilih Hari --}}
        <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
            <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                </svg>
                Pilih Hari
            </h3>
            <div class="flex flex-wrap gap-2">
                @foreach ($days as $day)
                    <a href="{{ route('user.nutrition.index', ['day' => $day]) }}"
                       class="px-4 py-2 rounded-xl text-sm font-bold transition-all duration-200
                              {{ $selectedDay == $day 
                                 ? 'bg-gradient-to-r from-emerald-500 to-emerald-700 text-white shadow-lg shadow-emerald-500/25' 
                                 : 'glass text-emerald-400 hover:bg-emerald-500/10 hover:text-white border border-emerald-500/20' }}">
                        {{ $day }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ✅ Ringkasan Nutrisi --}}
        @php
            $compare = fn($actual, $target) =>
                $actual > $target ? 'text-emerald-400' :
                ($actual == $target ? 'text-amber-400' : 'text-red-400');
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Kartu Kalori --}}
            <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-emerald-400">Kalori</h3>
                    <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-emerald-400 text-lg">🔥</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-white mb-2">
                        {{ $dailyTotals['calories'] ?? 0 }}<span class="text-lg text-emerald-400 ml-1">kcal</span>
                    </p>
                    <p class="text-sm {{ $compare($dailyTotals['calories'] ?? 0, $nutritionTargets['calories'] ?? 0) }}">
                        Target: {{ $nutritionTargets['calories'] ?? 0 }} kcal
                    </p>
                    <p class="text-emerald-400/60 text-xs mt-1">Energi total dari makanan</p>
                </div>
            </div>

            {{-- Kartu Protein --}}
            <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-blue-400">Protein</h3>
                    <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-blue-400 text-lg">💪</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-white mb-2">
                        {{ $dailyTotals['protein'] ?? 0 }}<span class="text-lg text-blue-400 ml-1">g</span>
                    </p>
                    <p class="text-sm {{ $compare($dailyTotals['protein'] ?? 0, $nutritionTargets['protein'] ?? 0) }}">
                        Target: {{ $nutritionTargets['protein'] ?? 0 }} g
                    </p>
                    <p class="text-blue-400/60 text-xs mt-1">Untuk pertumbuhan otot</p>
                </div>
            </div>

            {{-- Kartu Karbohidrat --}}
            <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-amber-400">Karbohidrat</h3>
                    <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-amber-400 text-lg">🍚</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-white mb-2">
                        {{ $dailyTotals['carbs'] ?? 0 }}<span class="text-lg text-amber-400 ml-1">g</span>
                    </p>
                    <p class="text-sm {{ $compare($dailyTotals['carbs'] ?? 0, $nutritionTargets['carbs'] ?? 0) }}">
                        Target: {{ $nutritionTargets['carbs'] ?? 0 }} g
                    </p>
                    <p class="text-amber-400/60 text-xs mt-1">Sumber energi utama</p>
                </div>
            </div>

            {{-- Kartu Lemak --}}
            <div class="glass rounded-2xl p-6 border border-emerald-500/10 hover:border-emerald-500/30 transition-all duration-300 group hover-glow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-purple-400">Lemak</h3>
                    <div class="w-10 h-10 bg-purple-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-purple-400 text-lg">🥑</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-white mb-2">
                        {{ $dailyTotals['fat'] ?? 0 }}<span class="text-lg text-purple-400 ml-1">g</span>
                    </p>
                    <p class="text-sm {{ $compare($dailyTotals['fat'] ?? 0, $nutritionTargets['fat'] ?? 0) }}">
                        Target: {{ $nutritionTargets['fat'] ?? 0 }} g
                    </p>
                    <p class="text-purple-400/60 text-xs mt-1">Cadangan energi & hormon</p>
                </div>
            </div>
        </div>

        {{-- ✅ Kartu Air --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            {{-- Kartu Asupan Air --}}
            <div class="glass rounded-2xl p-6 border border-blue-500/10 hover:border-blue-500/30 transition-all duration-300 group hover-glow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-blue-400">Asupan Air</h3>
                    <div class="w-10 h-10 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-blue-400 text-lg">💧</span>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-3xl font-black text-white mb-2">
                        {{ $dailyTotals['water_intake'] ?? 0 }}<span class="text-lg text-blue-400 ml-1">ml</span>
                    </p>
                    <p class="text-sm {{ $compare($dailyTotals['water_intake'] ?? 0, $nutritionTargets['water_intake'] ?? 0) }}">
                        Target: {{ $nutritionTargets['water_intake'] ?? 0 }} ml
                    </p>
                    <p class="text-blue-400/60 text-xs mt-1">Hidrasi tubuh optimal</p>
                </div>
            </div>

            {{-- Kartu Status --}}
            <div class="glass rounded-2xl p-6 border border-amber-500/10 hover:border-amber-500/30 transition-all duration-300 group hover-glow">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-amber-400">Status Harian</h3>
                    <div class="w-10 h-10 bg-amber-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <span class="text-amber-400 text-lg">📊</span>
                    </div>
                </div>
                <div class="text-center">
                    @php
                        $targetsMet = 0;
                        $totalTargets = 5; // Kalori, Protein, Carbs, Fat, Air
                        
                        if(($dailyTotals['calories'] ?? 0) >= ($nutritionTargets['calories'] ?? 0)) $targetsMet++;
                        if(($dailyTotals['protein'] ?? 0) >= ($nutritionTargets['protein'] ?? 0)) $targetsMet++;
                        if(($dailyTotals['carbs'] ?? 0) >= ($nutritionTargets['carbs'] ?? 0)) $targetsMet++;
                        if(($dailyTotals['fat'] ?? 0) >= ($nutritionTargets['fat'] ?? 0)) $targetsMet++;
                        if(($dailyTotals['water_intake'] ?? 0) >= ($nutritionTargets['water_intake'] ?? 0)) $targetsMet++;
                        
                        $percentage = round(($targetsMet / $totalTargets) * 100);
                        $statusColor = $percentage >= 80 ? 'text-emerald-400' : ($percentage >= 60 ? 'text-amber-400' : 'text-red-400');
                    @endphp
                    
                    <p class="text-3xl font-black text-white mb-2 {{ $statusColor }}">
                        {{ $percentage }}<span class="text-lg {{ $statusColor }} ml-1">%</span>
                    </p>
                    <p class="text-sm {{ $statusColor }}">
                        {{ $targetsMet }} dari {{ $totalTargets }} target terpenuhi
                    </p>
                    <p class="text-amber-400/60 text-xs mt-1">Progress pencapaian hari ini</p>
                </div>
            </div>
        </div>

        {{-- ✅ Info Progress Terakhir --}}
        @if(!empty($latestProgress))
            <div class="glass-dark rounded-2xl p-6 border border-emerald-500/20 shadow-xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center border border-emerald-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-emerald-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Progress Terakhir</h3>
                        <p class="text-emerald-400/80">
                            <strong>{{ \Carbon\Carbon::parse($latestProgress->log_date)->translatedFormat('d F Y') }}</strong> • 
                            Kalori: <span class="text-emerald-400 font-bold">{{ $latestProgress->calories_consumed ?? 0 }} kcal</span> • 
                            Protein: <span class="text-emerald-400 font-bold">{{ $latestProgress->protein_consumed ?? 0 }} g</span>
                        </p>
                    </div>
                </div>
            </div>
        @endif

        {{-- ✅ Grafik Nutrisi --}}
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-gradient">Analisis Nutrisi</span>
                </h2>
                <div class="text-emerald-400 font-bold">
                    {{ $selectedDay }}
                </div>
            </div>

            @if($nutritions->isNotEmpty())
                <div class="h-80">
                    <canvas id="nutritionChart"></canvas>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                        <span class="text-3xl">📊</span>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Nutrisi</h3>
                    <p class="text-emerald-400/80 mb-4">Mulai catat makanan Anda untuk melihat analisis</p>
                </div>
            @endif
        </div>

        {{-- ✅ Tabel Riwayat Makan --}}
        <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 overflow-hidden mb-8">
            <div class="px-8 py-6 border-b border-emerald-500/20">
                <h2 class="text-2xl font-black text-white flex items-center gap-3">
                    <span class="text-gradient">Riwayat Makan</span>
                    <span class="text-emerald-400 text-lg">• {{ $selectedDay }}</span>
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-emerald-500/20">
                            <th class="px-8 py-4 text-left text-sm font-bold text-emerald-400 uppercase tracking-wider">Makanan/Minuman</th>
                            <th class="px-8 py-4 text-center text-sm font-bold text-emerald-400 uppercase tracking-wider">Kalori</th>
                            <th class="px-8 py-4 text-center text-sm font-bold text-emerald-400 uppercase tracking-wider">Protein</th>
                            <th class="px-8 py-4 text-center text-sm font-bold text-emerald-400 uppercase tracking-wider">Karbohidrat</th>
                            <th class="px-8 py-4 text-center text-sm font-bold text-emerald-400 uppercase tracking-wider">Lemak</th>
                            <th class="px-8 py-4 text-center text-sm font-bold text-emerald-400 uppercase tracking-wider">Air</th>
                            <th class="px-8 py-4 text-right text-sm font-bold text-emerald-400 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-emerald-500/10">
                        @forelse ($nutritions as $meal)
                            <tr class="group hover:bg-emerald-500/5 transition-all duration-300">
                                <td class="px-8 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                            @php
                                                $icon = match($meal->type) {
                                                    'breakfast' => '☕',
                                                    'lunch' => '🍽️',
                                                    'dinner' => '🌙',
                                                    'snack' => '🍎',
                                                    default => '🥗'
                                                };
                                            @endphp
                                            <span class="text-emerald-400 text-sm">{{ $icon }}</span>
                                        </div>
                                        <div>
                                            <p class="text-white font-bold">{{ $meal->meal_name }}</p>
                                            <p class="text-emerald-400/70 text-sm capitalize">
                                                @switch($meal->type)
                                                    @case('breakfast') Sarapan @break
                                                    @case('lunch') Makan Siang @break
                                                    @case('dinner') Makan Malam @break
                                                    @case('snack') Cemilan @break
                                                    @default Lainnya
                                                @endswitch
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <p class="text-xl font-black text-white">{{ $meal->calories }}<span class="text-sm text-emerald-400 ml-1">kcal</span></p>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <p class="text-lg font-bold text-white">{{ $meal->protein }}<span class="text-sm text-blue-400 ml-1">g</span></p>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <p class="text-lg font-bold text-white">{{ $meal->carbs }}<span class="text-sm text-amber-400 ml-1">g</span></p>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <p class="text-lg font-bold text-white">{{ $meal->fat }}<span class="text-sm text-purple-400 ml-1">g</span></p>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <p class="text-lg font-bold text-white">{{ $meal->water_intake ?? 0 }}<span class="text-sm text-blue-400 ml-1">ml</span></p>
                                </td>
                                <td class="px-8 py-4 text-right">
                                    <a href="{{ route('user.nutrition.edit', $meal->id) }}"
                                       class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-emerald-400 hover:text-white hover:bg-emerald-500/10 transition-all duration-300 border border-transparent hover:border-emerald-500/30 group/edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-8 py-16 text-center">
                                    <div class="w-20 h-20 bg-emerald-500/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-emerald-500/20">
                                        <span class="text-2xl">🍽️</span>
                                    </div>
                                    <h3 class="text-lg font-bold text-white mb-2">Belum Ada Data Makanan</h3>
                                    <p class="text-emerald-400/80 mb-4">Mulai catat nutrisi Anda untuk melihat riwayat di sini</p>
                                    <a href="{{ route('user.nutrition.create') }}"
                                        class="inline-flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300">
                                        Tambah Makanan Pertama
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ✅ Rekomendasi Harian --}}
        @php
            $deficit = [
                'calories' => max(0, ($nutritionTargets['calories'] ?? 0) - ($dailyTotals['calories'] ?? 0)),
                'protein'  => max(0, ($nutritionTargets['protein']  ?? 0) - ($dailyTotals['protein']  ?? 0)),
                'carbs'    => max(0, ($nutritionTargets['carbs']    ?? 0) - ($dailyTotals['carbs']    ?? 0)),
                'fat'      => max(0, ($nutritionTargets['fat']      ?? 0) - ($dailyTotals['fat']      ?? 0)),
                'water_intake' => max(0, ($nutritionTargets['water_intake'] ?? 0) - ($dailyTotals['water_intake'] ?? 0)),
            ];
        @endphp

        @if($deficit['calories'] > 0 || $deficit['water_intake'] > 0)
            <div class="glass rounded-2xl p-6 border border-amber-500/20 bg-amber-500/10 mb-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center border border-amber-500/30">
                        <span class="text-xl">🍱</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-amber-400">Rekomendasi Tambahan</h3>
                        <p class="text-amber-400/80">
                            @if($deficit['calories'] > 0)
                                Kalori Anda masih kurang {{ $deficit['calories'] }} kcal
                            @endif
                            @if($deficit['water_intake'] > 0)
                                • Asupan air kurang {{ $deficit['water_intake'] }} ml
                            @endif
                        </p>
                    </div>
                </div>
                
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @if($deficit['protein'] > 0)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                            <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                <span class="text-amber-400 text-sm">💪</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">Tambahkan Protein</p>
                                <p class="text-amber-400/70 text-sm">Dada ayam, telur rebus, tahu/tempe, atau protein whey</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($deficit['carbs'] > 0)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                            <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                <span class="text-amber-400 text-sm">🍚</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">Tambahkan Karbohidrat</p>
                                <p class="text-amber-400/70 text-sm">Nasi merah, oatmeal, kentang rebus, atau roti gandum</p>
                            </div>
                        </div>
                    @endif
                    
                    @if($deficit['fat'] > 0)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                            <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                <span class="text-amber-400 text-sm">🥑</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">Tambahkan Lemak Sehat</p>
                                <p class="text-amber-400/70 text-sm">Alpukat, almond, minyak zaitun, atau salmon</p>
                            </div>
                        </div>
                    @endif

                    @if($deficit['water_intake'] > 0)
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                            <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                                <span class="text-amber-400 text-sm">💧</span>
                            </div>
                            <div>
                                <p class="text-white font-medium">Tingkatkan Asupan Air</p>
                                <p class="text-amber-400/70 text-sm">Minum lebih banyak air putih, teh herbal, atau infused water</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @elseif($dailyTotals['calories'] > 0)
            <div class="glass rounded-2xl p-6 border border-emerald-500/20 bg-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center border border-emerald-500/30">
                        <span class="text-xl">🎉</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-emerald-400">Target Nutrisi Tercapai!</h3>
                        <p class="text-emerald-400/80">Selamat! Anda telah memenuhi semua target nutrisi hari ini.</p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

{{-- ✅ Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    const ctx = document.getElementById('nutritionChart');
    if (!ctx) return;

    // Dark theme configuration
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.borderColor = 'rgba(16, 185, 129, 0.1)';
    Chart.defaults.font.family = 'Inter, sans-serif';

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartData['labels'] ?? []),
            datasets: [{
                label: 'Asupan Harian',
                data: @json($chartData['values'] ?? []),
                backgroundColor: [
                    'rgba(16, 185, 129, 0.8)',    // Emerald - Kalori
                    'rgba(59, 130, 246, 0.8)',    // Blue - Protein
                    'rgba(245, 158, 11, 0.8)',    // Amber - Carbs
                    'rgba(139, 92, 246, 0.8)',    // Purple - Fat
                    'rgba(59, 130, 246, 0.6)'     // Light Blue - Water
                ],
                borderColor: [
                    'rgb(16, 185, 129)',
                    'rgb(59, 130, 246)',
                    'rgb(245, 158, 11)',
                    'rgb(139, 92, 246)',
                    'rgb(59, 130, 246)'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        color: '#e2e8f0',
                        font: {
                            size: 12,
                            weight: '600'
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: '#e2e8f0',
                    bodyColor: '#cbd5e1',
                    borderColor: 'rgba(16, 185, 129, 0.3)',
                    borderWidth: 1,
                    cornerRadius: 8,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                const unit = context.dataIndex === 0 ? 'kcal' : 
                                           context.dataIndex === 4 ? 'ml' : 'g';
                                label += context.parsed.y + ' ' + unit;
                            }
                            return label;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(16, 185, 129, 0.1)',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: {
                            size: 11
                        }
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: {
                            size: 11
                        }
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index'
            },
            animations: {
                tension: {
                    duration: 1000,
                    easing: 'linear'
                }
            }
        }
    });
});
</script>

<style>
    .text-gradient {
        background: linear-gradient(135deg, #10b981 0%, #34d399 50%, #6ee7b7 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .glass {
        background: rgba(10, 10, 10, 0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.2);
    }

    .glass-dark {
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .hover-glow:hover {
        box-shadow: 0 0 25px rgba(16, 185, 129, 0.4);
        transition: all 0.3s ease;
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