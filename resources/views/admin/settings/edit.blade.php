<x-layouts.admin>
    <x-slot name="title">
        <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Pengaturan</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-2xl mx-auto">

        <!-- Header -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Pengaturan</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Sesuaikan preferensi sistem Anda</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <form action="{{ route('admin.settings.update') }}" method="POST">
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

                <!-- Tampilan -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                        Tampilan
                    </h4>

                    <div class="space-y-6">
                        <!-- Tema -->
                        <div>
                            <label class="block text-sm font-medium text-purple-400 mb-3">Tema</label>
                            <div class="grid grid-cols-3 gap-4">
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="theme" value="light" class="sr-only" {{ ($user->settings['theme'] ?? 'dark') == 'light' ? 'checked' : '' }}>
                                    <div class="bg-slate-800/50 border-2 border-slate-600 rounded-xl p-4 text-center transition-all hover:border-purple-400 peer-checked:border-purple-400 peer-checked:bg-purple-500/10">
                                        <div class="w-8 h-8 bg-yellow-400 rounded-full mx-auto mb-2"></div>
                                        <span class="text-sm text-slate-300">Terang</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="theme" value="dark" class="sr-only" {{ ($user->settings['theme'] ?? 'dark') == 'dark' ? 'checked' : '' }}>
                                    <div class="bg-slate-800/50 border-2 border-slate-600 rounded-xl p-4 text-center transition-all hover:border-purple-400 peer-checked:border-purple-400 peer-checked:bg-purple-500/10">
                                        <div class="w-8 h-8 bg-slate-600 rounded-full mx-auto mb-2"></div>
                                        <span class="text-sm text-slate-300">Gelap</span>
                                    </div>
                                </label>
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="theme" value="system" class="sr-only" {{ ($user->settings['theme'] ?? 'dark') == 'system' ? 'checked' : '' }}>
                                    <div class="bg-slate-800/50 border-2 border-slate-600 rounded-xl p-4 text-center transition-all hover:border-purple-400 peer-checked:border-purple-400 peer-checked:bg-purple-500/10">
                                        <div class="w-8 h-8 bg-gradient-to-r from-yellow-400 to-slate-600 rounded-full mx-auto mb-2"></div>
                                        <span class="text-sm text-slate-300">Sistem</span>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Bahasa -->
                        <div>
                            <label for="language" class="block text-sm font-medium text-indigo-400 mb-2">Bahasa</label>
                            <select name="language" id="language" class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-400 transition-all duration-300">
                                <option value="id" {{ ($user->settings['language'] ?? 'id') == 'id' ? 'selected' : '' }}>🇮🇩 Bahasa Indonesia</option>
                                <option value="en" {{ ($user->settings['language'] ?? 'id') == 'en' ? 'selected' : '' }}>🇺🇸 English</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Notifikasi -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Notifikasi
                    </h4>

                    <div class="space-y-4">
                        <!-- Email Notifications -->
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-500/20 flex items-center justify-center group-hover:bg-blue-500/30 transition-all">
                                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-medium text-white">Notifikasi Email</span>
                                    <p class="text-sm text-slate-400">Kirim notifikasi via email</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notifications_email" value="1"
                                   class="sr-only peer"
                                   {{ ($user->settings['notifications']['email'] ?? true) ? 'checked' : '' }}>
                            <div class="w-12 h-6 flex items-center bg-slate-700 rounded-full p-1 duration-300 ease-in-out peer-checked:bg-blue-500">
                                <div class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out peer-checked:translate-x-6"></div>
                            </div>
                        </label>

                        <!-- System Notifications -->
                        <label class="flex items-center justify-between cursor-pointer group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-green-500/20 flex items-center justify-center group-hover:bg-green-500/30 transition-all">
                                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.75a6 6 0 0 0-6 6v2.25l-2.47 2.47a.75.75 0 0 0 .53 1.28h15.88a.75.75 0 0 0 .53-1.28L16.5 12V9.75a6 6 0 0 0-6-6z"/>
                                    </svg>
                                </div>
                                <div>
                                    <span class="font-medium text-white">Notifikasi Sistem</span>
                                    <p class="text-sm text-slate-400">Tampilkan notifikasi di sistem</p>
                                </div>
                            </div>
                            <input type="checkbox" name="notifications_system" value="1"
                                   class="sr-only peer"
                                   {{ ($user->settings['notifications']['system'] ?? true) ? 'checked' : '' }}>
                            <div class="w-12 h-6 flex items-center bg-slate-700 rounded-full p-1 duration-300 ease-in-out peer-checked:bg-green-500">
                                <div class="bg-white w-4 h-4 rounded-full shadow-md transform duration-300 ease-in-out peer-checked:translate-x-6"></div>
                            </div>
                        </label>
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
                    Simpan Pengaturan
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
