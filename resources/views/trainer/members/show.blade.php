@extends('layouts.trainer')

@section('title', 'Detail Member')

@section('content')
    {{-- 🏋️ Header (Style "Dark Premium") --}}
    <h1 class="font-serif text-3xl font-bold text-white mb-6">
        📈 Aktivitas Member: <span class="text-amber-400">{{ $member->name }}</span>
    </h1>

    {{-- ✅ Form Tambah Log (Style "Dark Premium" "Ciamik") --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6 mb-6">
        <h2 class="font-serif text-xl font-bold text-white mb-4 flex items-center gap-2">
            ✍️ Tambah <span class="text-amber-400">Log Aktivitas</span>
        </h2>

        <form method="POST" action="{{ route('trainer.members.updateProgress', $member->id) }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="log_date" class="block text-sm font-medium text-amber-400 mb-1">Tanggal Log</label>
                    <input type="date" name="log_date" id="log_date"
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50" required>
                </div>
                <div>
                    <label for="calories_consumed" class="block text-sm font-medium text-amber-400 mb-1">Kalori (kkal)</label>
                    <input type="number" step="0.1" name="calories_consumed" id="calories_consumed"
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
                           placeholder="Misal: 2500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="protein_consumed" class="block text-sm font-medium text-green-400 mb-1">Protein (g)</label>
                    <input type="number" step="0.1" name="protein_consumed" id="protein_consumed"
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
                           placeholder="Misal: 150">
                </div>
                <div>
                    <label for="carbs_consumed" class="block text-sm font-medium text-yellow-400 mb-1">Karbohidrat (g)</label>
                    <input type="number" step="0.1" name="carbs_consumed" id="carbs_consumed"
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
                           placeholder="Misal: 200">
                </div>
                <div>
                    <label for="fat_consumed" class="block text-sm font-medium text-red-400 mb-1">Lemak (g)</label>
                    <input type="number" step="0.1" name="fat_consumed" id="fat_consumed"
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                  focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
                           placeholder="Misal: 60">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-300 mb-1">Catatan Tambahan</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                                 focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50"
                          placeholder="Catatan tentang progres, energi, dll..."></textarea>
            </div>

            <div class="text-right pt-2">
                <button type="submit"
                        class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Simpan Log
                </button>
            </div>
        </form>
    </div>

    {{-- ✅ Daftar Log Aktivitas (Style "Dark Premium") --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6">
        <h2 class="font-serif text-xl font-bold text-white mb-4">
            Log Aktivitas <span class="text-amber-400">Terbaru</span>
        </h2>

        <div class="space-y-4">
            @forelse($progressLogs as $log)
                <div class="border-b border-gray-700/50 pb-3">
                    <p class="font-medium text-amber-400">{{ $log->log_date->format('d M Y') }}</p>
                    <p class="text-gray-300 text-sm">
                        <span class="text-amber-300 font-medium">Kalori:</span> {{ $log->calories_consumed ?? '-' }} |
                        <span class="text-green-400">Protein:</span> {{ $log->protein_consumed ?? '-' }} g |
                        <span class="text-yellow-400">Karbo:</span> {{ $log->carbs_consumed ?? '-' }} g |
                        <span class="text-red-400">Lemak:</span> {{ $log->fat_consumed ?? '-' }} g
                    </p>
                    @if($log->notes)
                        <p class="text-gray-400 italic mt-1 text-sm">📝 {{ $log->notes }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-400 italic text-center py-4">Belum ada log aktivitas.</p>
            @endforelse
        </div>
    </div>
@endsection
