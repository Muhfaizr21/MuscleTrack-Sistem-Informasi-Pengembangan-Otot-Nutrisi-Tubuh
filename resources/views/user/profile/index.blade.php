@extends('layouts.user')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-2xl p-6">
        <h2 class="text-2xl font-semibold mb-6 text-indigo-700">👤 Informasi Profil</h2>

        {{-- Notifikasi sukses --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        {{-- Foto Profil --}}
        <div class="flex flex-col items-center mb-6">
            <img src="{{ $user->avatar ? asset('storage/profile_pictures/' . $user->avatar) : asset('images/default-avatar.png') }}"
                alt="Profile Photo" class="w-32 h-32 object-cover rounded-full border-4 border-indigo-200 shadow-sm">
            <h3 class="text-xl font-semibold mt-3">{{ $user->name }}</h3>
            <p class="text-gray-500">{{ $user->email }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Umur --}}
            <div>
                <p class="text-gray-600 font-medium">Umur</p>
                <p class="text-gray-800">{{ $user->age ?? '-' }} tahun</p>
            </div>

            {{-- Jenis Kelamin --}}
            <div>
                <p class="text-gray-600 font-medium">Jenis Kelamin</p>
                <p class="text-gray-800">
                    @if($user->gender == 'male')
                        Laki-laki
                    @elseif($user->gender == 'female')
                        Perempuan
                    @else
                        -
                    @endif
                </p>
            </div>

            {{-- Tinggi Badan --}}
            <div>
                <p class="text-gray-600 font-medium">Tinggi Badan</p>
                <p class="text-gray-800">{{ $user->height ? $user->height . ' cm' : '-' }}</p>
            </div>

            {{-- Berat Badan --}}
            <div>
                <p class="text-gray-600 font-medium">Berat Badan</p>
                <p class="text-gray-800">{{ $user->weight ? $user->weight . ' kg' : '-' }}</p>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="pt-6 flex justify-end space-x-3">
            <a href="{{ route('user.profile.edit') }}"
                class="bg-indigo-600 text-white px-5 py-2 rounded-lg hover:bg-indigo-700 transition-all">
                ✏️ Edit Profil
            </a>

            <a href="{{ route('user.profile.password.edit') }}"
                class="bg-gray-600 text-white px-5 py-2 rounded-lg hover:bg-gray-700 transition-all">
                🔒 Ubah Password
            </a>
        </div>
    </div>
@endsection