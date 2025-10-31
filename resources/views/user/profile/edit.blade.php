@extends('layouts.user')

@section('title', 'Edit Profil')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            {{-- Pesan sukses --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Pesan error --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Edit Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Lengkap</label>
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Umur --}}
                        <div class="mb-3">
                            <label for="age" class="form-label">Usia</label>
                            <input type="number" name="age" id="age"
                                class="form-control @error('age') is-invalid @enderror"
                                value="{{ old('age', $user->age) }}">
                            @error('age')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="mb-3">
                            <label for="gender" class="form-label">Jenis Kelamin</label>
                            <select name="gender" id="gender"
                                class="form-select @error('gender') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tinggi Badan --}}
                        <div class="mb-3">
                            <label for="height" class="form-label">Tinggi Badan (cm)</label>
                            <input type="number" name="height" id="height"
                                class="form-control @error('height') is-invalid @enderror"
                                value="{{ old('height', $user->height) }}">
                            @error('height')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Berat Badan --}}
                        <div class="mb-3">
                            <label for="weight" class="form-label">Berat Badan (kg)</label>
                            <input type="number" name="weight" id="weight"
                                class="form-control @error('weight') is-invalid @enderror"
                                value="{{ old('weight', $user->weight) }}">
                            @error('weight')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Avatar --}}
                        <div class="mb-3">
                            <label class="form-label">Avatar (opsional)</label>
                            <div class="mb-2">
                                <img id="avatar-preview"
                                     src="{{ $user->avatar ? asset('storage/profile_pictures/' . $user->avatar) : asset('images/default-avatar.png') }}"
                                     alt="Avatar" class="img-thumbnail" width="150">
                            </div>
                            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*" onchange="previewAvatar(event)">
                            @error('avatar')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Tombol Simpan --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('user.profile.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Script preview avatar --}}
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
