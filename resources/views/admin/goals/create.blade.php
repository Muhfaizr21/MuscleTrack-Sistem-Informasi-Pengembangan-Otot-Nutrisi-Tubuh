<x-layouts.admin>
    <x-slot name="title">Buat <span class="text-amber-400">Goal Baru</span></x-slot>
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg max-w-2xl mx-auto">
        <form action="{{ route('admin.goals.store') }}" method="POST">
            @csrf
            <div class="p-8 space-y-6">
                @if ($errors->any())
                     <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md"><ul class="list-disc list-inside">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
                @endif
                <div>
                    <label for="name" class="block text-sm font-medium text-amber-400">Nama Goal</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400" placeholder="Misal: Bulking (Muscle Gain)">
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-300">Deskripsi (Opsional)</label>
                    <textarea name="description" id="description" rows="3"
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
                <button type="submit" class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Goal
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
