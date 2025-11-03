<x-layouts.admin>
    <x-slot name="title">
        Log <span class="text-amber-400">Body Metrics</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white">
                    Log <span class="text-amber-400">Body Metrics</span>
                </h3>
                <p class="text-sm text-gray-400 mt-1">Semua catatan progres fisik dari user.</p>
            </div>
            <a href="{{ route('admin.body-metrics.create') }}" class="px-4 py-2 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                + Tambah Log
            </a>
        </div>

        @if(session('success'))
            <div class="p-4 bg-green-500/20 text-green-300 border-b border-gray-700/50">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">BB (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Otot (kg)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Lemak (%)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Foto</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($metrics as $metric)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $metric->user->name ?? 'User Dihapus' }}</div>
                            <div class="text-sm text-gray-500">{{ $metric->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $metric->recorded_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-400 font-semibold">{{ $metric->weight ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">{{ $metric->muscle_mass ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-red-400">{{ $metric->body_fat ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($metric->photo_progress)
                                <img src="{{ $metric->photo_progress_url }}" alt="Progress" class="h-10 w-10 object-cover rounded-md border border-gray-700">
                            @else
                                <span class="text-xs text-gray-600">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.body-metrics.edit', $metric) }}" class="text-amber-400 hover:text-amber-300">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada data body metric.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-gray-700/50">
            {{ $metrics->links() }}
        </div>
    </div>
</x-layouts.admin>
