@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4 flex items-center gap-2">
        ✏️ Edit Menu Nutrisi
    </h2>

    {{-- ✅ FORM UPDATE --}}
    <form action="{{ route('user.nutrition.update', $nutrition->id) }}" method="POST" class="space-y-5 mb-6">
        @csrf
        @method('PUT')

        <!-- Nama Menu -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Nama Menu</label>
            <input type="text" name="meal_name" value="{{ old('meal_name', $nutrition->meal_name) }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <!-- Kalori -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Kalori (kcal)</label>
            <input type="number" step="1" name="calories" value="{{ old('calories', $nutrition->calories) }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <!-- Protein -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Protein (gram)</label>
            <input type="number" step="0.1" name="protein" value="{{ old('protein', $nutrition->protein) }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <!-- Karbo -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Karbohidrat (gram)</label>
            <input type="number" step="0.1" name="carbs" value="{{ old('carbs', $nutrition->carbs) }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <!-- Lemak -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Lemak (gram)</label>
            <input type="number" step="0.1" name="fat" value="{{ old('fat', $nutrition->fat) }}"
                   class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
        </div>

        <!-- Hari -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Hari</label>
            <select name="day_of_week" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500" required>
                @foreach (['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                    <option value="{{ $day }}" {{ old('day_of_week', $nutrition->day_of_week) == $day ? 'selected' : '' }}>
                        {{ $day }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Jenis -->
        <div>
            <label class="block text-gray-700 font-medium mb-1">Jenis Waktu Makan</label>
            <select name="type" class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-indigo-500">
                <option value="">-- Pilih --</option>
                <option value="breakfast" {{ old('type', $nutrition->type) == 'breakfast' ? 'selected' : '' }}>Sarapan</option>
                <option value="lunch" {{ old('type', $nutrition->type) == 'lunch' ? 'selected' : '' }}>Makan Siang</option>
                <option value="dinner" {{ old('type', $nutrition->type) == 'dinner' ? 'selected' : '' }}>Makan Malam</option>
                <option value="snack" {{ old('type', $nutrition->type) == 'snack' ? 'selected' : '' }}>Cemilan</option>
            </select>
        </div>

        <!-- Tombol Update -->
        <div class="flex justify-between items-center">
            <a href="{{ route('user.nutrition.index') }}" 
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg text-gray-700">
               Kembali
            </a>

            <button type="submit" 
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg">
                Update
            </button>
        </div>
    </form>

    {{-- ✅ FORM DELETE TERPISAH --}}
    <form action="{{ route('user.nutrition.destroy', $nutrition->id) }}" method="POST" 
          onsubmit="return confirm('Yakin ingin menghapus menu ini?');" class="text-right">
        @csrf
        @method('DELETE')
        <button type="submit" 
                class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg">
            Hapus Menu Ini
        </button>
    </form>
</div>
@endsection
