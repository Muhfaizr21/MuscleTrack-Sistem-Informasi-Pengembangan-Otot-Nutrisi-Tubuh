@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center">
                        <span class="text-2xl">➕</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-white">
                            Tambah <span class="text-gradient">Menu Nutrisi Baru</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Catat makanan dan minuman harian Anda</p>
                    </div>
                </div>
            </div>

            {{-- Flash Message --}}
            @if (session('success'))
                <div class="glass rounded-2xl p-4 mb-6 border border-emerald-500/30 bg-emerald-500/10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-emerald-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-emerald-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="text-emerald-400 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Form --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10">
                <form action="{{ route('user.nutrition.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Meal Name --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-lg font-bold text-emerald-400">Nama Makanan/Minuman</label>
                            <span class="text-xs text-emerald-400/70 bg-emerald-500/10 px-2 py-1 rounded-lg">Wajib
                                diisi</span>
                        </div>
                        <p class="text-emerald-400/60 text-sm mb-3">Nama lengkap menu makanan atau minuman yang dikonsumsi
                        </p>
                        <input type="text" name="meal_name" value="{{ old('meal_name') }}"
                            class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                            placeholder="Contoh: Ayam Bakar dengan Nasi Merah, Smoothie Pisang, dll." required>
                        @error('meal_name')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Nutrition Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Calories --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Kalori (kcal)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Energi total</span>
                            </label>
                            <input type="number" step="1" name="calories" value="{{ old('calories') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                placeholder="Contoh: 450" required>
                            <p class="text-emerald-400/60 text-xs mt-1">Jumlah energi yang terkandung dalam makanan</p>
                            @error('calories')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Protein --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Protein (gram)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Membangun otot</span>
                            </label>
                            <input type="number" step="0.1" name="protein" value="{{ old('protein') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                placeholder="Contoh: 35" required>
                            <p class="text-emerald-400/60 text-xs mt-1">Nutrisi penting untuk pertumbuhan dan perbaikan
                                jaringan</p>
                            @error('protein')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Carbs --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Karbohidrat (gram)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Sumber energi</span>
                            </label>
                            <input type="number" step="0.1" name="carbs" value="{{ old('carbs') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                placeholder="Contoh: 50" required>
                            <p class="text-emerald-400/60 text-xs mt-1">Sumber energi utama untuk aktivitas sehari-hari</p>
                            @error('carbs')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fat --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Lemak (gram)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Cadangan energi</span>
                            </label>
                            <input type="number" step="0.1" name="fat" value="{{ old('fat') }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                placeholder="Contoh: 15" required>
                            <p class="text-emerald-400/60 text-xs mt-1">Nutrisi esensial untuk penyerapan vitamin dan hormon
                            </p>
                            @error('fat')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Water Intake --}}
                    <div class="border-t border-emerald-500/20 pt-6">
                        <div>
                            <label class="block text-sm font-bold text-blue-400 mb-2">
                                Asupan Air (ml)
                                <span class="text-blue-400/60 text-xs font-normal ml-2">Hidrasi tubuh</span>
                            </label>
                            <input type="number" step="50" name="water_intake" value="{{ old('water_intake', 0) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-blue-500/30 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-white placeholder-blue-400/50 transition-all duration-300"
                                placeholder="Contoh: 500 (setara 2 gelas)">
                            <p class="text-blue-400/60 text-xs mt-1">Volume air yang diminum dalam mililiter (opsional)</p>
                        </div>
                    </div>

                    {{-- Day and Type --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        {{-- Day of Week --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Hari
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Kapan dikonsumsi</span>
                            </label>
                            <select name="day_of_week"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white transition-all duration-300"
                                required>
                                <option value="">Pilih Hari</option>
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-emerald-400/60 text-xs mt-1">Hari ketika makanan/minuman ini dikonsumsi</p>
                            @error('day_of_week')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Meal Type --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Jenis Makanan
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Kategori</span>
                            </label>
                            <select name="type"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white transition-all duration-300">
                                <option value="">Pilih Jenis</option>
                                <option value="breakfast" {{ old('type') == 'breakfast' ? 'selected' : '' }}>
                                    Sarapan (Pagi)
                                </option>
                                <option value="lunch" {{ old('type') == 'lunch' ? 'selected' : '' }}>
                                    Makan Siang
                                </option>
                                <option value="dinner" {{ old('type') == 'dinner' ? 'selected' : '' }}>
                                    Makan Malam
                                </option>
                                <option value="snack" {{ old('type') == 'snack' ? 'selected' : '' }}>
                                    Cemilan
                                </option>
                            </select>
                            <p class="text-emerald-400/60 text-xs mt-1">Kategori waktu makan (opsional)</p>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex justify-between items-center pt-8 border-t border-emerald-500/20">
                        <a href="{{ route('user.nutrition.index') }}"
                            class="group flex items-center gap-2 px-6 py-3 rounded-xl text-sm font-bold text-emerald-400 hover:text-white hover:bg-emerald-500/10 transition-all duration-300 border border-emerald-500/30 hover:border-emerald-500/50">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Nutrisi
                        </a>

                        <button type="submit"
                            class="group flex items-center gap-2 px-8 py-3 rounded-xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                            </svg>
                            Simpan Menu
                        </button>
                    </div>
                </form>
            </div>

            {{-- Nutrition Info Card --}}
            <div class="glass rounded-2xl p-6 mt-8 border border-amber-500/20 bg-amber-500/10">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 bg-amber-500/20 rounded-xl flex items-center justify-center border border-amber-500/30">
                        <span class="text-xl">💡</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-amber-400">Tips Menghitung Nutrisi</h3>
                        <p class="text-amber-400/80">Gunakan panduan sederhana ini:</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                        <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                            <span class="text-amber-400 text-sm">📱</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">Aplikasi & Website</p>
                            <p class="text-amber-400/70 text-sm">MyFitnessPal, FatSecret, atau Google untuk informasi
                                nutrisi makanan</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                        <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                            <span class="text-amber-400 text-sm">🏷️</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">Label Kemasan</p>
                            <p class="text-amber-400/70 text-sm">Cek informasi gizi di kemasan makanan/minuman</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                        <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                            <span class="text-amber-400 text-sm">⚖️</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">Estimasi</p>
                            <p class="text-amber-400/70 text-sm">Perkirakan berdasarkan ukuran porsi (piring, gelas, sendok)
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-500/5 border border-amber-500/10">
                        <div class="w-6 h-6 bg-amber-500/20 rounded-lg flex items-center justify-center mt-0.5">
                            <span class="text-amber-400 text-sm">📝</span>
                        </div>
                        <div>
                            <p class="text-white font-medium">Konsistensi</p>
                            <p class="text-amber-400/70 text-sm">Lengkapi data seakurat mungkin untuk hasil terbaik</p>
                        </div>
                    </div>
                </div>
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
    </style>
@endsection