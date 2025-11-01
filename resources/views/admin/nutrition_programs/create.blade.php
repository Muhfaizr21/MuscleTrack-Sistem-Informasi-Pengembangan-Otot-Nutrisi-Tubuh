<x-layouts.admin>
    <x-slot name="title">
        Buat Program <span class="text-amber-400">Nutrisi Baru</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <form action="{{ route('admin.nutrition-programs.store') }}" method="POST">
            @csrf
            <div class="p-8 space-y-6">

                @if ($errors->any())
                     <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="meal_name" class="block text-sm font-medium text-amber-400">Nama Menu</label>
                        <input type="text" name="meal_name" id="meal_name" value="{{ old('meal_name') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: Dada Ayam Bakar">
                    </div>
                    <div>
                        <label for="target_fitness" class="block text-sm font-medium text-amber-400">Target Fitness</label>
                        <select name="target_fitness" id="target_fitness" required
                                class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="">-- Pilih Target --</option>
                            <option value="cutting" {{ old('target_fitness') == 'cutting' ? 'selected' : '' }}>Cutting (Defisit)</option>
                            <option value="maintenance" {{ old('target_fitness') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="bulking" {{ old('target_fitness') == 'bulking' ? 'selected' : '' }}>Bulking (Surplus)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                    <div>
                        <label for="calories" class="block text-sm font-medium text-amber-400">Kalori (kcal)</label>
                        <input type="number" step="0.1" name="calories" id="calories" value="{{ old('calories') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                     <div>
                        <label for="protein" class="block text-sm font-medium text-green-400">Protein (g)</label>
                        <input type="number" step="0.1" name="protein" id="protein" value="{{ old('protein') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="carbs" class="block text-sm font-medium text-yellow-400">Karbohidrat (g)</label>
                        <input type="number" step="0.1" name="carbs" id="carbs" value="{{ old('carbs') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="fat" class="block text-sm font-medium text-red-400">Lemak (g)</label>
                        <input type="number" step="0.1" name="fat" id="fat" value="{{ old('fat') }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="day_of_week" class="block text-sm font-medium text-amber-400">Hari</label>
                        <select name="day_of_week" id="day_of_week" required
                                class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="">-- Pilih Hari --</option>
                            @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                                <option value="{{ $day }}" {{ old('day_of_week') == $day ? 'selected' : '' }}>{{ $day }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type" class="block text-sm font-medium text-amber-400">Tipe Waktu Makan</label>
                        <select name="type" id="type" required
                                class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="">-- Pilih Tipe --</option>
                            <option value="breakfast" {{ old('type') == 'breakfast' ? 'selected' : '' }}>Sarapan</option>
                            <option value="lunch" {{ old('type') == 'lunch' ? 'selected' : '' }}>Makan Siang</option>
                            <option value="dinner" {{ old('type') == 'dinner' ? 'selected' : '' }}>Makan Malam</option>
                            <option value="snack" {{ old('type') == 'snack' ? 'selected' : '' }}>Cemilan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Program
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
