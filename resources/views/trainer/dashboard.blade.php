@extends('layouts.trainer')

@section('title', 'Dashboard Trainer')

@section('content')
    {{--
      Header "Ciamik" (font-serif & aksen emas)
      Kita HAPUS navbar "Coach Andika | Logout" yang berantakan itu.
    --}}
    <h1 class="font-serif text-3xl font-bold text-white mb-3">
        Trainer <span class="text-amber-400">Dashboard</span>
    </h1>

    <p class="text-gray-300 mb-6 max-w-2xl">
        Selamat datang kembali, <strong class="text-amber-400">{{ Auth::user()->name }}</strong> 👋
        Gunakan menu di sidebar untuk mengelola member, menyesuaikan program latihan,
        dan berinteraksi dengan membermu.
    </p>

    {{--
      🔹 Kartu "Kaca Liar" (Style "Dark Premium" Ciamik)
      Menggantikan kartu hitam Anda yang membosankan
    --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Card: Member Management --}}
        <a href="{{ route('trainer.members.index') }}"
            class="group bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 transition-all
                   hover:border-amber-400/50 hover:shadow-2xl hover:shadow-amber-500/10">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">
                    👥 Member Management
                </h3>
                <p class="text-sm text-gray-400 mt-2">
                    Kelola dan pantau perkembangan semua member yang kamu bimbing.
                </p>
            </div>
        </a>

        {{-- Card: Communication --}}
        <a href="{{ route('trainer.communication.chat.index') }}"
            class="group bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 transition-all
                   hover:border-amber-400/50 hover:shadow-2xl hover:shadow-amber-500/10">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">
                    💬 Komunikasi
                </h3>
                <p class="text-sm text-gray-400 mt-2">
                    Chat langsung dengan member dan pantau notifikasi penting.
                </p>
            </div>
        </a>

        {{-- Card: Program & Nutrition (Logika @if Anda aman) --}}
        @if($firstMember)
            <a href="{{ route('trainer.programs.edit', ['memberId' => $firstMember->id]) }}"
                class="group bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 transition-all
                       hover:border-amber-400/50 hover:shadow-2xl hover:shadow-amber-500/10">
                <div>
                    <h3 class="font-serif text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">
                        🏋️ Program & Nutrition
                    </h3>
                    <p class="text-sm text-gray-400 mt-2">
                        Atur latihan, pola makan, dan rekomendasi nutrisi membermu.
                    </p>
                </div>
            </a>
        @else
            {{-- Kartu Disabled (Style "Kaca Liar") --}}
            <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 text-center opacity-60">
                <h3 class="font-serif text-2xl font-bold text-gray-400">🏋️ Program & Nutrition</h3>
                <p class="text-sm text-gray-500 mt-2">Belum ada member yang terhubung.</p>
            </div>
        @endif

        {{-- Card: Supplements (Logika @if Anda aman) --}}
        @if($firstMember)
            <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                class="group bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 transition-all
                       hover:border-amber-400/50 hover:shadow-2xl hover:shadow-amber-500/10">
                <div>
                    <h3 class="font-serif text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">
                        💊 Suplemen
                    </h3>
                    <p class="text-sm text-gray-400 mt-2">
                        Rekomendasikan vitamin atau suplemen sesuai target fitness member.
                    </p>
                </div>
            </a>
        @else
             {{-- Kartu Disabled (Style "Kaca Liar") --}}
            <div class="bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 text-center opacity-60">
                <h3 class="font-serif text-2xl font-bold text-gray-400">💊 Suplemen</h3>
                <p class="text-sm text-gray-500 mt-2">Belum ada member yang terhubung.</p>
            </div>
        @endif

        {{-- Card: Trainer Quality --}}
        <a href="{{ route('trainer.quality.verification.status') }}"
            class="group bg-black/70 backdrop-blur-lg border border-gray-700/50 rounded-xl p-6 transition-all
                   hover:border-amber-400/50 hover:shadow-2xl hover:shadow-amber-500/10">
            <div>
                <h3 class="font-serif text-2xl font-bold text-white group-hover:text-amber-400 transition-colors">
                    ⭐ Trainer Quality
                </h3>
                <p class="text-sm text-gray-400 mt-2">
                    Cek status verifikasi, feedback, dan dukungan dari admin.
                </p>
            </div>
        </a>

        {{-- Kartu "Asymmetrical Gold" (Hanya untuk estetika) --}}
        <div class="hidden lg:block bg-gradient-to-tr from-amber-500/10 via-black/0 to-black/0
                    border border-gray-700/50 rounded-xl p-6 opacity-50">
            <h3 class="font-serif text-2xl font-bold text-amber-400/50">
                MuscleXpert
            </h3>
        </div>
    </div>

    {{-- ℹ️ Informasi Tambahan (Style "Dark Premium") --}}
    <div class="mt-10 text-center text-gray-400 text-sm">
        <p>Terima kasih sudah membantu member mencapai tujuan fitness mereka 💪</p>
    </div>
@endsection
