@extends('layouts.trainer')

@section('title', 'Status Verifikasi Trainer')

@section('content')
<div class="bg-white shadow-md rounded-lg p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4 text-blue-700">🔍 Status Verifikasi Trainer</h1>

    @if($verification)
        <p><strong>Status:</strong>
            <span class="@if($verification->status === 'approved') text-green-600 @elseif($verification->status === 'rejected') text-red-600 @else text-yellow-600 @endif">
                {{ strtoupper($verification->status) }}
            </span>
        </p>

        @if($verification->admin_feedback)
            <div class="mt-3 p-3 bg-gray-100 rounded">
                <strong>Feedback Admin:</strong>
                <p class="text-gray-700">{{ $verification->admin_feedback }}</p>
            </div>
        @endif

        <p class="mt-4 text-gray-600">
            Dikirim pada: {{ $verification->created_at->format('d M Y, H:i') }}
        </p>

        @if($verification->status === 'pending')
            <p class="mt-4 text-yellow-700">⏳ Menunggu persetujuan admin...</p>
        @endif

    @else
        <p class="text-gray-600">Kamu belum mengajukan verifikasi.</p>
        <a href="{{ route('trainer.quality.feedback.index') }}" class="text-blue-600 hover:underline">
            Klik di sini untuk mengajukan verifikasi.
        </a>
    @endif
</div>
@endsection
