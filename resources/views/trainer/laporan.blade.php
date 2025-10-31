@extends('layouts.app')

@section('title', 'Laporan Peserta')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Laporan Peserta
    </h2>
@endsection

@section('content')
    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <h3 class="text-lg font-semibold mb-3 text-yellow-700">Laporan Perkembangan Peserta</h3>
        <p class="text-gray-600 mb-4">
            Pantau perkembangan otot, berat badan, dan catatan latihan peserta di halaman ini.
        </p>

        <div class="border-t pt-4">
            <p class="text-sm text-gray-500 italic">💡 Tambahkan grafik progres atau tabel laporan di sini.</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('trainer.dashboard') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
