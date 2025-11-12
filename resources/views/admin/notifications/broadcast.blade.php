<x-layouts.admin>
    <x-slot name="title">
        Broadcast <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Notifikasi</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-3xl mx-auto">

        <!-- Header Section -->
        <div class="p-6 border-b border-slate-700/50">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Broadcast <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Notifikasi</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Kirim pesan notifikasi ke user atau trainer</p>
                </div>
            </div>
        </div>

        <!-- Form Section -->
        <form x-data="{ targetGroup: 'all_users' }" action="{{ route('admin.broadcast.store') }}" method="POST">
            @csrf
            <div class="p-6 space-y-8">

                <!-- Success/Error Messages -->
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

                @if(session('error'))
                    <div class="p-4 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 rounded-xl">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 bg-red-500/15 backdrop-blur-sm text-red-400 border border-red-500/20 rounded-xl">
                        <div class="flex items-center gap-2 mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="font-semibold">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Target Selection Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Target Pengiriman
                    </h4>

                    <div class="space-y-6">
                        <!-- Target Group -->
                        <div>
                            <label for="target_group" class="block text-sm font-medium text-green-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                Kelompok Target
                            </label>
                            <select name="target_group" id="target_group" x-model="targetGroup" required
                                    class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-green-500/50 focus:border-green-400 transition-all duration-300 backdrop-blur-sm">
                                <option value="all_users">👥 Semua User (Member)</option>
                                <option value="all_trainers">💪 Semua Trainer</option>
                                <option value="specific_user">🎯 User Spesifik</option>
                            </select>
                        </div>

                        <!-- Specific User Selection -->
                        <div x-show="targetGroup === 'specific_user'" x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 transform -translate-y-2"
                             x-transition:enter-end="opacity-100 transform translate-y-0">
                            <label for="target_user_id" class="block text-sm font-medium text-emerald-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Pilih User / Trainer
                            </label>
                            <select name="target_user_id" id="target_user_id"
                                    class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-400 transition-all duration-300 backdrop-blur-sm">
                                <option value="">-- Pilih Target --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Notification Content Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Konten Notifikasi
                    </h4>

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-blue-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Judul Notifikasi
                            </label>
                            <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-400 transition-all duration-300 backdrop-blur-sm"
                                   placeholder="Misal: 🏋️ Program Latihan Baru Tersedia!">
                            <p class="text-xs text-slate-500 mt-2">Judul yang menarik akan meningkatkan engagement</p>
                        </div>

                        <!-- Message -->
                        <div>
                            <label for="message" class="block text-sm font-medium text-cyan-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                                </svg>
                                Pesan Notifikasi
                            </label>
                            <textarea name="message" id="message" rows="4" required
                                      class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/50 focus:border-cyan-400 transition-all duration-300 backdrop-blur-sm resize-none"
                                      placeholder="Program latihan bulking Anda untuk minggu ini sudah di-update dengan exercise terbaru. Segera cek dan mulai latihan Anda sekarang!">{{ old('message') }}</textarea>
                            <p class="text-xs text-slate-500 mt-2">Tulis pesan yang jelas dan informatif untuk user</p>
                        </div>

                        <!-- Link (Optional) -->
                        <div>
                            <label for="action_url" class="block text-sm font-medium text-purple-400 mb-2 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                                </svg>
                                Link Tindakan (Opsional)
                            </label>
                            <input type="url" name="action_url" id="action_url" value="{{ old('action_url') }}"
                                   class="w-full bg-slate-800/50 border border-slate-600/50 rounded-xl px-4 py-3 text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-400 transition-all duration-300 backdrop-blur-sm"
                                   placeholder="https://example.com/program-latihan">
                            <p class="text-xs text-slate-500 mt-2">Link yang akan dibuka ketika user menekan notifikasi</p>
                        </div>
                    </div>
                </div>

                <!-- Preview Card -->
                <div class="bg-slate-700/30 backdrop-blur-sm border border-slate-600/30 rounded-2xl p-6">
                    <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                        Preview Notifikasi
                    </h4>

                    <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-600/30">
                        <div class="text-sm font-semibold text-yellow-400 mb-1" x-text="document.getElementById('title')?.value || 'Judul Notifikasi'"></div>
                        <div class="text-sm text-slate-300" x-text="document.getElementById('message')?.value || 'Pesan notifikasi akan muncul di sini...'"></div>
                        <div class="text-xs text-slate-500 mt-2" x-show="document.getElementById('action_url')?.value">
                            🔗 <span x-text="document.getElementById('action_url')?.value"></span>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Preview ini menunjukkan bagaimana notifikasi akan tampil di perangkat user</p>
                </div>
            </div>

            <!-- Footer dengan CTA Button -->
            <div class="bg-gradient-to-r from-slate-800/50 to-slate-700/30 px-6 py-4 flex justify-end border-t border-slate-700/30">
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim Notifikasi
                </button>
            </div>
        </form>
    </div>

    <style>
        input:focus, textarea:focus, select:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(8px);
        }

        textarea {
            resize: none;
        }

        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: rgba(30, 41, 59, 0.5);
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: rgba(100, 116, 139, 0.5);
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: rgba(100, 116, 139, 0.7);
        }
    </style>

</x-layouts.admin>
