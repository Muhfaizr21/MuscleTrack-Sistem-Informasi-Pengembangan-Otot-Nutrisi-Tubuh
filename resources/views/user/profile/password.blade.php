@extends('layouts.user')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-lg rounded-2xl p-8">
    <h2 class="text-2xl font-semibold mb-6 text-indigo-700 flex items-center gap-2">
        <i class="bi bi-shield-lock"></i> Ubah Password
    </h2>

    {{-- Notifikasi sukses --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-300">
            {{ session('success') }}
        </div>
    @endif

    {{-- Notifikasi error --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 border border-red-300">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form ubah password --}}
    <form action="{{ route('user.profile.password.update') }}" method="POST" class="space-y-6">
        @csrf
        @method('PATCH')

        {{-- Password lama --}}
        <div>
            <label class="block font-medium text-gray-700">Password Lama</label>
            <div class="relative">
                <input type="password" name="current_password" id="current_password"
                    class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10"
                    placeholder="Masukkan password lama" required>
                <button type="button" class="absolute right-3 top-3 text-gray-500" onclick="togglePassword('current_password', event)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('current_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password baru --}}
        <div>
            <label class="block font-medium text-gray-700">Password Baru</label>
            <div class="relative">
                <input type="password" name="new_password" id="new_password"
                    class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10"
                    placeholder="Masukkan password baru" required>
                <button type="button" class="absolute right-3 top-3 text-gray-500" onclick="togglePassword('new_password', event)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
            @error('new_password')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        {{-- Konfirmasi password baru --}}
        <div>
            <label class="block font-medium text-gray-700">Konfirmasi Password Baru</label>
            <div class="relative">
                <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                    class="w-full border rounded-lg p-2 mt-1 focus:ring-2 focus:ring-indigo-400 focus:outline-none pr-10"
                    placeholder="Ulangi password baru" required>
                <button type="button" class="absolute right-3 top-3 text-gray-500" onclick="togglePassword('new_password_confirmation', event)">
                    <i class="bi bi-eye"></i>
                </button>
            </div>
        </div>

        {{-- Tombol simpan --}}
        <div class="pt-4 flex justify-between">
            <a href="{{ route('user.profile.index') }}"
                class="bg-gray-200 text-gray-800 px-6 py-2 rounded-lg hover:bg-gray-300 transition-all">
                ← Kembali
            </a>

            <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition-all">
                💾 Simpan Password
            </button>
        </div>
    </form>
</div>

{{-- Script toggle password --}}
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
