<x-layouts.admin>
    <x-slot name="title">Manajemen <span class="text-amber-400">Goals</span></x-slot>
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <h3 class="font-serif text-2xl font-bold text-white">Daftar <span class="text-amber-400">Goals</span></h3>
            <a href="{{ route('admin.goals.create') }}" class="px-4 py-2 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                + Buat Goal Baru
            </a>
        </div>
        @if(session('success'))
            <div class="p-4 bg-green-500/20 text-green-300 border-b border-gray-700/50">{{ session('success') }}</div>
        @endif
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-900/50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Goal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Deskripsi</th>
                        <th class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($goals as $goal)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm font-medium text-white">{{ $goal->name }}</div></td>
                        <td class="px-6 py-4 whitespace-nowrap"><div class="text-sm text-gray-400">{{ Str::limit($goal->description, 70) }}</div></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.goals.edit', $goal) }}" class="text-amber-400 hover:text-amber-300">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada goals.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
