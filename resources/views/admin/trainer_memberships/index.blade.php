<x-layouts.admin>
    <x-slot name="title">
        Manajemen <span class="text-amber-400">Member Premium</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white">
                    Daftar <span class="text-amber-400">Member & Trainer</span>
                </h3>
                <p class="text-sm text-gray-400 mt-1">Daftar user yang telah ditugaskan ke trainer.</p>
            </div>
            <a href="{{ route('admin.trainer-memberships.create') }}" class="px-4 py-2 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                + Tugaskan Trainer
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama User (Member)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Assigned to (Trainer)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Tanggal Bergabung</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($memberships as $membership)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $membership->user->name ?? 'User Dihapus' }}</div>
                            <div class="text-sm text-gray-500">{{ $membership->user->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-amber-400">{{ $membership->trainer->name ?? 'Trainer Dihapus' }}</div>
                            <div class="text-sm text-gray-500">{{ $membership->trainer->email ?? '-' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            {{ $membership->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <form action="{{ route('admin.trainer-memberships.destroy', $membership) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus penugasan trainer ini?');" class="m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                            Belum ada user yang ditugaskan ke trainer.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-gray-700/50">
            {{ $memberships->links() }}
        </div>
    </div>
</x-layouts.admin>
