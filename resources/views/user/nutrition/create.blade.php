@extends('layouts.user')

@section('content')
    <div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
            ➕ Tambah Menu Nutrisi
        </h2>

        <form action="{{ route('user.nutrition.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Nama Menu -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Nama Menu</label>
                <input type="text" name="meal_name" value="{{ old('meal_name') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('meal_name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Kalori -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Kalori (kcal)</label>
                <input type="number" step="1" name="calories" value="{{ old('calories') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('calories') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Protein -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Protein (gram)</label>
                <input type="number" step="0.1" name="protein" value="{{ old('protein') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('protein') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Karbohidrat -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Karbohidrat (gram)</label>
                <input type="number" step="0.1" name="carbs" value="{{ old('carbs') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('carbs') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lemak -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Lemak (gram)</label>
                <input type="number" step="0.1" name="fat" value="{{ old('fat') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('fat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Hari -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Hari</label>
                <select name="day_of_week" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                    <option value="">-- Pilih Hari --</option>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
                @error('day_of_week') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Jenis Waktu Makan -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Jenis Waktu Makan</label>
                <select name="type" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- Pilih --</option>
                    <option value="breakfast">Sarapan</option>
                    <option value="lunch">Makan Siang</option>
                    <option value="dinner">Makan Malam</option>
                    <option value="snack">Cemilan</option>
                </select>
            </div>

            <div class="flex justify-between">
                <a href="{{ route('user.nutrition.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
                    Kembali
                </a>

                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                    Simpan Menu
                </button>
            </div>
        </form>
    </div>
@endsection