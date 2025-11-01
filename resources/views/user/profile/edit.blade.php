@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
    <div class="max-w-3xl mx-auto bg-black/70 backdrop-blur-lg border border-gray-700/50 shadow-sm sm:rounded-lg overflow-hidden">

        <div class="p-6 border-b border-gray-700/50">
            <h2 class="font-serif text-2xl font-bold text-white">Edit <span class="text-amber-400">Profil</span></h2>
        </div>

        <div class="p-6">
            {{-- Pesan sukses (Style "Dark Premium") --}}
            @if (session('success'))
                <div class="bg-green-500/20 border border-green-500/50 text-green-300 p-3 rounded-lg mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Pesan error (Style "Dark Premium") --}}
            @if ($errors->any())
                <div class="bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md mb-4">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PATCH')

                {{-- Nama (Style "Dark Premium") --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-amber-400 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="name"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                               @error('name') border-red-500 @enderror"
                        value="{{ old('name', $user->name) }}" required>
                    @error('name')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email (Style "Dark Premium") --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-amber-400 mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                               @error('email') border-red-500 @enderror"
                        value="{{ old('email', $user->email) }}" required>
                    @error('email')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Umur (Style "Dark Premium") --}}
                <div>
                    <label for="age" class="block text-sm font-medium text-gray-300 mb-1">Usia</label>
                    <input type="number" name="age" id="age"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                               @error('age') border-red-500 @enderror"
                        value="{{ old('age', $user->age) }}">
                    @error('age')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis Kelamin (Style "Dark Premium") --}}
                <div>
                    <label for="gender" class="block text-sm font-medium text-gray-300 mb-1">Jenis Kelamin</label>
                    <select name="gender" id="gender"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                               @error('gender') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('gender')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tinggi Badan (Style "Dark Premium") --}}
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-300 mb-1">Tinggi Badan (cm)</label>
                    <input type="number" name="height" id="height"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                               @error('height') border-red-500 @enderror"
                        value="{{ old('height', $user->height) }}">
                    @error('height')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Berat Badan (Style "Dark Premium") --}}
                <div>
                    <label for="weight" class="block text-sm font-medium text-gray-300 mb-1">Berat Badan (kg)</label>
                    <input type="number" name="weight" id="weight"
                        class="mt-1 block w-full bg-gray-800 border-gray-700 rounded-md shadow-sm text-white
                               focus:border-amber-400 focus:ring focus:ring-amber-400 focus:ring-opacity-50
                               @error('weight') border-red-500 @enderror"
                        value="{{ old('weight', $user->weight) }}">
                    @error('weight')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Avatar (Style "Dark Premium") --}}
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-1">Avatar (opsional)</label>
                    <div class="mb-2">
                        <img id="avatar-preview"
                             src="{{ $user->avatar ? asset('storage/profile_pictures/' . $user->avatar) : asset('images/default-avatar.png') }}"
                             alt="Avatar" class="w-32 h-32 object-cover rounded-full border-2 border-gray-700/50">
                    </div>
                    <input type="file" name="avatar" id="avatar"
                           class="block w-full text-sm text-gray-400
                                  file:mr-4 file:py-2 file:px-4
                                  file:rounded-full file:border-0
                                  file:text-sm file:font-semibold
                                  file:bg-amber-400/20 file:text-amber-300
                                  hover:file:bg-amber-400/30
                                  @error('avatar') border-red-500 rounded-lg @enderror"
                           accept="image/*" onchange="previewAvatar(event)">
                    @error('avatar')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tombol Simpan (Style "Dark Premium") --}}
                <div class="d-flex justify-content-between pt-3">
                    <a href="{{ route('user.profile.index') }}"
                       class="px-4 py-2 bg-gray-700 hover:bg-gray-600 rounded-lg text-white font-medium text-sm transition-all">
                       Kembali
                    </a>
                    <button type="submit"
                            class="px-5 py-2.5 rounded-md text-sm font-bold text-black bg-amber-400 hover:bg-amber-300 transition-all shadow-lg shadow-amber-500/20">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
{{-- Script preview avatar (Sistem Anda aman, saya hanya pindahkan ke section('scripts') agar rapi) --}}
<script>
    function previewAvatar(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('avatar-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection
