@extends('layouts.trainer')

@section('title', 'Detail Member')

@section('content')
<div class="max-w-5xl mx-auto p-6 md:p-8 rounded-2xl border border-gray-800
    bg-gradient-to-br from-gray-950 via-gray-900 to-gray-900
    backdrop-blur-sm shadow-inner shadow-black/40">

    {{-- 📈 Header --}}
    <h1 class="text-3xl font-semibold text-gray-100 mb-6 tracking-wide">
        📈 Aktivitas Member: <span class="text-emerald-500/80">{{ $member->name }}</span>
    </h1>

    {{-- ✍️ Form Tambah Log --}}
    <div class="bg-gray-950/70 border border-gray-800 rounded-xl p-6 mb-6 shadow-inner shadow-black/30">
        <h2 class="text-xl font-semibold text-gray-100 mb-4 flex items-center gap-2">
            ✍️ Tambah <span class="text-emerald-400/80">Log Aktivitas</span>
        </h2>

        <form method="POST" action="{{ route('trainer.members.updateProgress', $member->id) }}" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="log_date" class="block text-sm font-medium text-gray-400 mb-1">Tanggal Log</label>
                    <input type="date" name="log_date" id="log_date"
                           class="mt-1 block w-full bg-gray-900 border border-gray-800 rounded-md text-gray-100
                                  focus:border-emerald-500/70 focus:ring focus:ring-emerald-600/30 focus:ring-opacity-30" required>
                </div>
                <div>
                    <label for="calories_consumed" class="block text-sm font-medium text-gray-400 mb-1">Kalori (kkal)</label>
                    <input type="number" step="0.1" name="calories_consumed" id="calories_consumed"
                           class="mt-1 block w-full bg-gray-900 border border-gray-800 rounded-md text-gray-100
                                  focus:border-emerald-500/70 focus:ring focus:ring-emerald-600/30 focus:ring-opacity-30"
                           placeholder="cth: 2500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label for="protein_consumed" class="block text-sm font-medium text-gray-400 mb-1">Protein (g)</label>
                    <input type="number" step="0.1" name="protein_consumed" id="protein_consumed"
                           class="mt-1 block w-full bg-gray-900 border border-gray-800 rounded-md text-gray-100
                                  focus:border-emerald-500/70 focus:ring focus:ring-emerald-600/30 focus:ring-opacity-30"
                           placeholder="cth: 150">
                </div>
                <div>
                    <label for="carbs_consumed" class="block text-sm font-medium text-gray-400 mb-1">Karbohidrat (g)</label>
                    <input type="number" step="0.1" name="carbs_consumed" id="carbs_consumed"
                           class="mt-1 block w-full bg-gray-900 border border-gray-800 rounded-md text-gray-100
                                  focus:border-emerald-500/70 focus:ring focus:ring-emerald-600/30 focus:ring-opacity-30"
                           placeholder="cth: 200">
                </div>
                <div>
                    <label for="fat_consumed" class="block text-sm font-medium text-gray-400 mb-1">Lemak (g)</label>
                    <input type="number" step="0.1" name="fat_consumed" id="fat_consumed"
                           class="mt-1 block w-full bg-gray-900 border border-gray-800 rounded-md text-gray-100
                                  focus:border-emerald-500/70 focus:ring focus:ring-emerald-600/30 focus:ring-opacity-30"
                           placeholder="cth: 60">
                </div>
            </div>

            <div>
                <label for="notes" class="block text-sm font-medium text-gray-400 mb-1">Catatan Tambahan</label>
                <textarea name="notes" id="notes" rows="3"
                          class="mt-1 block w-full bg-gray-900 border border-gray-800 rounded-md text-gray-100
                                 focus:border-emerald-500/70 focus:ring focus:ring-emerald-600/30 focus:ring-opacity-30"
                          placeholder="Catatan tentang progres, energi, atau kondisi fisik..."></textarea>
            </div>

            <div class="text-right pt-2">
                <button type="submit"
                        class="px-5 py-2.5 rounded-md text-sm font-semibold text-gray-100
                               bg-emerald-700/70 hover:bg-emerald-600/70 transition-all
                               shadow-inner shadow-black/30">
                    Simpan Log
                </button>
            </div>
        </form>
    </div>

    {{-- 📜 Daftar Log Aktivitas --}}
    <div class="bg-gray-950/70 border border-gray-800 rounded-xl p-6 shadow-inner shadow-black/30">
        <h2 class="text-xl font-semibold text-gray-100 mb-4">
            Log Aktivitas <span class="text-emerald-400/80">Terbaru</span>
        </h2>

        <div class="space-y-4">
            @forelse($progressLogs as $log)
                <div class="border-b border-gray-800 pb-3">
                    <p class="font-medium text-emerald-400/80">{{ $log->log_date->format('d M Y') }}</p>
                    <p class="text-gray-300 text-sm">
                        Kalori: <span class="text-gray-200">{{ $log->calories_consumed ?? '-' }}</span> |
                        Protein: <span class="text-gray-200">{{ $log->protein_consumed ?? '-' }} g</span> |
                        Karbo: <span class="text-gray-200">{{ $log->carbs_consumed ?? '-' }} g</span> |
                        Lemak: <span class="text-gray-200">{{ $log->fat_consumed ?? '-' }} g</span>
                    </p>
                    @if($log->notes)
                        <p class="text-gray-500 italic mt-1 text-sm">📝 {{ $log->notes }}</p>
                    @endif
                </div>
            @empty
                <p class="text-gray-500 italic text-center py-4">Belum ada log aktivitas.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
