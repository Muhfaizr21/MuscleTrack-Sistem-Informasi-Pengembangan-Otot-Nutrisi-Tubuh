@extends('layouts.user')

@section('content')
    <div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
        <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
            ➕ Tambah Progress Baru
        </h2>

        <form action="{{ route('user.progress.store') }}" method="POST" class="space-y-5">
            @csrf

            <!-- Berat Badan -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Berat Badan (kg)</label>
                <input type="number" step="0.1" name="weight" value="{{ old('weight') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('weight') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Massa Otot -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Massa Otot (kg)</label>
                <input type="number" step="0.1" name="muscle_mass" value="{{ old('muscle_mass') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
                @error('muscle_mass') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Lemak Tubuh -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Lemak Tubuh (%)</label>
                <input type="number" step="0.1" name="body_fat" value="{{ old('body_fat') }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
                @error('body_fat') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tanggal Pencatatan -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Tanggal Pencatatan</label>
                <input type="date" name="recorded_at" value="{{ old('recorded_at', date('Y-m-d')) }}"
                    class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @error('recorded_at') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Tombol -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('user.progress.index') }}"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">Batal</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection