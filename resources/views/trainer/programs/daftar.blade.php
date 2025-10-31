@extends('layouts.trainer')

@section('title', 'Daftar Sebagai Trainer')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6">
    <h1 class="text-2xl font-semibold mb-4">🧾 Pendaftaran Trainer</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
    @elseif(session('warning'))
        <div class="bg-yellow-100 text-yellow-800 p-3 rounded mb-4">{{ session('warning') }}</div>
    @endif

    @if($request)
        <p>Status pengajuan Anda saat ini:
            <span class="font-semibold 
                {{ $request->status === 'pending' ? 'text-yellow-600' : ($request->status === 'approved' ? 'text-green-600' : 'text-red-600') }}">
                {{ ucfirst($request->status) }}
            </span>
        </p>

        @if($request->status === 'pending')
            <p class="text-gray-600 mt-2">⏳ Mohon tunggu persetujuan admin.</p>
        @elseif($request->status === 'rejected')
            <p class="text-red-600 mt-2">❌ Pengajuan Anda ditolak. Silakan ajukan ulang.</p>
        @endif
    @else
        <form action="{{ route('trainer.programs.ajukan') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label for="bio" class="block font-medium">Deskripsi & Pengalaman</label>
                <textarea name="bio" id="bio" rows="4" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label for="certificate" class="block font-medium">Sertifikat / Dokumen Pendukung (opsional)</label>
                <input type="file" name="certificate" id="certificate" class="w-full border rounded p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Ajukan Verifikasi
            </button>
        </form>
    @endif
</div>
@endsection
