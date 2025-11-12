<x-layouts.admin>
    <x-slot name="title">
        Tugaskan <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Trainer</span>
    </x-slot>

    <div class="bg-slate-800/40 backdrop-blur-lg border border-slate-700/30 rounded-2xl shadow-2xl shadow-black/30 overflow-hidden max-w-2xl mx-auto">

        <form action="{{ route('admin.trainer-memberships.store') }}" method="POST">
            @csrf

            <!-- Form Header -->
            <div class="p-6 border-b border-slate-700/50">
                <h3 class="text-2xl font-bold text-white">
                    Tugaskan <span class="bg-gradient-to-r from-green-400 to-emerald-500 bg-clip-text text-transparent">Trainer</span>
                </h3>
                <p class="text-sm text-slate-400 mt-1">Pilih member dan trainer untuk membuat penugasan baru</p>
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

                <!-- Member Selection -->
                <div>
                    <label for="user_id" class="block text-sm font-medium text-slate-300 mb-3 flex items-center gap-2">
                        <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                        Pilih Member
                    </label>
                    <div class="relative">
                        <select name="user_id" id="user_id" required
                                class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                            <option value="">-- Pilih User Member --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Pilih user yang akan menjadi member premium</p>
                </div>

                <!-- Trainer Selection -->
                <div>
                    <label for="trainer_id" class="block text-sm font-medium text-slate-300 mb-3 flex items-center gap-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        Pilih Trainer
                    </label>
                    <div class="relative">
                        <select name="trainer_id" id="trainer_id" required
                                class="w-full bg-slate-700/50 border border-slate-600/50 rounded-xl py-3 px-4 pl-10 text-slate-200 focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-300 appearance-none">
                            <option value="">-- Pilih Trainer --</option>
                            @foreach($trainers as $trainer)
                                <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                    {{ $trainer->name }} ({{ $trainer->email }})
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                            </svg>
                        </div>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                            <svg class="w-5 h-5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-slate-500 mt-2">Pilih trainer profesional untuk membimbing member</p>
                </div>

                <!-- Preview Section -->
                <div class="bg-slate-700/30 rounded-xl p-4 border border-slate-600/50">
                    <h4 class="text-sm font-semibold text-slate-300 mb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Preview Penugasan
                    </h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="text-center p-3 bg-slate-600/30 rounded-lg">
                            <div class="text-blue-400 font-semibold">Member</div>
                            <div id="member-preview" class="text-slate-400 text-xs mt-1">-</div>
                        </div>
                        <div class="text-center p-3 bg-slate-600/30 rounded-lg">
                            <div class="text-green-400 font-semibold">Trainer</div>
                            <div id="trainer-preview" class="text-slate-400 text-xs mt-1">-</div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Form Footer -->
            <div class="bg-slate-800/50 px-8 py-6 border-t border-slate-700/50">
                <div class="flex flex-col sm:flex-row gap-4 justify-between items-center">
                    <a href="{{ route('admin.trainer-memberships.index') }}"
                       class="px-6 py-3 rounded-xl border border-slate-600/50 text-slate-300 hover:text-white hover:bg-slate-700/50 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit"
                            class="px-8 py-3 rounded-xl bg-gradient-to-r from-green-500 to-emerald-600 text-white font-bold shadow-lg hover:shadow-green-500/30 transition-all duration-300 transform hover:-translate-y-0.5 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Simpan Penugasan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const userSelect = document.getElementById('user_id');
            const trainerSelect = document.getElementById('trainer_id');
            const memberPreview = document.getElementById('member-preview');
            const trainerPreview = document.getElementById('trainer-preview');

            function updatePreview() {
                // Update member preview
                const selectedUser = userSelect.options[userSelect.selectedIndex];
                memberPreview.textContent = selectedUser.value ? selectedUser.text : '-';

                // Update trainer preview
                const selectedTrainer = trainerSelect.options[trainerSelect.selectedIndex];
                trainerPreview.textContent = selectedTrainer.value ? selectedTrainer.text : '-';
            }

            userSelect.addEventListener('change', updatePreview);
            trainerSelect.addEventListener('change', updatePreview);

            // Initial preview update
            updatePreview();
        });
    </script>

</x-layouts.admin>
