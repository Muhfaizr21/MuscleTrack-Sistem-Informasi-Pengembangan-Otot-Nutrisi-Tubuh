@extends('layouts.trainer')

@section('title', 'Edit Profil Trainer')

@section('content')
<div class="relative max-w-7xl mx-auto p-6">
    <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)] p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="w-2 h-10 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                <h1 class="text-3xl font-semibold text-white tracking-wide drop-shadow-[0_0_5px_rgba(16,185,129,0.5)]">
                    ✏️ Edit <span class="text-emerald-400">Profil Trainer</span>
                </h1>
            </div>
            <a href="{{ route('trainer.profile.index') }}"
               class="bg-gray-800/50 hover:bg-gray-700/50 text-gray-300 hover:text-white border border-gray-600 hover:border-gray-500 px-4 py-2 rounded-xl transition-all duration-300 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
        </div>

        {{-- PERBAIKI BAGIAN INI: method="POST" bukan method="PUT" --}}
        <form action="{{ route('trainer.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                {{-- Informasi Pribadi --}}
                <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-blue-400"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-white">Informasi Pribadi</h2>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-emerald-300/80 text-sm font-semibold mb-2">
                                Nama Lengkap <span class="text-red-400">*</span>
                            </label>
                            <input type="text"
                                   class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('name') border-red-400 @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', $user->name) }}"
                                   placeholder="Masukkan nama lengkap" required>
                            @error('name')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-emerald-300/80 text-sm font-semibold mb-2">
                                Email <span class="text-red-400">*</span>
                            </label>
                            <input type="email"
                                   class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('email') border-red-400 @enderror"
                                   id="email" name="email"
                                   value="{{ old('email', $user->email) }}"
                                   placeholder="Masukkan email" required>
                            @error('email')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="age" class="block text-emerald-300/80 text-sm font-semibold mb-2">Usia</label>
                                <input type="number"
                                       class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('age') border-red-400 @enderror"
                                       id="age" name="age"
                                       value="{{ old('age', $user->age) }}"
                                       min="18" max="100" placeholder="Usia">
                                @error('age')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="gender" class="block text-emerald-300/80 text-sm font-semibold mb-2">Jenis Kelamin</label>
                                <select class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('gender') border-red-400 @enderror"
                                        id="gender" name="gender">
                                    <option value="" class="bg-gray-800">Pilih Jenis Kelamin</option>
                                    <option value="male" class="bg-gray-800" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" class="bg-gray-800" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                                @error('gender')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="height" class="block text-emerald-300/80 text-sm font-semibold mb-2">Tinggi Badan (cm)</label>
                                <input type="number" step="0.1"
                                       class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('height') border-red-400 @enderror"
                                       id="height" name="height"
                                       value="{{ old('height', $user->height) }}"
                                       min="100" max="250" placeholder="Tinggi">
                                @error('height')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="weight" class="block text-emerald-300/80 text-sm font-semibold mb-2">Berat Badan (kg)</label>
                                <input type="number" step="0.1"
                                       class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('weight') border-red-400 @enderror"
                                       id="weight" name="weight"
                                       value="{{ old('weight', $user->weight) }}"
                                       min="30" max="200" placeholder="Berat">
                                @error('weight')
                                    <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Informasi Profesional --}}
                <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl p-6">
                    <div class="flex items-center mb-6">
                        <div class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-briefcase text-green-400"></i>
                        </div>
                        <h2 class="text-xl font-semibold text-white">Informasi Profesional</h2>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="specialization" class="block text-emerald-300/80 text-sm font-semibold mb-2">Spesialisasi</label>
                            <input type="text"
                                   class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('specialization') border-red-400 @enderror"
                                   id="specialization" name="specialization"
                                   value="{{ old('specialization', $trainerProfile->specialization) }}"
                                   placeholder="Contoh: Weight Loss, Muscle Building, etc.">
                            @error('specialization')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="experience_years" class="block text-emerald-300/80 text-sm font-semibold mb-2">Tahun Pengalaman</label>
                            <input type="number"
                                   class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('experience_years') border-red-400 @enderror"
                                   id="experience_years" name="experience_years"
                                   value="{{ old('experience_years', $trainerProfile->experience_years) }}"
                                   min="0" max="50" placeholder="Jumlah tahun pengalaman">
                            @error('experience_years')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="bio" class="block text-emerald-300/80 text-sm font-semibold mb-2">Bio / Deskripsi Diri</label>
                            <textarea class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('bio') border-red-400 @enderror"
                                      id="bio" name="bio" rows="4"
                                      placeholder="Ceritakan tentang diri Anda, pengalaman, dan keahlian...">{{ old('bio', $trainerProfile->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="certifications" class="block text-emerald-300/80 text-sm font-semibold mb-2">Sertifikasi & Kualifikasi</label>
                            <textarea class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white placeholder-gray-500 focus:border-emerald-400 focus:ring-2 focus:ring-emerald-400/20 transition-all duration-300 @error('certifications') border-red-400 @enderror"
                                      id="certifications" name="certifications" rows="3"
                                      placeholder="Masukkan sertifikasi yang dimiliki (pisahkan dengan koma)">{{ old('certifications', $trainerProfile->certifications) }}</textarea>
                            @error('certifications')
                                <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upload File --}}
            <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl p-6 mb-6">
                <div class="flex items-center mb-6">
                    <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-3">
                        <i class="fas fa-upload text-purple-400"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-white">Upload File</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Foto Profil --}}
                    <div>
                        <label for="avatar" class="block text-emerald-300/80 text-sm font-semibold mb-2">Foto Profil</label>
                        <div class="flex items-center space-x-4 mb-3">
                            @if($user->avatar)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $user->avatar) }}"
                                         alt="Current Avatar"
                                         class="rounded-xl w-20 h-20 object-cover border-2 border-emerald-400/30">
                                    <button type="button"
                                            onclick="confirmDeleteAvatar()"
                                            class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center hover:bg-red-600 transition-all duration-300">
                                        <i class="fas fa-times text-white text-xs"></i>
                                    </button>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file"
                                       class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-emerald-500 file:text-white hover:file:bg-emerald-600 transition-all duration-300 @error('avatar') border-red-400 @enderror"
                                       id="avatar" name="avatar" accept="image/*">
                            </div>
                        </div>
                        <p class="text-gray-400 text-sm">Format: JPG, PNG, GIF. Maksimal: 2MB</p>
                        @error('avatar')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- File Sertifikat --}}
                    <div>
                        <label for="certificate_file" class="block text-emerald-300/80 text-sm font-semibold mb-2">File Sertifikat</label>
                        <div class="flex items-center space-x-4 mb-3">
                            @if(isset($verification) && $verification->certificate)
                                <div class="p-3 rounded-xl bg-gray-800/50 border border-emerald-400/10 flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-emerald-300 text-sm font-semibold mb-1">File saat ini:</p>
                                            <p class="text-white text-sm truncate">{{ basename($verification->certificate) }}</p>
                                        </div>
                                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                                            {{ $verification->status == 'approved' ? 'bg-green-500/20 text-green-400 border border-green-400/30' :
                                               ($verification->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-400/30' :
                                               'bg-red-500/20 text-red-400 border border-red-400/30') }}">
                                            {{ ucfirst($verification->status) }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="p-3 rounded-xl bg-gray-800/50 border border-yellow-400/10 flex-1">
                                    <p class="text-yellow-400 text-sm">Belum ada file sertifikat yang diupload.</p>
                                </div>
                            @endif
                        </div>
                        <input type="file"
                               class="w-full bg-gray-800/50 border border-emerald-400/20 rounded-xl px-4 py-3 text-white file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-500 file:text-white hover:file:bg-blue-600 transition-all duration-300 @error('certificate_file') border-red-400 @enderror"
                               id="certificate_file" name="certificate_file" accept=".pdf,.doc,.docx">
                        <p class="text-gray-400 text-sm mt-2">Format: PDF, DOC, DOCX. Maksimal: 5MB</p>
                        @error('certificate_file')
                            <p class="text-red-400 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('trainer.profile.index') }}"
                   class="bg-gray-800/50 hover:bg-gray-700/50 text-gray-300 hover:text-white border border-gray-600 hover:border-gray-500 px-6 py-3 rounded-xl transition-all duration-300 flex items-center">
                    <i class="fas fa-times mr-2"></i>Batal
                </a>
                <button type="submit"
                        class="bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-semibold px-8 py-3 rounded-xl transition-all duration-300 flex items-center shadow-lg hover:shadow-xl">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    input[type="file"]::file-selector-button {
        background: linear-gradient(to right, #10b981, #059669);
        color: white;
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 9999px;
        cursor: pointer;
        transition: all 0.3s;
    }

    input[type="file"]::file-selector-button:hover {
        background: linear-gradient(to right, #059669, #047857);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Preview image sebelum upload
    document.getElementById('avatar').addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                console.log('File selected:', file.name);
            }
            reader.readAsDataURL(file);
        }
    });

    // Konfirmasi hapus avatar
    function confirmDeleteAvatar() {
        Swal.fire({
            title: 'Hapus Foto Profil?',
            text: "Foto profil akan dihapus permanen. Anda dapat mengupload foto baru nanti.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            background: '#1f2937',
            color: '#f9fafb',
            customClass: {
                popup: 'rounded-2xl border border-red-400/20 bg-gradient-to-br from-gray-900/80 to-gray-800/70'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('trainer.profile.avatar.delete') }}";
            }
        });
    }

    // Validasi form
    document.querySelector('form').addEventListener('submit', function (e) {
        const requiredFields = this.querySelectorAll('[required]');
        let valid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                valid = false;
                field.classList.add('border-red-400');
                field.classList.remove('border-emerald-400');
            }
        });

        if (!valid) {
            e.preventDefault();
            Swal.fire({
                title: 'Perhatian!',
                text: 'Harap isi semua field yang wajib diisi.',
                icon: 'warning',
                confirmButtonColor: '#10b981',
                background: '#1f2937',
                color: '#f9fafb',
                customClass: {
                    popup: 'rounded-2xl border border-yellow-400/20 bg-gradient-to-br from-gray-900/80 to-gray-800/70'
                }
            });
        }
    });

    // Real-time validation
    document.querySelectorAll('input[required], textarea[required]').forEach(input => {
        input.addEventListener('blur', function() {
            if (!this.value.trim()) {
                this.classList.add('border-red-400');
                this.classList.remove('border-emerald-400');
            } else {
                this.classList.remove('border-red-400');
                this.classList.add('border-emerald-400');
            }
        });

        input.addEventListener('input', function() {
            if (this.value.trim()) {
                this.classList.remove('border-red-400');
                this.classList.add('border-emerald-400');
            }
        });
    });
</script>
@endpush
