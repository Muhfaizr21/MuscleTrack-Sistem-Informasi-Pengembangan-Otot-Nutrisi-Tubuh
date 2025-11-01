@extends('layouts.trainer')

@section('title', 'Dashboard Trainer')

@section('content')
    <div class="bg-white shadow-md rounded-2xl p-8">
        {{-- 🏋️ Header --}}
        <h1 class="text-3xl font-bold text-blue-700 mb-3">Dashboard Trainer</h1>

        <p class="text-gray-700 mb-6">
            Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> 👋
            Gunakan menu di sidebar untuk mengelola member, menyesuaikan program latihan,
            dan berinteraksi dengan membermu.
        </p>

        @php
            // Ambil satu member pertama milik trainer untuk contoh link dinamis
            $firstMember = \App\Models\User::where('trainer_id', Auth::id())->first();
        @endphp

        {{-- 🔹 Kartu Ringkasan Fitur Utama --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Card: Member Management --}}
            <a href="{{ route('trainer.members.index') }}"
                class="bg-blue-50 hover:bg-blue-100 transition-all rounded-xl p-6 shadow flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-blue-800">👥 Member Management</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Kelola dan pantau perkembangan semua member yang kamu bimbing.
                    </p>
                </div>
            </a>

            {{-- Card: Communication --}}
            <a href="{{ route('trainer.communication.chat.index') }}"
                class="bg-green-50 hover:bg-green-100 transition-all rounded-xl p-6 shadow flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-green-800">💬 Komunikasi</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Chat langsung dengan member dan pantau notifikasi penting.
                    </p>
                </div>
            </a>

            {{-- Card: Program & Nutrition --}}
            @if($firstMember)
                <a href="{{ route('trainer.programs.edit', ['memberId' => $firstMember->id]) }}"
                    class="bg-orange-50 hover:bg-orange-100 transition-all rounded-xl p-6 shadow flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-orange-800">🏋️ Program & Nutrition</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Atur latihan, pola makan, dan rekomendasi nutrisi membermu.
                        </p>
                    </div>
                </a>
            @else
                <div class="bg-gray-100 rounded-xl p-6 shadow text-gray-500 text-center">
                    <h3 class="text-lg font-semibold">🏋️ Program & Nutrition</h3>
                    <p class="text-sm mt-1">Belum ada member yang terhubung.</p>
                </div>
            @endif

            {{-- Card: Supplements --}}
            @if($firstMember)
                <a href="{{ route('trainer.programs.nutrition.index', ['memberId' => $firstMember->id]) }}"
                    class="bg-purple-50 hover:bg-purple-100 transition-all rounded-xl p-6 shadow flex flex-col justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-purple-800">💊 Suplemen</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            Rekomendasikan vitamin atau suplemen sesuai target fitness member.
                        </p>
                    </div>
                </a>
            @else
                <div class="bg-gray-100 rounded-xl p-6 shadow text-gray-500 text-center">
                    <h3 class="text-lg font-semibold">💊 Suplemen</h3>
                    <p class="text-sm mt-1">Belum ada member yang terhubung.</p>
                </div>
            @endif

            {{-- Card: Trainer Quality --}}
            <a href="{{ route('trainer.quality.verification.status') }}"
                class="bg-yellow-50 hover:bg-yellow-100 transition-all rounded-xl p-6 shadow flex flex-col justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-yellow-700">⭐ Trainer Quality</h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Cek status verifikasi, feedback, dan dukungan dari admin.
                    </p>
                </div>
            </a>
        </div>

        {{-- ℹ️ Informasi Tambahan --}}
        <div class="mt-10 text-center text-gray-500 text-sm">
            <p>Terima kasih sudah membantu member mencapai tujuan fitness mereka 💪</p>
        </div>
    </div>
@endsection