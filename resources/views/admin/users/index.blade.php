<x-layouts.admin>
    <x-slot name="title">
        Manajemen <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">User</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Daftar <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">User & Trainer</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Kelola semua akun pengguna dalam sistem</p>
                </div>
                <a href="{{ route('admin.users.create') }}"
                   class="px-6 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah User Baru
                </a>
            </div>
        </div>

        <!-- Search & Filter Section -->
        <div class="p-6 border-b border-slate-700/50 bg-slate-800/20">
            <form method="GET" action="{{ route('admin.users.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Search Input -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Pencarian</label>
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama atau email..."
                                   class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Role Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Role</label>
                        <select name="role"
                                class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300">
                            <option value="">Semua Role</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="trainer" {{ request('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                        <select name="status"
                                class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                        </select>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3 justify-between items-center">
                    <div class="text-sm text-slate-400">
                        Menampilkan <span class="font-semibold text-green-400">{{ $users->total() }}</span> user
                        @if(request()->hasAny(['search', 'role', 'status']))
                            <span class="text-slate-500">(difilter)</span>
                        @endif
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                                class="px-6 py-2 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.707A1 1 0 013 7V4z"/>
                            </svg>
                            Terapkan Filter
                        </button>
                        <a href="{{ route('admin.users.index') }}"
                           class="px-6 py-2 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="p-4 bg-green-500/15 backdrop-blur-sm text-green-400 border-b border-green-500/20">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-500/15 backdrop-blur-sm text-red-400 border-b border-red-500/20">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        <!-- Table Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-700/50">
                <thead class="bg-slate-800/50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">User</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Data Fisik</th>
                        <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-slate-400 uppercase tracking-wider">Bergabung</th>
                        <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-slate-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/30">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-700/20 transition-colors duration-300">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500/20 to-emerald-600/20 rounded-xl flex items-center justify-center">
                                    <span class="text-sm font-semibold text-green-400">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold text-white">{{ $user->name }}</div>
                                    <div class="text-sm text-slate-400">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->role == 'admin')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-500/20 text-green-400 border border-green-500/30">
                                    {{ $user->role }}
                                </span>
                            @elseif($user->role == 'trainer')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-500/20 text-blue-400 border border-blue-500/30">
                                    {{ $user->role }}
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-slate-500/20 text-slate-400 border border-slate-500/30">
                                    {{ $user->role }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            {{ $user->age ?? '-' }} Thn, {{ $user->gender ?? '-' }} ({{ $user->weight ?? '-' }}kg / {{ $user->height ?? '-' }}cm)
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-300">
                            {{ $user->created_at->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end gap-3">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="text-green-400 hover:text-green-300 transition-colors duration-300 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Edit
                                </a>

                                @if(Auth::id() != $user->id)
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Anda yakin ingin menghapus user {{ $user->name }}?')"
                                            class="text-red-400 hover:text-red-300 transition-colors duration-300 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-500">
                                <svg class="w-12 h-12 mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                <p class="text-lg font-semibold">Tidak ada user ditemukan</p>
                                <p class="text-sm mt-1">Coba ubah filter pencarian Anda</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="p-6 border-t border-slate-700/50">
            {{ $users->links() }}
        </div>
    </div>

</x-layouts.admin>
