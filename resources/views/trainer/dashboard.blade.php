@extends('layouts.trainer')

@section('title', 'Dashboard Trainer')

@section('content')
    {{-- Enhanced Header Section --}}
    <div class="mb-8 md:mb-12">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-2 h-8 bg-gradient-to-b from-emerald-500 to-emerald-600 rounded-full"></div>
            <h1 class="font-display text-3xl md:text-4xl lg:text-5xl font-bold text-white tracking-tight">
                Trainer <span class="text-gradient">Dashboard</span>
            </h1>
        </div>
        <div class="glass-card rounded-2xl p-6 md:p-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div class="flex-1">
                    <p class="text-gray-400 text-base md:text-lg leading-relaxed">
                        Selamat datang kembali, <span class="text-gradient font-semibold">{{ Auth::user()->name }}</span> 👋
                    </p>
                    <p class="text-gray-500 text-sm mt-2">
                        Gunakan menu di bawah untuk mengelola member dan program latihan dengan mudah.
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-white font-semibold text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-emerald-400 text-xs">Professional Trainer</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Stats Overview --}}
    <div class="mb-8 md:mb-12">
        <h2 class="text-xl font-bold text-white mb-4 md:mb-6 flex items-center gap-3">
            <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-emerald-600 rounded-full"></div>
            Overview Statistics
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
            {{-- Total Members Card --}}
            <div
                class="glass-card rounded-2xl p-5 md:p-6 group hover:border-emerald-500/40 hover:shadow-xl hover:shadow-emerald-500/10 hover:-translate-y-1 smooth-transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-400 text-sm font-medium mb-2">Total Members</p>
                        <p class="text-white text-2xl md:text-3xl font-bold">
                            {{ \App\Models\User::where('trainer_id', Auth::id())->count() }}
                        </p>
                        <p class="text-emerald-400 text-xs mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Active trainees
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 bg-emerald-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 smooth-transition">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Active Programs Card --}}
            <div
                class="glass-card rounded-2xl p-5 md:p-6 group hover:border-blue-500/40 hover:shadow-xl hover:shadow-blue-500/10 hover:-translate-y-1 smooth-transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-400 text-sm font-medium mb-2">Active Programs</p>
                        <p class="text-white text-2xl md:text-3xl font-bold">
                            {{ \App\Models\WorkoutPlan::where('trainer_id', Auth::id())->count() }}
                        </p>
                        <p class="text-blue-400 text-xs mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Running programs
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 bg-blue-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 smooth-transition">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-blue-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Messages Card --}}
            <div
                class="glass-card rounded-2xl p-5 md:p-6 group hover:border-purple-500/40 hover:shadow-xl hover:shadow-purple-500/10 hover:-translate-y-1 smooth-transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-400 text-sm font-medium mb-2">Unread Messages</p>
                        <p class="text-white text-2xl md:text-3xl font-bold">
                            {{ \App\Models\TrainerChat::where('trainer_id', Auth::id())->where('sender_type', 'user')->where('read_status', false)->count() }}
                        </p>
                        <p class="text-purple-400 text-xs mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                            Need attention
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 bg-purple-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 smooth-transition">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-purple-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 21l1.255-3.765A9.863 9.863 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Notifications Card --}}
            <div
                class="glass-card rounded-2xl p-5 md:p-6 group hover:border-yellow-500/40 hover:shadow-xl hover:shadow-yellow-500/10 hover:-translate-y-1 smooth-transition">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-gray-400 text-sm font-medium mb-2">Notifications</p>
                        <p class="text-white text-2xl md:text-3xl font-bold">
                            {{ \App\Models\Notification::where('user_id', Auth::id())->where('read_status', false)->count() }}
                        </p>
                        <p class="text-yellow-400 text-xs mt-2 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            Unread alerts
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 md:w-14 md:h-14 bg-yellow-500/10 rounded-xl flex items-center justify-center group-hover:scale-110 smooth-transition">
                        <svg class="w-6 h-6 md:w-7 md:h-7 text-yellow-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Enhanced Main Feature Cards --}}
    <div class="mb-8 md:mb-12">
        <h2 class="text-xl font-bold text-white mb-4 md:mb-6 flex items-center gap-3">
            <div class="w-1 h-6 bg-gradient-to-b from-emerald-500 to-emerald-600 rounded-full"></div>
            Quick Actions
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-5 md:gap-6">
            {{-- Enhanced Card: Member Management --}}
            <a href="{{ route('trainer.members.index') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-emerald-500/40 hover:shadow-xl hover:shadow-emerald-500/20 hover:-translate-y-2 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-emerald-500/5 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 smooth-transition">
                </div>
                <div class="relative z-10 flex items-start gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-emerald-500/20 to-emerald-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition border border-emerald-500/20">
                        <svg class="w-7 h-7 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-emerald-400 smooth-transition mb-2">
                            Member Management
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed mb-3">
                            Kelola dan pantau perkembangan semua member yang kamu bimbing
                        </p>
                        <span class="inline-flex items-center gap-1 text-emerald-400 text-xs font-medium">
                            Manage members
                            <svg class="w-4 h-4 group-hover:translate-x-1 smooth-transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>

            {{-- Enhanced Card: Communication --}}
            <a href="{{ route('trainer.communication.chat.index') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-blue-500/40 hover:shadow-xl hover:shadow-blue-500/20 hover:-translate-y-2 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-blue-500/5 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 smooth-transition">
                </div>
                <div class="relative z-10 flex items-start gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-blue-500/20 to-blue-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition border border-blue-500/20">
                        <svg class="w-7 h-7 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 21l1.255-3.765A9.863 9.863 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-blue-400 smooth-transition mb-2">
                            Komunikasi
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed mb-3">
                            Chat langsung dengan member dan pantau notifikasi penting
                        </p>
                        <span class="inline-flex items-center gap-1 text-blue-400 text-xs font-medium">
                            Start chatting
                            <svg class="w-4 h-4 group-hover:translate-x-1 smooth-transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>

            {{-- Enhanced Card: Program & Nutrition --}}
            @if($firstMember)
                <a href="{{ route('trainer.programs.index', ['memberId' => $firstMember->id]) }}"
                    class="group glass-card rounded-2xl p-6 smooth-transition hover:border-purple-500/40 hover:shadow-xl hover:shadow-purple-500/20 hover:-translate-y-2 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-purple-500/5 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 smooth-transition">
                    </div>
                    <div class="relative z-10 flex items-start gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-purple-500/20 to-purple-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition border border-purple-500/20">
                            <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-white group-hover:text-purple-400 smooth-transition mb-2">
                                Program & Nutrition
                            </h3>
                            <p class="text-sm text-gray-400 leading-relaxed mb-3">
                                Atur latihan, pola makan, dan rekomendasi nutrisi member
                            </p>
                            <span class="inline-flex items-center gap-1 text-purple-400 text-xs font-medium">
                                Create programs
                                <svg class="w-4 h-4 group-hover:translate-x-1 smooth-transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @else
                <div class="glass-card rounded-2xl p-6 opacity-50 cursor-not-allowed relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gray-500/5 rounded-full -translate-y-10 translate-x-10">
                    </div>
                    <div class="relative z-10 flex items-start gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-gray-500/20 to-gray-600/10 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-500/20">
                            <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-500 mb-2">
                                Program & Nutrition
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                                Belum ada member yang terhubung
                            </p>
                            <span class="inline-flex items-center gap-1 text-gray-600 text-xs font-medium">
                                No members
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Enhanced Card: Supplements --}}
            @if($firstMember)
                <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                    class="group glass-card rounded-2xl p-6 smooth-transition hover:border-pink-500/40 hover:shadow-xl hover:shadow-pink-500/20 hover:-translate-y-2 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-20 h-20 bg-pink-500/5 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 smooth-transition">
                    </div>
                    <div class="relative z-10 flex items-start gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-pink-500/20 to-pink-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition border border-pink-500/20">
                            <svg class="w-7 h-7 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.363-.44A2 2 0 0115 13.029V11.5a2 2 0 00-2-2h-2a2 2 0 00-2 2v1.53a2 2 0 01-1.043 1.843l-2.363.44a2 2 0 00-1.022.547l-1.84 2.148A2 2 0 004.16 19.92a2 2 0 001.84 1.08h12a2 2 0 001.84-1.08l-1.84-2.148z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-white group-hover:text-pink-400 smooth-transition mb-2">
                                Suplemen
                            </h3>
                            <p class="text-sm text-gray-400 leading-relaxed mb-3">
                                Rekomendasikan suplemen sesuai target fitness member
                            </p>
                            <span class="inline-flex items-center gap-1 text-pink-400 text-xs font-medium">
                                Add supplements
                                <svg class="w-4 h-4 group-hover:translate-x-1 smooth-transition" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                    </path>
                                </svg>
                            </span>
                        </div>
                    </div>
                </a>
            @else
                <div class="glass-card rounded-2xl p-6 opacity-50 cursor-not-allowed relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-20 h-20 bg-gray-500/5 rounded-full -translate-y-10 translate-x-10">
                    </div>
                    <div class="relative z-10 flex items-start gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-gray-500/20 to-gray-600/10 rounded-xl flex items-center justify-center flex-shrink-0 border border-gray-500/20">
                            <svg class="w-7 h-7 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.363-.44A2 2 0 0115 13.029V11.5a2 2 0 00-2-2h-2a2 2 0 00-2 2v1.53a2 2 0 01-1.043 1.843l-2.363.44a2 2 0 00-1.022.547l-1.84 2.148A2 2 0 004.16 19.92a2 2 0 001.84 1.08h12a2 2 0 001.84-1.08l-1.84-2.148z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="font-bold text-lg text-gray-500 mb-2">
                                Suplemen
                            </h3>
                            <p class="text-sm text-gray-600 leading-relaxed mb-3">
                                Belum ada member yang terhubung
                            </p>
                            <span class="inline-flex items-center gap-1 text-gray-600 text-xs font-medium">
                                No members
                            </span>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Enhanced Card: Trainer Quality --}}
            <a href="{{ route('trainer.quality.verification.status') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-yellow-500/40 hover:shadow-xl hover:shadow-yellow-500/20 hover:-translate-y-2 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-yellow-500/5 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 smooth-transition">
                </div>
                <div class="relative z-10 flex items-start gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-yellow-500/20 to-yellow-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition border border-yellow-500/20">
                        <svg class="w-7 h-7 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-yellow-400 smooth-transition mb-2">
                            Trainer Quality
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed mb-3">
                            Cek status verifikasi, feedback, dan dukungan dari admin
                        </p>
                        <span class="inline-flex items-center gap-1 text-yellow-400 text-xs font-medium">
                            Check status
                            <svg class="w-4 h-4 group-hover:translate-x-1 smooth-transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>

            {{-- Enhanced Card: Notifications --}}
            <a href="{{ route('trainer.communication.notifications.index') }}"
                class="group glass-card rounded-2xl p-6 smooth-transition hover:border-red-500/40 hover:shadow-xl hover:shadow-red-500/20 hover:-translate-y-2 relative overflow-hidden">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-red-500/5 rounded-full -translate-y-10 translate-x-10 group-hover:scale-150 smooth-transition">
                </div>
                <div class="relative z-10 flex items-start gap-4">
                    <div
                        class="w-14 h-14 bg-gradient-to-br from-red-500/20 to-red-600/10 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:scale-110 smooth-transition border border-red-500/20 relative">
                        <svg class="w-7 h-7 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        @if(isset($unreadNotificationsCount) && $unreadNotificationsCount > 0)
                            <span
                                class="absolute -top-1 -right-1 w-6 h-6 bg-red-500 rounded-full flex items-center justify-center text-white text-xs font-bold animate-pulse border-2 border-gray-900">
                                {{ $unreadNotificationsCount }}
                            </span>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-lg text-white group-hover:text-red-400 smooth-transition mb-2">
                            Notifikasi
                        </h3>
                        <p class="text-sm text-gray-400 leading-relaxed mb-3">
                            Lihat semua notifikasi dan update terbaru
                        </p>
                        <span class="inline-flex items-center gap-1 text-red-400 text-xs font-medium">
                            View alerts
                            <svg class="w-4 h-4 group-hover:translate-x-1 smooth-transition" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Enhanced Footer Info --}}
    <div class="mt-10 md:mt-12 glass-card rounded-2xl p-6 md:p-8 text-center relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
        <div class="flex flex-col items-center gap-4">
            <div class="flex items-center justify-center gap-3 text-gray-400">
                <div
                    class="w-10 h-10 bg-gradient-to-br from-emerald-500/10 to-emerald-600/5 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <p class="text-base md:text-lg">
                    Terima kasih sudah membantu member mencapai tujuan fitness mereka
                </p>
            </div>
            <p class="text-sm text-gray-500">
                MuscleXpert - Your Professional Fitness Partner
            </p>
        </div>
    </div>
