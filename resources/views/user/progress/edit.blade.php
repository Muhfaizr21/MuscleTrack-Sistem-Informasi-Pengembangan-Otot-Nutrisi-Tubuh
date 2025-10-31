@extends('layouts.user')

@section('content')
    <div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto space-y-8">
        <div>
            <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
                ✏️ Edit Progress
            </h2>

            {{-- ✅ Form Update --}}
            <form action="{{ route('user.progress.update', $progress->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="weight" value="{{ old('weight', $progress->weight) }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Massa Otot (kg)</label>
                    <input type="number" step="0.1" name="muscle_mass"
                        value="{{ old('muscle_mass', $progress->muscle_mass) }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Lemak Tubuh (%)</label>
                    <input type="number" step="0.1" name="body_fat" value="{{ old('body_fat', $progress->body_fat) }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Pencatatan</label>
                    <input type="date" name="recorded_at"
                        value="{{ old('recorded_at', optional($progress->recorded_at)->format('Y-m-d')) }}"
                        class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('user.progress.index') }}"
                        class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
                        Kembali
                    </a>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                        Update
                    </button>
                </div>
            </form>
        </div>

        {{-- ✅ Form Hapus (terpisah total) --}}
        <div class="border-t pt-5">
            <form action="{{ route('user.progress.destroy', $progress->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus progress ini?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg font-medium">
                    🗑️ Hapus Progress Ini
                </button>
            </form>
        </div>
    </div>
@endsection