<x-layouts.admin>
    <x-slot name="title">
        Bantuan & <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Panduan Admin</span>
    </x-slot>

    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Header -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 p-6">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h3 class="text-2xl font-bold text-white">
                        Bantuan & <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Panduan Admin</span>
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">Panduan lengkap untuk mengelola sistem MuscleXpert</p>
                </div>
            </div>
        </div>

        <!-- Quick Access Cards -->
        <div class="grid grid-cols-1 md:grid-rows-2 md:grid-cols-3 gap-6">
            <!-- Manajemen User -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 hover:transform hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-white mb-2">Manajemen User</h4>
                <p class="text-slate-400 text-sm mb-4">Kelola member dan trainer</p>
                <a href="{{ route('admin.users.index') }}" class="text-blue-400 hover:text-blue-300 text-sm font-medium">Buka Panel →</a>
            </div>

            <!-- Program Latihan -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 hover:transform hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-white mb-2">Program Latihan</h4>
                <p class="text-slate-400 text-sm mb-4">Buat dan kelola workout plans</p>
                <a href="{{ route('admin.workout-plans.index') }}" class="text-orange-400 hover:text-orange-300 text-sm font-medium">Buka Panel →</a>
            </div>

            <!-- Program Nutrisi -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 hover:transform hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-white mb-2">Program Nutrisi</h4>
                <p class="text-slate-400 text-sm mb-4">Kelola menu dan diet plans</p>
                <a href="{{ route('admin.nutrition-programs.index') }}" class="text-emerald-400 hover:text-emerald-300 text-sm font-medium">Buka Panel →</a>
            </div>

            <!-- Member Premium -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 hover:transform hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-white mb-2">Member Premium</h4>
                <p class="text-slate-400 text-sm mb-4">Kelola membership dan trainer</p>
                <a href="{{ route('admin.trainer-memberships.index') }}" class="text-amber-400 hover:text-amber-300 text-sm font-medium">Buka Panel →</a>
            </div>

            <!-- Broadcast -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 hover:transform hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-pink-500 to-rose-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM10.5 3.75a6 6 0 0 0-6 6v2.25l-2.47 2.47a.75.75 0 0 0 .53 1.28h15.88a.75.75 0 0 0 .53-1.28L16.5 12V9.75a6 6 0 0 0-6-6z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-white mb-2">Broadcast</h4>
                <p class="text-slate-400 text-sm mb-4">Kirim notifikasi ke user</p>
                <a href="{{ route('admin.broadcast.index') }}" class="text-pink-400 hover:text-pink-300 text-sm font-medium">Buka Panel →</a>
            </div>

            <!-- Pesan Kontak -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 hover:transform hover:-translate-y-1 transition-all duration-300">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h4 class="font-semibold text-white mb-2">Pesan Kontak</h4>
                <p class="text-slate-400 text-sm mb-4">Kelola pesan dari user</p>
                <a href="{{ route('admin.contact.index') }}" class="text-indigo-400 hover:text-indigo-300 text-sm font-medium">Buka Panel →</a>
            </div>
        </div>

        <!-- Panduan Lengkap -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Panduan Cepat -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                    Panduan Cepat
                </h4>

                <div class="space-y-4">
                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">📊 Dashboard</h5>
                        <p class="text-slate-400 text-sm">Lihat statistik sistem, user aktif, dan aktivitas terbaru</p>
                    </div>

                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">👥 Tambah User Baru</h5>
                        <p class="text-slate-400 text-sm">1. Buka Manajemen User<br>2. Klik "Tambah User"<br>3. Isi data dan simpan</p>
                    </div>

                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">💪 Buat Program Latihan</h5>
                        <p class="text-slate-400 text-sm">1. Buka Program Latihan<br>2. Klik "Buat Program Baru"<br>3. Tentukan exercises dan sets</p>
                    </div>

                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">🍎 Buat Menu Nutrisi</h5>
                        <p class="text-slate-400 text-sm">1. Buka Program Nutrisi<br>2. Klik "Buat Menu Baru"<br>3. Hitung kalori dan nutrisi</p>
                    </div>
                </div>
            </div>

            <!-- Tips & Best Practices -->
            <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6">
                <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                    <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                    Tips & Best Practices
                </h4>

                <div class="space-y-4">
                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">✅ Verifikasi Data User</h5>
                        <p class="text-slate-400 text-sm">Selalu verifikasi email dan data user sebelum memberikan akses premium</p>
                    </div>

                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">📝 Backup Rutin</h5>
                        <p class="text-slate-400 text-sm">Lakukan backup data user dan program secara berkala</p>
                    </div>

                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">🔒 Keamanan Data</h5>
                        <p class="text-slate-400 text-sm">Jaga kerahasiaan data user dan jangan bagikan password</p>
                    </div>

                    <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                        <h5 class="font-semibold text-white mb-2">📞 Responsif Support</h5>
                        <p class="text-slate-400 text-sm">Balas pesan kontak user maksimal 24 jam setelah diterima</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6">
            <h4 class="text-lg font-semibold text-white mb-6 flex items-center gap-2">
                <div class="w-2 h-2 bg-purple-400 rounded-full"></div>
                Frequently Asked Questions (FAQ)
            </h4>

            <div class="space-y-4">
                <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                    <h5 class="font-semibold text-white mb-2">❓ Bagaimana cara reset password user?</h5>
                    <p class="text-slate-400 text-sm">Buka Manajemen User → Pilih user → Klik "Edit" → Kosongkan password (biarkan user reset via email)</p>
                </div>

                <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                    <h5 class="font-semibold text-white mb-2">❓ Apa perbedaan member regular dan premium?</h5>
                    <p class="text-slate-400 text-sm">Member premium mendapat akses ke program personalized, konsultasi trainer, dan fitur advanced</p>
                </div>

                <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                    <h5 class="font-semibold text-white mb-2">❓ Bagaimana menghitung kebutuhan kalori?</h5>
                    <p class="text-slate-400 text-sm">Gunakan kalkulator BMR dan TDEE, sesuaikan dengan goal user (cutting/maintenance/bulking)</p>
                </div>

                <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/30">
                    <h5 class="font-semibold text-white mb-2">❓ Bagaimana cara backup data?</h5>
                    <p class="text-slate-400 text-sm">Gunakan fitur export di masing-masing modul atau backup database melalui phpMyAdmin</p>
                </div>
            </div>
        </div>

        <!-- Support Request Form -->


        <!-- Contact Info -->
        <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl p-6 text-center">
            <h4 class="font-semibold text-white mb-4">📞 Kontak Darurat</h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-slate-400">Email Support:</span>
                    <a href="mailto:support@musclexpert.com" class="text-blue-400 hover:text-blue-300 ml-2">support@musclexpert.com</a>
                </div>
                <div>
                    <span class="text-slate-400">Telepon:</span>
                    <span class="text-white ml-2">+62 21 1234 5678</span>
                </div>
            </div>
        </div>

    </div>
</x-layouts.admin>
