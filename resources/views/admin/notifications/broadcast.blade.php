<x-layouts.admin>
    <x-slot name="title">
        Broadcast <span class="text-amber-400">Notifikasi</span>
    </x-slot>

    {{-- Panel Kaca "Liar" --}}
    <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 overflow-hidden shadow-sm sm:rounded-lg max-w-3xl mx-auto">

        {{-- Kita gunakan Alpine.js untuk show/hide dropdown target --}}
        <form x-data="{ targetGroup: 'all_users' }" action="{{ route('admin.broadcast.store') }}" method="POST">
            @csrf

            <div class="p-6 md:p-8 space-y-6">

                {{-- Notifikasi Sukses/Error --}}
                @if(session('success'))
                    <div class="p-4 bg-green-500/20 text-green-300 border border-green-700/50 rounded-md">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="p-4 bg-red-500/20 text-red-300 border border-red-700/50 rounded-md">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                     <div class="bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- 1. Target Pengiriman --}}
                <div>
                    <label for="target_group" class="block text-sm font-medium text-amber-400">Target Pengiriman</label>
                    <select name="target_group" id="target_group" x-model="targetGroup"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                        <option value="all_users">Semua User (Member)</option>
                        <option value="all_trainers">Semua Trainer</option>
                        <option value="specific_user">User Spesifik</option>
                    </select>
                </div>

                {{-- 2. Target Spesifik (Hanya muncul jika 'specific_user' dipilih) --}}
                <div x-show="targetGroup === 'specific_user'" x-transition>
                    <label for="target_user_id" class="block text-sm font-medium text-amber-400">Pilih User / Trainer</label>
                    <select name="target_user_id" id="target_user_id"
                            class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400">
                        <option value="">-- Pilih Target --</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>

                {{-- 3. Judul Notifikasi --}}
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-300">Judul</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                           placeholder="Misal: 🏋️ Program Latihan Baru!">
                </div>

                {{-- 4. Pesan Notifikasi --}}
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-300">Pesan</label>
                    <textarea name="message" id="message" rows="4" required
                              class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white focus:border-amber-400 focus:ring-amber-400"
                              placeholder="Program latihan bulking Anda untuk minggu ini sudah di-update. Cek sekarang!">{{ old('message') }}</textarea>
                </div>

                {{-- 5. Link (Opsional) --}}


            </div>

            {{-- Tombol Kirim --}}
            <div class="bg-gray-900/50 px-8 py-4 flex justify-end">
                <button type="submit"
                        class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    Kirim Notifikasi
                </button>
            </div>
        </form>
    </div>
</x-layouts.admin>
