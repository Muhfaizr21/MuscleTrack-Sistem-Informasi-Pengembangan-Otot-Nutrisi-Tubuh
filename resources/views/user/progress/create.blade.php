@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-xl mx-auto">

        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            ➕ Tambah <span class="text-amber-400">Progress Baru</span>
        </h2>

        <form action="{{ route('user.progress.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Berat Badan (kg)</label>
                <input type="number" step="0.1" name="weight" value="{{ old('weight') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('weight') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Massa Otot (kg)</label>
                <input type="number" step="0.1" name="muscle_mass" value="{{ old('muscle_mass') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                @error('muscle_mass') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-300 mb-1">Lemak Tubuh (%)</label>
                <input type="number" step="0.1" name="body_fat" value="{{ old('body_fat') }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                @error('body_fat') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Tanggal Pencatatan</label>
                <input type="date" name="recorded_at" value="{{ old('recorded_at', date('Y-m-d')) }}"
                    class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                           focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                @error('recorded_at') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex justify-end gap-3 pt-3">
                <a href="{{ route('user.progress.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">Batal</a>
                <button type="submit" class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
