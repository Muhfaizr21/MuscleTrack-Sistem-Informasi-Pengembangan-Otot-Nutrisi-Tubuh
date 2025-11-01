@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg overflow-hidden">

    <div class="p-6 border-b border-gray-700/50">
        <h2 class="font-serif text-2xl font-bold text-white flex items-center gap-2">
            🔒 Ubah <span class="text-amber-400">Password</span>
        </h2>
    </div>

    <div class="p-6">
        {{-- Notifikasi sukses (Style "Dark Premium") --}}
        @if (session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-300 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Notifikasi error (Style "Dark Premium") --}}
        @if ($errors->any())
            <div class="bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form ubah password (Sistem Anda aman) --}}
        <form action="{{ route('user.profile.password.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PATCH')

            {{-- Password lama (Style "Dark Premium") --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Password Lama</label>
                <div class="relative">
                    <input type="password" name="current_password" id="current_password"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 pr-10"
                        placeholder="Masukkan password lama" required>
                    <button type="button" class="absolute right-3 top-3.5 text-gray-400" onclick="togglePassword('current_password', event)">
                        <i class="bi bi-eye"></i> </button>
                </div>
                @error('current_password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password baru (Style "Dark Premium") --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password" id="new_password"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 pr-10"
                        placeholder="Masukkan password baru" required>
                    <button type="button" class="absolute right-3 top-3.5 text-gray-400" onclick="togglePassword('new_password', event)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('new_password')
                    <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Konfirmasi password baru (Style "Dark Premium") --}}
            <div>
                <label class="block text-sm font-medium text-amber-400 mb-1">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50 pr-10"
                        placeholder="Ulangi password baru" required>
                    <button type="button" class="absolute right-3 top-3.5 text-gray-400" onclick="togglePassword('new_password_confirmation', event)">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            {{-- Tombol simpan (Style "Dark Premium") --}}
            <div class="pt-4 flex justify-between">
                <a href="{{ route('user.profile.index') }}"
                    class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                    ← Kembali
                </a>

                <button type="submit"
                    class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                    💾 Simpan Password
                </button>
            </div>
        </form>
    </div>
@endsection

@section('scripts')
{{-- Script toggle password (Sistem Anda 100% aman) --}}
<script>
    function togglePassword(id, event) {
        const field = document.getElementById(id);
        const icon = event.currentTarget.querySelector('i');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        } else {
            field.type = 'password';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        }
    }
</script>
@endsection
