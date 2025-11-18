@extends('layouts.trainer')

@section('title', 'Edit Profil Trainer')

@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent pb-0">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Edit Profil Trainer</h5>
                            <a href="{{ route('trainer.profile.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- UBAH METHOD MENJADI POST DAN HAPUS @method('PUT') -->
                        <form action="{{ route('trainer.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <!-- HAPUS BARIS INI: @method('PUT') -->

                            <div class="row">
                                <!-- Informasi Pribadi -->
                                <div class="col-lg-6">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="fas fa-user me-2 text-primary"></i>Informasi Pribadi
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="name" class="form-label">Nama Lengkap <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text"
                                                        class="form-control @error('name') is-invalid @enderror" id="name"
                                                        name="name" value="{{ old('name', $user->name) }}" required>
                                                    @error('name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="email" class="form-label">Email <span
                                                            class="text-danger">*</span></label>
                                                    <input type="email"
                                                        class="form-control @error('email') is-invalid @enderror" id="email"
                                                        name="email" value="{{ old('email', $user->email) }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="age" class="form-label">Usia</label>
                                                    <input type="number"
                                                        class="form-control @error('age') is-invalid @enderror" id="age"
                                                        name="age" value="{{ old('age', $user->age) }}" min="18" max="100">
                                                    @error('age')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="gender" class="form-label">Jenis Kelamin</label>
                                                    <select class="form-select @error('gender') is-invalid @enderror"
                                                        id="gender" name="gender">
                                                        <option value="">Pilih Jenis Kelamin</option>
                                                        <option value="male"
                                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                                            Laki-laki</option>
                                                        <option value="female"
                                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                                            Perempuan</option>
                                                    </select>
                                                    @error('gender')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="height" class="form-label">Tinggi Badan (cm)</label>
                                                    <input type="number" step="0.1"
                                                        class="form-control @error('height') is-invalid @enderror"
                                                        id="height" name="height" value="{{ old('height', $user->height) }}"
                                                        min="100" max="250">
                                                    @error('height')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="weight" class="form-label">Berat Badan (kg)</label>
                                                    <input type="number" step="0.1"
                                                        class="form-control @error('weight') is-invalid @enderror"
                                                        id="weight" name="weight" value="{{ old('weight', $user->weight) }}"
                                                        min="30" max="200">
                                                    @error('weight')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Profesional -->
                                <div class="col-lg-6">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="fas fa-briefcase me-2 text-success"></i>Informasi Profesional
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <label for="specialization" class="form-label">Spesialisasi</label>
                                                    <input type="text"
                                                        class="form-control @error('specialization') is-invalid @enderror"
                                                        id="specialization" name="specialization"
                                                        value="{{ old('specialization', $trainerProfile->specialization) }}"
                                                        placeholder="Contoh: Weight Loss, Muscle Building, etc.">
                                                    @error('specialization')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="experience_years" class="form-label">Tahun
                                                        Pengalaman</label>
                                                    <input type="number"
                                                        class="form-control @error('experience_years') is-invalid @enderror"
                                                        id="experience_years" name="experience_years"
                                                        value="{{ old('experience_years', $trainerProfile->experience_years) }}"
                                                        min="0" max="50" placeholder="Jumlah tahun pengalaman">
                                                    @error('experience_years')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="bio" class="form-label">Bio / Deskripsi Diri</label>
                                                    <textarea class="form-control @error('bio') is-invalid @enderror"
                                                        id="bio" name="bio" rows="4"
                                                        placeholder="Ceritakan tentang diri Anda, pengalaman, dan keahlian...">{{ old('bio', $trainerProfile->bio) }}</textarea>
                                                    @error('bio')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-12 mb-3">
                                                    <label for="certifications" class="form-label">Sertifikasi &
                                                        Kualifikasi</label>
                                                    <textarea
                                                        class="form-control @error('certifications') is-invalid @enderror"
                                                        id="certifications" name="certifications" rows="3"
                                                        placeholder="Masukkan sertifikasi yang dimiliki (pisahkan dengan koma)">{{ old('certifications', $trainerProfile->certifications) }}</textarea>
                                                    @error('certifications')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload File -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">
                                                <i class="fas fa-upload me-2 text-info"></i>Upload File
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="avatar" class="form-label">Foto Profil</label>
                                                    <input type="file"
                                                        class="form-control @error('avatar') is-invalid @enderror"
                                                        id="avatar" name="avatar" accept="image/*">
                                                    <div class="form-text">
                                                        Format: JPG, PNG, GIF. Maksimal: 2MB
                                                    </div>
                                                    @error('avatar')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    @if($user->avatar)
                                                        <div class="mt-2">
                                                            <small class="text-muted">Foto saat ini:</small>
                                                            <img src="{{ $user->avatar }}" alt="Current Avatar"
                                                                class="rounded ms-2" width="50" height="50">
                                                        </div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <label for="certificate_file" class="form-label">File Sertifikat</label>
                                                    <input type="file"
                                                        class="form-control @error('certificate_file') is-invalid @enderror"
                                                        id="certificate_file" name="certificate_file"
                                                        accept=".pdf,.doc,.docx">
                                                    <div class="form-text">
                                                        Format: PDF, DOC, DOCX. Maksimal: 5MB
                                                    </div>
                                                    @error('certificate_file')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror

                                                    @if(isset($verification) && $verification->certificate)
                                                        <div class="mt-2">
                                                            <small class="text-muted">File saat ini:
                                                                {{ basename($verification->certificate) }}</small>
                                                            @if($verification->status == 'approved')
                                                                <span class="badge bg-success ms-2">Terverifikasi</span>
                                                            @elseif($verification->status == 'pending')
                                                                <span class="badge bg-warning ms-2">Menunggu Verifikasi</span>
                                                            @else
                                                                <span class="badge bg-danger ms-2">Ditolak</span>
                                                            @endif
                                                        </div>
                                                    @else
                                                        <div class="mt-2">
                                                            <small class="text-muted">Belum ada file sertifikat yang
                                                                diupload.</small>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <a href="{{ route('trainer.profile.index') }}"
                                                class="btn btn-outline-secondary">
                                                <i class="fas fa-times me-1"></i>Batal
                                            </a>
                                        </div>
                                        <div>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save me-1"></i>Simpan Perubahan
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Preview image sebelum upload
        document.getElementById('avatar').addEventListener('change', function (e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    // Tambahkan preview jika diperlukan
                    console.log('File selected:', file.name);
                }
                reader.readAsDataURL(file);
            }
        });

        // Validasi form
        document.querySelector('form').addEventListener('submit', function (e) {
            const requiredFields = this.querySelectorAll('[required]');
            let valid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    valid = false;
                    field.classList.add('is-invalid');
                }
            });

            if (!valid) {
                e.preventDefault();
                alert('Harap isi semua field yang wajib diisi!');
            }
        });
    </script>
@endpush