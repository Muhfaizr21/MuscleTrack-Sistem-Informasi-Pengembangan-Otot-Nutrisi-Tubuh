@extends('layouts.user')

@section('content')
    <div class="max-w-3xl mx-auto bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg p-6">

        <h2 class="font-serif text-2xl font-bold text-white mb-6">👤 Informasi <span class="text-amber-400">Profil</span></h2>

        {{-- Notifikasi sukses (Style "Dark Premium") --}}
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-500/50 text-green-300 p-3 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Foto Profil (Style "Dark Premium") --}}
        <div class="flex flex-col items-center mb-6">
            <img src="{{ $user->avatar ? asset('storage/profile_pictures/' . $user->avatar) : asset('images/default-avatar.png') }}"
                alt="Profile Photo" class="w-32 h-32 object-cover rounded-full border-4 border-amber-400/50 shadow-sm">

            <h3 class="font-serif text-xl font-bold text-white mt-3">{{ $user->name }}</h3>
            <p class="text-gray-400">{{ $user->email }}</p>
        </div>

        <div class="border-t border-gray-700/50 pt-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Umur (Style "Dark Premium") --}}
                <div>
                    <p class="text-gray-400 font-medium text-sm">Umur</p>
                    <p class="text-white text-lg font-medium">{{ $user->age ?? '-' }} tahun</p>
                </div>

                {{-- Jenis Kelamin (Style "Dark Premium") --}}
                <div>
                    <p class="text-gray-400 font-medium text-sm">Jenis Kelamin</p>
                    <p class="text-white text-lg font-medium">
                        @if($user->gender == 'male')
                            Laki-laki
                        @elseif($user->gender == 'female')
                            Perempuan
                        @else
                            -
                        @endif
                    </p>
                </div>

                {{-- Tinggi Badan (Style "Dark Premium") --}}
                <div>
                    <p class="text-gray-400 font-medium text-sm">Tinggi Badan</p>
                    <p class="text-white text-lg font-medium">{{ $user->height ? $user->height . ' cm' : '-' }}</p>
                </div>

                {{-- Berat Badan (Style "Dark Premium") --}}
                <div>
                    <p class="text-gray-400 font-medium text-sm">Berat Badan</p>
                    <p class="text-white text-lg font-medium">{{ $user->weight ? $user->weight . ' kg' : '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi (Style "Dark Premium") --}}
        <div class="border-t border-gray-700/50 mt-6 pt-6 flex justify-end space-x-3">
            <a href="{{ route('user.profile.password.edit') }}"
                class="px-5 py-2.5 rounded-md text-sm font-bold text-white bg-gray-700 hover:bg-gray-600 transition-all">
                🔒 Ubah Password
            </a>
            <a href="{{ route('user.profile.edit') }}"
                class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                ✏️ Edit Profil
            </a>
        </div>
    </div>
@endsection
