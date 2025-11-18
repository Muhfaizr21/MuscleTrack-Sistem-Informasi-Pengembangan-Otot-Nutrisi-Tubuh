@extends('layouts.trainer')

@section('title', 'Profil Trainer')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Stats -->
        <div class="row mb-4">
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card gradient-card-1">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Total Member</p>
                                    <h5 class="font-weight-bolder text-white">{{ $stats['total_members'] }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-white shadow-primary text-center rounded-circle">
                                    <i class="fas fa-users text-primary text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card gradient-card-2">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Program Aktif</p>
                                    <h5 class="font-weight-bolder text-white">{{ $stats['active_programs'] }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-white shadow-danger text-center rounded-circle">
                                    <i class="fas fa-dumbbell text-danger text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                <div class="card gradient-card-3">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Total Rating</p>
                                    <h5 class="font-weight-bolder text-white">{{ $stats['total_ratings'] }}</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-white shadow-success text-center rounded-circle">
                                    <i class="fas fa-star text-success text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card gradient-card-4">
                    <div class="card-body p-3">
                        <div class="row">
                            <div class="col-8">
                                <div class="numbers">
                                    <p class="text-sm mb-0 text-uppercase font-weight-bold text-white">Rating Rata-rata</p>
                                    <h5 class="font-weight-bolder text-white">
                                        {{ number_format($stats['average_rating'], 1) }}/5</h5>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="icon icon-shape bg-white shadow-info text-center rounded-circle">
                                    <i class="fas fa-chart-line text-info text-lg opacity-10"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Profile Info -->
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent pb-3">
                        <h5 class="mb-0">Informasi Profil</h5>
                    </div>
                    <div class="card-body pt-0">
                        <div class="text-center mb-4">
                            <div class="position-relative d-inline-block">
                                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4f46e5&color=ffffff&size=150' }}"
                                    alt="Profile" class="rounded-circle img-fluid border border-4 border-white shadow"
                                    style="width: 150px; height: 150px; object-fit: cover;">
                                <span
                                    class="position-absolute bottom-0 end-0 bg-{{ $user->verification_status == 'approved' ? 'success' : ($user->verification_status == 'pending' ? 'warning' : 'danger') }} rounded-circle p-2 border border-3 border-white">
                                    <i
                                        class="fas fa-{{ $user->verification_status == 'approved' ? 'check' : ($user->verification_status == 'pending' ? 'clock' : 'times') }} text-white fs-6"></i>
                                </span>
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <h4 class="mb-1">{{ $user->name }}</h4>
                            <p class="text-muted mb-2">{{ $trainerProfile->specialization ?? 'Trainer' }}</p>
                            <span
                                class="badge bg-{{ $user->verification_status == 'approved' ? 'success' : ($user->verification_status == 'pending' ? 'warning' : 'danger') }} fs-6">
                                {{ ucfirst($user->verification_status) }}
                            </span>
                        </div>

                        <div class="profile-info">
                            <div class="info-item d-flex align-items-center mb-3">
                                <div class="icon-container bg-light-primary rounded p-2 me-3">
                                    <i class="fas fa-envelope text-primary"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <strong>{{ $user->email }}</strong>
                                </div>
                            </div>

                            <div class="info-item d-flex align-items-center mb-3">
                                <div class="icon-container bg-light-success rounded p-2 me-3">
                                    <i class="fas fa-award text-success"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Pengalaman</small>
                                    <strong>{{ $trainerProfile->experience_years ?? 0 }} Tahun</strong>
                                </div>
                            </div>

                            <div class="info-item d-flex align-items-center mb-3">
                                <div class="icon-container bg-light-warning rounded p-2 me-3">
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block">Rating</small>
                                    <div>
                                        @for($i = 1; $i <= 5; $i++)
                                            <i
                                                class="fas fa-star{{ $i <= ($trainerProfile->rating ?? 0) ? ' text-warning' : ' text-light' }}"></i>
                                        @endfor
                                        <span class="ms-1">({{ number_format($trainerProfile->rating ?? 0, 1) }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('trainer.profile.edit') }}" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-edit me-2"></i>Edit Profil
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Verification Status -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-transparent">
                        <h6 class="mb-0">Status Verifikasi</h6>
                    </div>
                    <div class="card-body">
                        @if($verification)
                            <div
                                class="alert alert-{{ $verification->status == 'approved' ? 'success' : ($verification->status == 'pending' ? 'warning' : 'danger') }} border-0">
                                <div class="d-flex align-items-center">
                                    <i
                                        class="fas fa-{{ $verification->status == 'approved' ? 'check-circle' : ($verification->status == 'pending' ? 'clock' : 'exclamation-circle') }} me-2"></i>
                                    <strong>Status: {{ ucfirst($verification->status) }}</strong>
                                </div>
                                @if($verification->admin_feedback)
                                    <hr class="my-2">
                                    <p class="mb-1"><strong>Feedback Admin:</strong></p>
                                    <p class="mb-0">{{ $verification->admin_feedback }}</p>
                                @endif
                                @if($verification->verified_at)
                                    <hr class="my-2">
                                    <p class="mb-0"><small>Diverifikasi pada:
                                            {{ $verification->verified_at->format('d M Y') }}</small></p>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning border-0">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <strong>Status: Belum mengajukan verifikasi</strong>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Bio & Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent">
                        <h5 class="mb-0">Tentang Saya</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text fs-6">
                            {{ $trainerProfile->bio ?? 'Bio belum diisi. Tambahkan bio Anda untuk memperkenalkan diri kepada calon member.' }}
                        </p>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-certificate me-2"></i>Sertifikasi & Kualifikasi
                                </h6>
                                <div class="bg-light rounded p-3">
                                    @if($trainerProfile->certifications)
                                        {!! nl2br(e($trainerProfile->certifications)) !!}
                                    @else
                                        <p class="text-muted mb-0">Belum ada sertifikasi yang diisi.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h6 class="text-primary mb-3">
                                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                                </h6>
                                <div class="bg-light rounded p-3">
                                    <div class="row">
                                        <div class="col-6 mb-2">
                                            <small class="text-muted d-block">Usia</small>
                                            <strong>{{ $user->age ?? '-' }}</strong>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="text-muted d-block">Gender</small>
                                            <strong>{{ $user->gender ? ucfirst($user->gender) : '-' }}</strong>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="text-muted d-block">Tinggi</small>
                                            <strong>{{ $user->height ? $user->height . ' cm' : '-' }}</strong>
                                        </div>
                                        <div class="col-6 mb-2">
                                            <small class="text-muted d-block">Berat</small>
                                            <strong>{{ $user->weight ? $user->weight . ' kg' : '-' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Members -->
                <div class="card shadow-sm border-0 mt-4">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Member Terbaru</h5>
                        <a href="#" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($recentMembers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Bergabung</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentMembers as $member)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $member->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=4f46e5&color=ffffff&size=32' }}"
                                                            alt="{{ $member->name }}" class="rounded-circle me-2" width="32"
                                                            height="32">
                                                        {{ $member->name }}
                                                    </div>
                                                </td>
                                                <td>{{ $member->email }}</td>
                                                <td>{{ $member->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye me-1"></i>Lihat
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-users fs-1 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada member yang terdaftar.</p>
                                <a href="#" class="btn btn-primary">Promosikan Layanan</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .gradient-card-1 {
            background: linear-gradient(135deg, #4f46e5 0%, #7c73e6 100%);
        }

        .gradient-card-2 {
            background: linear-gradient(135deg, #ef4444 0%, #f87171 100%);
        }

        .gradient-card-3 {
            background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
        }

        .gradient-card-4 {
            background: linear-gradient(135deg, #06b6d4 0%, #67e8f9 100%);
        }

        .icon-container {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .bg-light-primary {
            background-color: rgba(79, 70, 229, 0.1);
        }

        .bg-light-success {
            background-color: rgba(16, 185, 129, 0.1);
        }

        .bg-light-warning {
            background-color: rgba(245, 158, 11, 0.1);
        }
    </style>
@endpush