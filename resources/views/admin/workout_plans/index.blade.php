<x-layouts.admin>
    <x-slot name="title">
        Program <span class="text-amber-400">Latihan</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white">
                    Master Program <span class="text-amber-400">Latihan</span>
                </h3>
                <p class="text-sm text-gray-400 mt-1">Template program latihan untuk user.</p>
            </div>
            <a href="{{ route('admin.workout-plans.create') }}" class="px-4 py-2 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                Buat Program Baru
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Judul Program</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Target</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fokus</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Level</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Durasi</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($plans as $plan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $plan->title }}</div>
                            <div class="text-sm text-gray-500">{{ Str::limit($plan->description, 30) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 capitalize">{{ $plan->target_fitness ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 capitalize">{{ $plan->focus_area ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300 capitalize">{{ $plan->difficulty_level ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">{{ $plan->duration_weeks ?? '-' }} Minggu</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($plan->status == 'active')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-300">Active</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-500/20 text-gray-300">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.workout-plans.edit', $plan) }}" class="text-amber-400 hover:text-amber-300">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            Belum ada program latihan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-gray-700/50">
            {{ $plans->links() }}
        </div>
    </div>
</x-layouts.admin>
