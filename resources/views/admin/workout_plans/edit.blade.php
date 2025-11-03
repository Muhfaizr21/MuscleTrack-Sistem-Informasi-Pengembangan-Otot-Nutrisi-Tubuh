<x-layouts.admin>
    <x-slot name="title">
        Edit Program <span class="text-amber-400">Latihan</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">

        <form id="update-plan-form" action="{{ route('admin.workout-plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
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

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-amber-400">Judul Program</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $plan->title) }}" required
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium text-amber-400">Status</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                            <option value="active" {{ old('status', $plan->status) == 'active' ? 'selected' : '' }}>Active (Tampilkan ke User)</option>
                            <option value="inactive" {{ old('status', $plan->status) == 'inactive' ? 'selected' : '' }}>Inactive (Draft)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">{{ old('description', $plan->description) }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="target_fitness" class="block text-sm font-medium text-gray-300">Target Fitness</label>
                        <input type="text" name="target_fitness" id="target_fitness" value="{{ old('target_fitness', $plan->target_fitness) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: muscle_gain">
                    </div>
                    <div>
                        <label for="focus_area" class="block text-sm font-medium text-gray-300">Fokus Area</label>
                        <input type="text" name="focus_area" id="focus_area" value="{{ old('focus_area', $plan->focus_area) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: bulking">
                    </div>
                    <div>
                        <label for="bmi_category" class="block text-sm font-medium text-gray-300">Kategori BMI</label>
                        <input type="text" name="bmi_category" id="bmi_category" value="{{ old('bmi_category', $plan->bmi_category) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: normal, overweight">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="difficulty_level" class="block text-sm font-medium text-gray-300">Level Kesulitan</label>
                        <input type="text" name="difficulty_level" id="difficulty_level" value="{{ old('difficulty_level', $plan->difficulty_level) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: beginner">
                    </div>
                    <div>
                        <label for="duration_weeks" class="block text-sm font-medium text-gray-300">Durasi (Minggu)</label>
                        <input type="number" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks', $plan->duration_weeks) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: 4">
                    </div>
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-gray-300">Durasi (Menit/sesi)</label>
                        <input type="number" name="duration_minutes" id="duration_minutes" value="{{ old('duration_minutes', $plan->duration_minutes) }}"
                               class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                               placeholder="Misal: 60">
                    </div>
                </div>
            </div>
        </form> <div class="bg-gray-900/50 px-8 py-4 flex justify-between items-center">
            <form action="{{ route('admin.workout-plans.destroy', $plan) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus program ini?');" class="m-0">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-400 text-sm font-medium">Hapus Program</button>
            </form>

            <button type="submit" form="update-plan-form"
                    class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                Simpan Perubahan
            </button>
        </div>
    </div>
</x-layouts.admin>
