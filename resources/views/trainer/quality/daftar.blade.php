@extends('layouts.trainer')

@section('title', 'Daftar Verifikasi Trainer')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-blue-700">📋 Pengajuan Verifikasi Trainer</h1>

    <p class="text-gray-600 mb-6">
        Lengkapi data berikut agar admin dapat memverifikasi kamu sebagai trainer resmi MuscleTrack 💪
    </p>

    <form action="{{ route('trainer.quality.feedback.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Sertifikat / Bukti Kualifikasi</label>
            <input type="file" name="certificate" class="mt-1 w-full border rounded p-2">
            <p class="text-sm text-gray-500 mt-1">Format: PDF, JPG, PNG (maks 2MB)</p>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Bio / Pengalaman Melatih</label>
            <textarea name="bio" rows="5" class="w-full border rounded p-2" required>{{ old('bio') }}</textarea>
        </div>

        <button type="submit"
            class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700 transition">
            🚀 Kirim Pengajuan
        </button>
    </form>
</div>
@endsection
