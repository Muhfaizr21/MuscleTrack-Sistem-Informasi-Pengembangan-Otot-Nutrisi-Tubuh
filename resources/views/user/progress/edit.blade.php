@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-xl mx-auto space-y-8">

        <div>
            <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
                ✏️ Edit <span class="text-amber-400">Progress</span>
            </h2>

            {{-- ✅ Form Update (Sistem Anda aman) --}}
            <form action="{{ route('user.progress.update', $progress->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-amber-400 mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="weight" value="{{ old('weight', $progress->weight) }}"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Massa Otot (kg)</label>
                    <input type="number" step="0.1" name="muscle_mass"
                        value="{{ old('muscle_mass', $progress->muscle_mass) }}"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Lemak Tubuh (%)</label>
                    <input type="number" step="0.1" name="body_fat" value="{{ old('body_fat', $progress->body_fat) }}"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Tanggal Pencatatan</label>
                    <input type="date" name="recorded_at"
                        value="{{ old('recorded_at', optional($progress->recorded_at)->format('Y-m-d')) }}"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                </div>

                <div class="flex justify-end gap-3 pt-3">
                    <a href="{{ route('user.progress.index') }}"
                        class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                        Kembali
                    </a>
                    <button type="submit" class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                        Update
                    </button>
                </div>
            </form>
        </div>

        {{-- ✅ Form Hapus (Style "Dark Premium") --}}
        <div class="border-t border-gray-700/50 pt-5">
            <form action="{{ route('user.progress.destroy', $progress->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus progress ini?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="w-full bg-transparent hover:bg-red-900/50 border border-red-500 text-red-400 hover:text-red-300 py-2 rounded-lg font-medium transition-all">
                    🗑️ Hapus Progress Ini
                </button>
            </form>
        </div>
    </div>
@endsection
