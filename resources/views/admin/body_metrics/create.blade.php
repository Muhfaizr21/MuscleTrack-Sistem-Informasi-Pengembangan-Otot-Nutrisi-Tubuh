<x-layouts.admin>
    <x-slot name="title">
        Tambah Log <span class="text-amber-400">Body Metric</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg max-w-4xl mx-auto">
        <form action="{{ route('admin.body-metrics.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-8 space-y-6">
                @if ($errors->any())
                     <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md"><ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-amber-400">Pilih User (Member)</label>
                        <select name="user_id" id="user_id" required
                                class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                     <div>
                        <label for="recorded_at" class="block text-sm font-medium text-amber-400">Tanggal Pencatatan</label>
                        <input type="datetime-local" name="recorded_at" id="recorded_at" value="{{ old('recorded_at', now()->format('Y-m-d\TH:i')) }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                </div>

                <div class="border-t border-gray-700/50 pt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="weight" class="block text-sm font-medium text-amber-400">Berat Badan (kg)</label>
                        <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}" class="mt-1 block w-full bg-gray-800 ...">
                    </div>
                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-300">Tinggi (cm)</label>
                        <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}" class="mt-1 block w-full bg-gray-800 ...">
                    </div>
                    <div>
                        <label for="body_fat" class="block text-sm font-medium text-red-400">Lemak Tubuh (%)</label>
                        <input type="number" step="0.1" name="body_fat" id="body_fat" value="{{ old('body_fat') }}" class="mt-1 block w-full bg-gray-800 ...">
                    </div>
                    <div>
                        <label for="muscle_mass" class="block text-sm font-medium text-green-400">Massa Otot (kg)</label>
                        <input type="number" step="0.1" name="muscle_mass" id="muscle_mass" value="{{ old('muscle_mass') }}" class="mt-1 block w-full bg-gray-800 ...">
                    </div>
                    <div>
                        <label for="waist" class="block text-sm font-medium text-gray-300">Pinggang (cm)</label>
                        <input type="number" step="0.1" name="waist" id="waist" value="{{ old('waist') }}" class="mt-1 block w-full bg-gray-800 ...">
                    </div>
                    <div>
                        <label for="arm" class="block text-sm font-medium text-gray-300">Lengan (cm)</label>
                        <input type="number" step="0.1" name="arm" id="arm" value="{{ old('arm') }}" class="mt-1 block w-full bg-gray-800 ...">
                    </div>
                </div>

                <div class="border-t border-gray-700/50 pt-6">
                    <label class="block text-sm font-medium text-gray-300">Foto Progress (Opsional)</label>
                    <input type="file" name="photo_progress" id="photo_progress" accept="image/*"
                           class="mt-2 block w-full text-sm text-gray-400
                                  file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-amber-400/20 file:text-amber-300
                                  hover:file:bg-amber-400/30">
                </div>
            </div>

            <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Log
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
