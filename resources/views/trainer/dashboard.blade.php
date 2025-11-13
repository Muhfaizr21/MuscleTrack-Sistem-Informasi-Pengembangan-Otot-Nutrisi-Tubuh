@extends('layouts.trainer')

@section('title', 'Dashboard Trainer')

@section('content')
    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="font-display text-4xl md:text-5xl font-bold text-white mb-3 tracking-tight">
            Trainer <span class="text-gradient">Dashboard</span>
        </h1>
        <p class="text-gray-400 text-base md:text-lg max-w-3xl leading-relaxed">
            Selamat datang kembali, <span class="text-emerald-400 font-semibold">{{ Auth::user()->name }}</span> 👋
            <br class="hidden sm:block">
            Gunakan menu di sidebar untuk mengelola member dan program latihan.
        </p>
    </div>

    {{-- Stats Overview (Optional - bisa dihapus jika tidak perlu) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Total Members</p>
                    <p class="text-white text-2xl font-bold mt-1">
                        {{ \App\Models\User::where('trainer_id', Auth::id())->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-emerald-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Active Programs</p>
                    <p class="text-white text-2xl font-bold mt-1">
                        {{ \App\Models\WorkoutPlan::where('trainer_id', Auth::id())->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-blue-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Messages</p>
                    <p class="text-white text-2xl font-bold mt-1">
                        {{ \App\Models\TrainerChat::where('trainer_id', Auth::id())->where('sender_type', 'user')->where('read_status', false)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 21l1.255-3.765A9.863 9.863 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-2xl p-5">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-400 text-sm font-medium">Notifications</p>
                    <p class="text-white text-2xl font-bold mt-1">
                        {{ \App\Models\Notification::where('user_id', Auth::id())->where('read_status', false)->count() }}
                    </p>
                </div>
                <div class="w-12 h-12 bg-yellow-500/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Feature Cards --}}
    <div class="mb-8">
        <h2 class="text-xl font-bold text-white mb-4 flex items-center gap-2">
            <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-emerald-600 rounded-full"></div>
            Menu Utama
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5">

            {{-- Card: Member Management --}}
            <a href="{{ route('trainer.members.index') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-emerald-500/40 hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-emerald-400 smooth-transition mb-1">
                            Member Management
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Kelola dan pantau perkembangan semua member yang kamu bimbing
                        </p>
                    </div>
                </div>
            </a>

            {{-- Card: Communication --}}
            <a href="{{ route('trainer.communication.chat.index') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-blue-500/40 hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 21l1.255-3.765A9.863 9.863 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-blue-400 smooth-transition mb-1">
                            Komunikasi
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Chat langsung dengan member dan pantau notifikasi penting
                        </p>
                    </div>
                </div>
            </a>

            {{-- Card: Program & Nutrition --}}
            @if($firstMember)
                <a href="{{ route('trainer.programs.index', ['memberId' => $firstMember->id]) }}"
                    class="group glass-card rounded-2xl p-6 smooth-transition hover:border-purple-500/40 hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition">
                            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-white group-hover:text-purple-400 smooth-transition mb-1">
                                Program & Nutrition
                            </h3>
                            <p class="text-sm text-gray-400 leading-relaxed">
                                Atur latihan, pola makan, dan rekomendasi nutrisi member
                            </p>
                        </div>
                    </div>
                </a>
            @else
                <div class="glass-card rounded-2xl p-6 opacity-50 cursor-not-allowed">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-gray-500/20 to-gray-600/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-500 mb-1">
                                Program & Nutrition
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Belum ada member yang terhubung
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card: Supplements --}}
            @if($firstMember)
                <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                    class="group glass-card rounded-2xl p-6 smooth-transition hover:border-pink-500/40 hover:shadow-xl hover:shadow-pink-500/10 hover:-translate-y-1">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-pink-500/20 to-pink-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition">
                            <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.363-.44A2 2 0 0115 13.029V11.5a2 2 0 00-2-2h-2a2 2 0 00-2 2v1.53a2 2 0 01-1.043 1.843l-2.363.44a2 2 0 00-1.022.547l-1.84 2.148A2 2 0 004.16 19.92a2 2 0 001.84 1.08h12a2 2 0 001.84-1.08l-1.84-2.148z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-white group-hover:text-pink-400 smooth-transition mb-1">
                                Suplemen
                            </h3>
                            <p class="text-sm text-gray-400 leading-relaxed">
                                Rekomendasikan suplemen sesuai target fitness member
                            </p>
                        </div>
                    </div>
                </a>
            @else
                <div class="glass-card rounded-2xl p-6 opacity-50 cursor-not-allowed">
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 bg-gradient-to-br from-gray-500/20 to-gray-600/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.363-.44A2 2 0 0115 13.029V11.5a2 2 0 00-2-2h-2a2 2 0 00-2 2v1.53a2 2 0 01-1.043 1.843l-2.363.44a2 2 0 00-1.022.547l-1.84 2.148A2 2 0 004.16 19.92a2 2 0 001.84 1.08h12a2 2 0 001.84-1.08l-1.84-2.148z"></path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-500 mb-1">
                                Suplemen
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                Belum ada member yang terhubung
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Card: Trainer Quality --}}
            <a href="{{ route('trainer.quality.verification.status') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-yellow-500/40 hover:shadow-xl hover:shadow-yellow-500/10 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-yellow-500/20 to-yellow-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition">
                        <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-yellow-400 smooth-transition mb-1">
                            Trainer Quality
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Cek status verifikasi, feedback, dan dukungan dari admin
                        </p>
                    </div>
                </div>
            </a>

            {{-- Card: Notifications --}}
            <a href="{{ route('trainer.communication.notifications.index') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-red-500/40 hover:shadow-xl hover:shadow-red-500/10 hover:-translate-y-1">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500/20 to-red-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition relative">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold animate-pulse">
                            {{ $unreadNotificationsCount }}
                        </span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-red-400 smooth-transition mb-1">
                            Notifikasi
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed">
                            Lihat semua notifikasi dan update terbaru
                        </p>
                    </div>
                </div>
            </a>

        </div>
    </div>

    {{-- Footer Info --}}
    <div class="mt-10 glass-card rounded-2xl p-6 text-center">
        <div class="flex items-center justify-center gap-2 text-gray-400 mb-2">
            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
            </svg>
            <p class="text-sm">
                Terima kasih sudah membantu member mencapai tujuan fitness mereka
            </p>
        </div>
        <p class="text-xs text-gray-500">
            MuscleXpert - Your Fitness Partner
        </p>
    </div>
@endsection
