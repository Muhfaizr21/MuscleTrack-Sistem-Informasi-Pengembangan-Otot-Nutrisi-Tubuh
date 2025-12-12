@extends('layouts.trainer')

@section('title', 'Profil Trainer')

@section('content')
<div class="relative max-w-7xl mx-auto space-y-8 p-6">

    {{-- Header Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Total Member --}}
        <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-emerald-300/80 text-sm font-semibold uppercase tracking-wide">Total Member</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['total_members'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-emerald-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-users text-emerald-400 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Program Aktif --}}
        <div class="rounded-2xl border border-blue-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(59,130,246,0.25)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-300/80 text-sm font-semibold uppercase tracking-wide">Program Aktif</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['active_programs'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-dumbbell text-blue-400 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Total Rating --}}
        <div class="rounded-2xl border border-yellow-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(245,158,11,0.25)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-yellow-300/80 text-sm font-semibold uppercase tracking-wide">Total Rating</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ $stats['total_ratings'] }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-star text-yellow-400 text-xl"></i>
                </div>
            </div>
        </div>

        {{-- Rating Rata-rata --}}
        <div class="rounded-2xl border border-purple-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(168,85,247,0.25)] p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-300/80 text-sm font-semibold uppercase tracking-wide">Rating Rata-rata</p>
                    <h3 class="text-3xl font-bold text-white mt-2">{{ number_format($stats['average_rating'], 1) }}/5</h3>
                </div>
                <div class="w-12 h-12 bg-purple-500/20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-purple-400 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Profile Info --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Profile Card --}}
            <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)] p-6">
                {{-- Profile Header --}}
                <div class="flex items-center justify-between mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full"></div>
                    <h2 class="text-xl font-semibold text-white flex-1 ml-3">Informasi Profil</h2>
                </div>

                {{-- Profile Image --}}
                <div class="text-center mb-6">
                    <div class="relative inline-block">
                        @php
                            use Illuminate\Support\Facades\Storage;
                        @endphp
                        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=4f46e5&color=ffffff&size=150' }}"
                            alt="Profile" class="rounded-2xl w-32 h-32 object-cover border-4 border-emerald-400/30 shadow-lg">
                        <span class="absolute -bottom-2 -right-2 w-8 h-8 bg-gradient-to-br from-emerald-400 to-emerald-600 rounded-full border-4 border-gray-900 flex items-center justify-center">
                            @if($verification)
                                <i class="fas fa-{{ $verification->status == 'approved' ? 'check' : ($verification->status == 'pending' ? 'clock' : 'times') }} text-white text-xs"></i>
                            @else
                                <i class="fas fa-times text-white text-xs"></i>
                            @endif
                        </span>
                    </div>
                </div>

                {{-- Profile Details --}}
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-bold text-white mb-2">{{ $user->name }}</h3>
                    <p class="text-emerald-300 mb-3">{{ $trainerProfile->specialization ?? 'Trainer' }}</p>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($verification)
                            {{ $verification->status == 'approved' ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-400/30' :
                               ($verification->status == 'pending' ? 'bg-yellow-500/20 text-yellow-400 border border-yellow-400/30' :
                               'bg-red-500/20 text-red-400 border border-red-400/30') }}
                        @else
                            bg-yellow-500/20 text-yellow-400 border border-yellow-400/30
                        @endif">
                        @if($verification)
                            {{ ucfirst($verification->status) }}
                        @else
                            Belum Verifikasi
                        @endif
                    </span>
                </div>

                {{-- Profile Info Items --}}
                <div class="space-y-4">
                    <div class="flex items-center p-3 rounded-xl bg-gray-800/50 border border-emerald-400/10">
                        <div class="w-10 h-10 bg-emerald-500/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-envelope text-emerald-400"></i>
                        </div>
                        <div>
                            <p class="text-emerald-300/80 text-sm">Email</p>
                            <p class="text-white font-semibold">{{ $user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 rounded-xl bg-gray-800/50 border border-blue-400/10">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-award text-blue-400"></i>
                        </div>
                        <div>
                            <p class="text-blue-300/80 text-sm">Pengalaman</p>
                            <p class="text-white font-semibold">{{ $trainerProfile->experience_years ?? 0 }} Tahun</p>
                        </div>
                    </div>

                    <div class="flex items-center p-3 rounded-xl bg-gray-800/50 border border-yellow-400/10">
                        <div class="w-10 h-10 bg-yellow-500/20 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-star text-yellow-400"></i>
                        </div>
                        <div>
                            <p class="text-yellow-300/80 text-sm">Rating</p>
                            <div class="flex items-center">
                                @php
                                    $rating = $trainerProfile->rating ?? 0;
                                    $avgRating = $stats['average_rating'] ?? 0;
                                    $displayRating = $rating > 0 ? $rating : $avgRating;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= floor($displayRating) ? 'text-yellow-400' : 'text-gray-600' }} mr-1"></i>
                                @endfor
                                <span class="text-white font-semibold ml-2">({{ number_format($displayRating, 1) }})</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Edit Button --}}
                <div class="mt-6">
                    <a href="{{ route('trainer.profile.edit') }}"
                       class="w-full bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-semibold py-3 px-4 rounded-xl transition-all duration-300 flex items-center justify-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-edit mr-2"></i>Edit Profil
                    </a>
                </div>
            </div>

            {{-- Verification Status --}}
            <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)] p-6">
                <div class="flex items-center mb-4">
                    <div class="w-2 h-8 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                    <h2 class="text-xl font-semibold text-white">Status Verifikasi</h2>
                </div>

                @if($verification)
                    <div class="p-4 rounded-xl border border-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-400/30 bg-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-500/10">
                        <div class="flex items-center mb-3">
                            <i class="fas fa-{{ $verification->status == 'approved' ? 'check-circle' : ($verification->status == 'pending' ? 'clock' : 'exclamation-circle') }} text-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-400 mr-2"></i>
                            <strong class="text-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-400">Status: {{ ucfirst($verification->status) }}</strong>
                        </div>

                        @if($verification->admin_feedback)
                            <div class="border-t border-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-400/20 pt-3">
                                <p class="text-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-300 font-semibold mb-2">Feedback Admin:</p>
                                <p class="text-gray-300 text-sm">{{ $verification->admin_feedback }}</p>
                            </div>
                        @endif

                        @if($verification->verified_at)
                            <div class="border-t border-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-400/20 pt-3 mt-3">
                                <p class="text-{{ $verification->status == 'approved' ? 'emerald' : ($verification->status == 'pending' ? 'yellow' : 'red') }}-300 text-sm">
                                    Diverifikasi pada: {{ $verification->verified_at->format('d M Y') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="p-4 rounded-xl border border-yellow-400/30 bg-yellow-500/10">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-400 mr-2"></i>
                            <strong class="text-yellow-400">Status: Belum mengajukan verifikasi</strong>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        {{-- Bio & Details --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- About Me --}}
            <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)] p-6">
                <div class="flex items-center mb-6">
                    <div class="w-2 h-8 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                    <h2 class="text-xl font-semibold text-white">Tentang Saya</h2>
                </div>

                <p class="text-gray-300 leading-relaxed mb-6">
                    {{ $trainerProfile->bio ?? 'Bio belum diisi. Tambahkan bio Anda untuk memperkenalkan diri kepada calon member.' }}
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Certifications --}}
                    <div class="bg-gray-800/50 rounded-xl p-4 border border-emerald-400/10">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-certificate text-blue-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Sertifikasi & Kualifikasi</h3>
                        </div>
                        <div class="text-gray-300">
                            @if($trainerProfile->certifications)
                                {!! nl2br(e($trainerProfile->certifications)) !!}
                            @else
                                <p class="text-gray-500 italic">Belum ada sertifikasi yang diisi.</p>
                            @endif
                        </div>
                    </div>

                    {{-- Personal Info --}}
                    <div class="bg-gray-800/50 rounded-xl p-4 border border-emerald-400/10">
                        <div class="flex items-center mb-3">
                            <div class="w-8 h-8 bg-purple-500/20 rounded-lg flex items-center justify-center mr-2">
                                <i class="fas fa-user text-purple-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-white">Informasi Pribadi</h3>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <p class="text-emerald-300/80 text-sm">Usia</p>
                                <p class="text-white font-semibold">{{ $user->age ?? '-' }}</p>
                            </div>
                            <div>
                                <p class="text-emerald-300/80 text-sm">Gender</p>
                                <p class="text-white font-semibold">{{ $user->gender ? ucfirst($user->gender) : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-emerald-300/80 text-sm">Tinggi</p>
                                <p class="text-white font-semibold">{{ $user->height ? $user->height . ' cm' : '-' }}</p>
                            </div>
                            <div>
                                <p class="text-emerald-300/80 text-sm">Berat</p>
                                <p class="text-white font-semibold">{{ $user->weight ? $user->weight . ' kg' : '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Members --}}
            <div class="rounded-2xl border border-emerald-400/20 bg-gradient-to-br from-gray-900/80 via-gray-900/60 to-gray-800/70 backdrop-blur-xl shadow-[0_0_20px_rgba(16,185,129,0.25)] p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <div class="w-2 h-8 bg-gradient-to-b from-emerald-400 to-emerald-600 rounded-full mr-3"></div>
                        <h2 class="text-xl font-semibold text-white">Member Terbaru</h2>
                    </div>
                    <a href="#" class="bg-emerald-500/20 hover:bg-emerald-500/30 text-emerald-400 border border-emerald-400/30 px-4 py-2 rounded-xl transition-all duration-300">
                        Lihat Semua
                    </a>
                </div>

                @if($recentMembers->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentMembers as $member)
                            <div class="flex items-center justify-between p-4 rounded-xl bg-gray-800/50 border border-emerald-400/10 hover:border-emerald-400/30 transition-all duration-300">
                                <div class="flex items-center">
                                    <img src="{{ $member->avatar ? asset('storage/' . $member->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($member->name) . '&background=4f46e5&color=ffffff&size=150' }}"
                                        alt="{{ $member->name }}" class="rounded-xl w-12 h-12 object-cover mr-4">
                                    <div>
                                        <h4 class="text-white font-semibold">{{ $member->name }}</h4>
                                        <p class="text-emerald-300 text-sm">{{ $member->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-gray-400 text-sm mb-1">Bergabung</p>
                                    <p class="text-white font-semibold">{{ $member->created_at->format('d M Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-800/50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-users text-gray-600 text-2xl"></i>
                        </div>
                        <p class="text-gray-400 mb-4">Belum ada member yang terdaftar.</p>
                        <a href="#" class="bg-gradient-to-r from-emerald-500 to-green-500 hover:from-emerald-600 hover:to-green-600 text-white font-semibold py-2 px-6 rounded-xl transition-all duration-300">
                            Promosikan Layanan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
