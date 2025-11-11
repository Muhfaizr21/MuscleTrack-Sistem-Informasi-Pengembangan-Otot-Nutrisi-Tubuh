@extends('layouts.user')
@section('title', 'Detail Trainer')

@section('content')
<div class="max-w-4xl mx-auto mt-8 bg-gray-900/80 border border-gray-800 rounded-2xl shadow-xl p-6 text-gray-100">
    <div class="flex items-center gap-5 mb-6">
        <div class="w-20 h-20 bg-amber-400/20 rounded-full flex items-center justify-center text-3xl text-amber-400 font-bold">
            {{ strtoupper(substr($trainer->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="text-2xl font-bold">{{ $trainer->name }}</h1>
            <p class="text-amber-400">{{ $trainer->trainerProfile->speciality ?? 'Trainer Profesional' }}</p>
        </div>
    </div>

    <p class="text-gray-300 leading-relaxed mb-6">{{ $trainer->trainerProfile->bio ?? 'Belum ada bio.' }}</p>

    <div class="bg-gray-800 rounded-xl p-4 mb-6">
        <p class="text-sm text-gray-400">💪 Pengalaman: {{ $trainer->trainerProfile->experience_years ?? 'N/A' }} tahun</p>
        <p class="text-sm text-gray-400">📜 Sertifikasi: {{ $trainer->trainerProfile->certifications ?? 'Tidak ada data' }}</p>
        <p class="text-sm text-gray-400">⭐ Rating: {{ $trainer->trainerProfile->rating ?? '-' }}/5</p>
    </div>

    <form action="{{ route('user.training.order', $trainer->id) }}" method="POST">
        @csrf
        <button type="submit"
                class="w-full bg-amber-400 text-black py-3 rounded-full font-semibold hover:bg-amber-300 transition">
            Pesan Sekarang - Rp150.000
        </button>
    </form>
</div>
@endsection
