@extends('layouts.user')

@section('content')
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 max-w-xl mx-auto">

        <h2 class="font-serif text-2xl font-bold text-white mb-6 flex items-center gap-2">
            ✏️ Edit Menu <span class="text-amber-400">Nutrisi</span>
        </h2>

        {{-- ✅ Flash Error --}}
        @if ($errors->any())
            <div class="bg-red-500/20 border border-red-500/50 text-red-300 px-4 py-3 rounded-lg mb-4">
                ⚠️ Ada kesalahan input: periksa kembali.
            </div>
        @endif

        {{-- ✅ FORM UPDATE --}}
        <form action="{{ route('user.nutrition.update', $nutrition->id) }}" method="POST" class="space-y-5 mb-6">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Nama Menu</label>
                <input type="text" name="meal_name" value="{{ old('meal_name', $nutrition->meal_name) }}" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                  focus:border-amber-400 focus:ring focus:ring-amber-400/30" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-amber-400 mb-1">Kalori (kcal)</label>
                    <input type="number" name="calories" value="{{ old('calories', $nutrition->calories) }}" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                      focus:border-amber-400 focus:ring focus:ring-amber-400/30" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-amber-400 mb-1">Protein (g)</label>
                    <input type="number" step="0.1" name="protein" value="{{ old('protein', $nutrition->protein) }}" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                      focus:border-amber-400 focus:ring focus:ring-amber-400/30" required>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-amber-400 mb-1">Karbohidrat (g)</label>
                    <input type="number" step="0.1" name="carbs" value="{{ old('carbs', $nutrition->carbs) }}" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                      focus:border-amber-400 focus:ring focus:ring-amber-400/30" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-amber-400 mb-1">Lemak (g)</label>
                    <input type="number" step="0.1" name="fat" value="{{ old('fat', $nutrition->fat) }}" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                      focus:border-amber-400 focus:ring focus:ring-amber-400/30" required>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Hari</label>
                <select name="day_of_week" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                   focus:border-amber-400 focus:ring focus:ring-amber-400/30" required>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <option value="{{ $day }}" {{ old('day_of_week', $nutrition->day_of_week) == $day ? 'selected' : '' }}>
                            {{ $day }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Jenis Waktu Makan</label>
                <select name="type" class="w-full bg-gray-800 border-gray-700 rounded-md text-white px-3 py-2
                                   focus:border-amber-400 focus:ring focus:ring-amber-400/30">
                    <option value="">-- Pilih --</option>
                    <option value="breakfast" {{ old('type', $nutrition->type) == 'breakfast' ? 'selected' : '' }}>Sarapan
                    </option>
                    <option value="lunch" {{ old('type', $nutrition->type) == 'lunch' ? 'selected' : '' }}>Makan Siang
                    </option>
                    <option value="dinner" {{ old('type', $nutrition->type) == 'dinner' ? 'selected' : '' }}>Makan Malam
                    </option>
                    <option value="snack" {{ old('type', $nutrition->type) == 'snack' ? 'selected' : '' }}>Cemilan</option>
                </select>
            </div>

            <div class="flex justify-between items-center pt-3">
                <a href="{{ route('user.nutrition.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                    Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Update
                </button>
            </div>
        </form>

        {{-- ✅ FORM DELETE --}}
        <div class="border-t border-gray-700/50 pt-5">
            <form action="{{ route('user.nutrition.destroy', $nutrition->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus menu ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full bg-transparent hover:bg-red-900/50 border border-red-500 text-red-400 hover:text-red-300 py-2 rounded-lg font-medium transition-all">
                    🗑️ Hapus Menu Ini
                </button>
            </form>
        </div>
    </div>
@endsection