@endsection

@section('styles')
    <style>
        /* Enhanced responsive styles for dashboard */
        @media (max-width: 640px) {
            .glass-card {
                margin: 0 -8px;
                border-radius: 16px;
            }

            .text-gradient {
                font-size: 2.5rem;
            }
        }

        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 1024px) {
            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Enhanced hover effects */
        .smooth-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Glass card enhancements */
        .glass-card {
            background: rgba(17, 25, 21, 0.8);
            backdrop-filter: blur(15px) saturate(180%);
            border: 1px solid rgba(0, 255, 170, 0.15);
            box-shadow:
                0 8px 32px rgba(0, 0, 0, 0.3),
                0 0 20px rgba(0, 255, 170, 0.1);
        }

        .glass-card:hover {
            border-color: rgba(0, 255, 170, 0.3);
            box-shadow:
                0 12px 40px rgba(0, 0, 0, 0.4),
                0 0 30px rgba(0, 255, 170, 0.2);
        }

        /* Text gradient enhancement */
        .text-gradient {
            background: linear-gradient(135deg, #00ff9d 0%, #00ffcc 50%, #6ee7b7 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: textGlow 3s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            0% {
                filter: drop-shadow(0 0 5px rgba(0, 255, 170, 0.5));
            }

            100% {
                filter: drop-shadow(0 0 15px rgba(0, 255, 170, 0.8));
            }
        }
    </style>
@endsection