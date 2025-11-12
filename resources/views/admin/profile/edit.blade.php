<x-layouts.admin>
    <x-slot name="title">
        Profil <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Saya</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-2xl mx-auto">

        <!-- Header -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Profil <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Saya</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Kelola informasi profil dan kata sandi Anda</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-8">

                @if(session('success'))
                    <div class="p-4 bg-green-500/15 backdrop-blur-sm text-green-400 border border-green-500/20 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <!-- Informasi Dasar -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Dasar
                    </h4>

                    <div class="space-y-6">
                        <!-- Nama -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-green-400 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400 transition-all duration-300">
                            @error('name')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-emerald-400 mb-2">Alamat Email</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400 transition-all duration-300">
                            @error('email')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Ubah Password -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Ubah Password
                    </h4>

                    <div class="space-y-6">
                        <!-- Password Saat Ini -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-blue-400 mb-2">Password Saat Ini</label>
                            <input type="password" name="current_password" id="current_password"
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-300">
                            @error('current_password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password Baru -->
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-cyan-400 mb-2">Password Baru</label>
                            <input type="password" name="new_password" id="new_password"
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-400 transition-all duration-300">
                            @error('new_password')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-purple-400 mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-400 transition-all duration-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 px-6 py-4 flex justify-end border-t border-slate-700/30">
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
