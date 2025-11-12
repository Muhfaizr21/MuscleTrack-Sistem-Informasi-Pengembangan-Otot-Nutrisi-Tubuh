<x-layouts.admin>
    <x-slot name="title">
        Tambah <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">User Baru</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden">

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-slate-700/50">
                <h3 class="text-2xl font-bold text-white">
                    Tambah <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">User Baru</span>
                </h3>
                <p class="text-sm text-slate-400 mt-1">Isi form berikut untuk menambahkan user baru ke sistem</p>
            </div>

            <!-- Form Content -->
            <div class="p-8 space-y-8">

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 p-4 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <strong>Perhatian!</strong>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Basic Information Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Informasi Dasar
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Masukkan nama lengkap">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                            <div class="relative">
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="email@example.com">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Password Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Keamanan Akun
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                            <div class="relative">
                                <input type="password" name="password" id="password" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Minimal 8 karakter">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" id="password_confirmation" required
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Ulangi password">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                                    <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Role & Profile Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Role & Profil
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Role -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-slate-300 mb-2">Role</label>
                            <select name="role" id="role"
                                    class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300">
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Trainer</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-slate-300 mb-2">Gender</label>
                            <select name="gender" id="gender"
                                    class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300">
                                <option value="">Pilih Gender...</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Physical Data Section -->
                <div>
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Data Fisik (Opsional)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <!-- Age -->
                        <div>
                            <label for="age" class="block text-sm font-medium text-slate-300 mb-2">Usia</label>
                            <div class="relative">
                                <input type="number" name="age" id="age" value="{{ old('age') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="Tahun">
                            </div>
                        </div>

                        <!-- Weight -->
                        <div>
                            <label for="weight" class="block text-sm font-medium text-slate-300 mb-2">Berat Badan</label>
                            <div class="relative">
                                <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pr-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="kg">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-sm text-slate-500">kg</span>
                                </div>
                            </div>
                        </div>

                        <!-- Height -->
                        <div>
                            <label for="height" class="block text-sm font-medium text-slate-300 mb-2">Tinggi Badan</label>
                            <div class="relative">
                                <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}"
                                       class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pr-10 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                       placeholder="cm">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                                    <span class="text-sm text-slate-500">cm</span>
                                </div>
                            </div>
                        </div>

                        <!-- Goal ID -->
                        <div>
                            <label for="goal_id" class="block text-sm font-medium text-slate-300 mb-2">Goal ID</label>
                            <input type="number" name="goal_id" id="goal_id" value="{{ old('goal_id') }}"
                                   class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 text-slate-200 placeholder-slate-500 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300"
                                   placeholder="ID Goal">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-slate-800/50 px-8 py-6 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <a href="{{ route('admin.users.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali ke Daftar User
                    </a>
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan User Baru
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.admin>
