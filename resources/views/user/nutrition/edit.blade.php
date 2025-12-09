@extends('layouts.user')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
                <div class="flex items-center gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center">
                        <span class="text-2xl">✏️</span>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black text-white">
                            Edit <span class="text-gradient">Menu Nutrisi</span>
                        </h1>
                        <p class="text-emerald-400/80 text-lg mt-2">Perbarui informasi menu makanan/minuman Anda</p>
                    </div>
                </div>
            </div>

            {{-- Flash Messages --}}
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

            @if ($errors->any())
                <div class="glass rounded-2xl p-4 mb-6 border border-red-500/30 bg-red-500/10">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-400" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-red-400 font-medium">Mohon periksa form untuk kesalahan:</p>
                            <ul class="text-red-400/80 text-sm mt-1 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Update Form --}}
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-6">
                <form action="{{ route('user.nutrition.update', $nutrition->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Meal Name --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-lg font-bold text-emerald-400">Nama Makanan/Minuman</label>
                            <span class="text-xs text-emerald-400/70 bg-emerald-500/10 px-2 py-1 rounded-lg">Wajib
                                diisi</span>
                        </div>
                        <p class="text-emerald-400/60 text-sm mb-3">Nama lengkap menu makanan atau minuman yang dikonsumsi
                        </p>
                        <input type="text" name="meal_name" value="{{ old('meal_name', $nutrition->meal_name) }}"
                            class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                            placeholder="Contoh: Ayam Bakar dengan Nasi Merah, Smoothie Pisang, dll." required>
                    </div>

                    {{-- Nutrition Information --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Calories --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Kalori (kcal)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Energi total</span>
                            </label>
                            <input type="number" step="1" name="calories"
                                value="{{ old('calories', $nutrition->calories) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                            <p class="text-emerald-400/60 text-xs mt-1">Jumlah energi yang terkandung dalam makanan</p>
                        </div>

                        {{-- Protein --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Protein (gram)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Membangun otot</span>
                            </label>
                            <input type="number" step="0.1" name="protein" value="{{ old('protein', $nutrition->protein) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                            <p class="text-emerald-400/60 text-xs mt-1">Nutrisi penting untuk pertumbuhan dan perbaikan
                                jaringan</p>
                        </div>

                        {{-- Carbs --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Karbohidrat (gram)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Sumber energi</span>
                            </label>
                            <input type="number" step="0.1" name="carbs" value="{{ old('carbs', $nutrition->carbs) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                            <p class="text-emerald-400/60 text-xs mt-1">Sumber energi utama untuk aktivitas sehari-hari</p>
                        </div>

                        {{-- Fat --}}
                        <div>
                            <label class="block text-sm font-bold text-emerald-400 mb-2">
                                Lemak (gram)
                                <span class="text-emerald-400/60 text-xs font-normal ml-2">Cadangan energi</span>
                            </label>
                            <input type="number" step="0.1" name="fat" value="{{ old('fat', $nutrition->fat) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-emerald-500/30 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 text-white placeholder-emerald-400/50 transition-all duration-300"
                                required>
                            <p class="text-emerald-400/60 text-xs mt-1">Nutrisi esensial untuk penyerapan vitamin dan hormon
                            </p>
                        </div>
                    </div>

                    {{-- Water Intake --}}
                    <div class="border-t border-emerald-500/20 pt-6">
                        <div>
                            <label class="block text-sm font-bold text-blue-400 mb-2">
                                Asupan Air (ml)
                                <span class="text-blue-400/60 text-xs font-normal ml-2">Hidrasi tubuh</span>
                            </label>
                            <input type="number" step="50" name="water_intake"
                                value="{{ old('water_intake', $nutrition->water_intake) }}"
                                class="w-full px-4 py-3 rounded-xl bg-black/50 border border-blue-500/30 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 text-white placeholder-blue-400/50 transition-all duration-300">
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
                                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                    <option value="{{ $day }}"
                                        {{ old('day_of_week', $nutrition->day_of_week) == $day ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-emerald-400/60 text-xs mt-1">Hari ketika makanan/minuman ini dikonsumsi</p>
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
                                <option value="breakfast"
                                    {{ old('type', $nutrition->type) == 'breakfast' ? 'selected' : '' }}>Sarapan (Pagi)
                                </option>
                                <option value="lunch" {{ old('type', $nutrition->type) == 'lunch' ? 'selected' : '' }}>Makan
                                    Siang
                                </option>
                                <option value="dinner" {{ old('type', $nutrition->type) == 'dinner' ? 'selected' : '' }}>
                                    Makan Malam
                                </option>
                                <option value="snack" {{ old('type', $nutrition->type) == 'snack' ? 'selected' : '' }}>
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

                        <div class="flex items-center gap-3">
                            <button type="submit"
                                class="group flex items-center gap-2 px-8 py-3 rounded-xl text-base font-black text-white bg-gradient-to-r from-emerald-500 to-emerald-700 hover:from-emerald-600 hover:to-emerald-800 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-emerald-500/25">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Update Menu
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Delete Form --}}
            <div class="glass-dark rounded-3xl p-8 border border-red-500/20 shadow-2xl shadow-red-500/10">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 bg-red-500/10 rounded-xl flex items-center justify-center border border-red-500/20">
                        <span class="text-xl">🗑️</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Hapus Menu Ini</h3>
                        <p class="text-red-400/80">Tindakan ini tidak dapat dibatalkan</p>
                    </div>
                </div>

                <form action="{{ route('user.nutrition.destroy', $nutrition->id) }}" method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus menu ini? Tindakan ini tidak dapat dibatalkan.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full px-6 py-3 rounded-xl text-sm font-bold text-white bg-red-500/10 hover:bg-red-500/20 border border-red-500/30 hover:border-red-500/50 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Menu Permanen
                    </button>
                </form>
            </div>

            {{-- Current Nutrition Info --}}
            <div class="glass rounded-2xl p-6 mt-8 border border-blue-500/20 bg-blue-500/10">
                <div class="flex items-center gap-4 mb-4">
                    <div
                        class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center border border-blue-500/30">
                        <span class="text-xl">📊</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-blue-400">Informasi Nutrisi Saat Ini</h3>
                        <p class="text-blue-400/80">Ringkasan data menu yang akan diedit:</p>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div class="p-3 rounded-xl bg-blue-500/5 border border-blue-500/10 text-center">
                        <p class="text-white font-bold text-lg">{{ $nutrition->calories }}<span
                                class="text-xs text-blue-400 ml-1">kcal</span></p>
                        <p class="text-blue-400/70 text-xs">Kalori</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-500/5 border border-blue-500/10 text-center">
                        <p class="text-white font-bold text-lg">{{ $nutrition->protein }}<span
                                class="text-xs text-blue-400 ml-1">g</span></p>
                        <p class="text-blue-400/70 text-xs">Protein</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-500/5 border border-blue-500/10 text-center">
                        <p class="text-white font-bold text-lg">{{ $nutrition->carbs }}<span
                                class="text-xs text-blue-400 ml-1">g</span></p>
                        <p class="text-blue-400/70 text-xs">Karbohidrat</p>
                    </div>
                    <div class="p-3 rounded-xl bg-blue-500/5 border border-blue-500/10 text-center">
                        <p class="text-white font-bold text-lg">{{ $nutrition->fat }}<span
                                class="text-xs text-blue-400 ml-1">g</span></p>
                        <p class="text-blue-400/70 text-xs">Lemak</p>
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