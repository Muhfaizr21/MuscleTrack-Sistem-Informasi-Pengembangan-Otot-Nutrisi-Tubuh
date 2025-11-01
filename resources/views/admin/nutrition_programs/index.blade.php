<x-layouts.admin>
    <x-slot name="title">
        Program <span class="text-amber-400">Nutrisi</span>
    </x-slot>

    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 border-b border-gray-700/50 flex justify-between items-center">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white">
                    Program <span class="text-amber-400">Nutrisi</span> (Templates)
                </h3>
                <p class="text-sm text-gray-400 mt-1">Template program (menu) yang bisa dilihat oleh user.</p>
            </div>
            <a href="{{ route('admin.nutrition-programs.create') }}" class="px-4 py-2 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all">
                Buat Menu Baru
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
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Nama Menu</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Target</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Kalori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Protein</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Hari / Tipe</th>
                        <th scope="col" class="relative px-6 py-3"><span class="sr-only">Edit</span></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($programs as $plan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-white">{{ $plan->meal_name }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500/20 text-blue-300 uppercase">
                                {{ $plan->target_fitness ?? 'UMUM' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-amber-400 font-semibold">{{ $plan->calories }} kcal</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-400">{{ $plan->protein }} g</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-white">{{ $plan->day_of_week }}</div>
                            <div class="text-sm text-gray-500 capitalize">{{ $plan->type }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('admin.nutrition-programs.edit', $plan) }}" class="text-amber-400 hover:text-amber-300">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada program nutrisi (template).
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-6 border-t border-gray-700/50">
            {{ $programs->links() }}
        </div>
    </div>
</x-layouts.admin>
