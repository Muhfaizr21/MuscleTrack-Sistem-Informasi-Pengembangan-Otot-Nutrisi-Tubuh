@extends('layouts.app')

@section('title', 'Dashboard Trainer')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard Trainer
    </h2>
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
        <p>Selamat datang, <strong>{{ Auth::user()->name }}</strong>!</p>
        <p class="mt-2 text-gray-700">
            Ini adalah halaman dashboard khusus <strong>Trainer</strong>.
        </p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Data Latihan -->
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <h3 class="text-lg font-semibold text-blue-700">Data Latihan</h3>
                <p class="text-sm text-gray-600 mt-2">Kelola jadwal latihan dan progres peserta.</p>
                <a href="{{ route('trainer.latihan.index') }}" class="mt-3 inline-block text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Lihat Data →
                </a>
            </div>

            <!-- Card 2: Data Nutrisi -->
            <div class="bg-green-50 border border-green-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <h3 class="text-lg font-semibold text-green-700">Data Nutrisi</h3>
                <p class="text-sm text-gray-600 mt-2">Atur kebutuhan nutrisi dan rekomendasi makanan.</p>
                <a href="{{ route('trainer.nutrisi.index') }}" class="mt-3 inline-block text-green-600 hover:text-green-800 text-sm font-medium">
                    Kelola Nutrisi →
                </a>
            </div>

            <!-- Card 3: Laporan Peserta -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-5 shadow-sm hover:shadow-md transition">
                <h3 class="text-lg font-semibold text-yellow-700">Laporan Peserta</h3>
                <p class="text-sm text-gray-600 mt-2">Lihat perkembangan otot dan catatan latihan peserta.</p>
                <a href="{{ route('trainer.laporan.index') }}" class="mt-3 inline-block text-yellow-600 hover:text-yellow-800 text-sm font-medium">
                    Lihat Laporan →
                </a>
            </div>
        </div>
    </div>
@endsection
