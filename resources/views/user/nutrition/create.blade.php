@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-xl mx-auto">

        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            ➕ Tambah Menu <span class="text-amber-400">Nutrisi</span>
        </h2>

        <form action="{{ route('user.nutrition.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Nama Menu</label>
                <input type="text" name="meal_name" value="{{ old('meal_name') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('meal_name') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Kalori (kcal)</label>
                <input type="number" step="1" name="calories" value="{{ old('calories') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('calories') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Protein (gram)</label>
                <input type="number" step="0.1" name="protein" value="{{ old('protein') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('protein') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Karbohidrat (gram)</label>
                <input type="number" step="0.1" name="carbs" value="{{ old('carbs') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('carbs') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Lemak (gram)</label>
                <input type="number" step="0.1" name="fat" value="{{ old('fat') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('fat') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Hari</label>
                <select name="day_of_week" class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                    <option value="">-- Pilih Hari --</option>

                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
                @error('day_of_week') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Jenis Waktu Makan</label>
                <select name="type" class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                    <option value="">-- Pilih --</option>
                    <option value="breakfast">Sarapan</option>
                    <option value="lunch">Makan Siang</option>
                    <option value="dinner">Makan Malam</option>
                    <option value="snack">Cemilan</option>
                </select>
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('user.nutrition.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                    Kembali
                </a>

                <button type="submit" class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>
@endsection
