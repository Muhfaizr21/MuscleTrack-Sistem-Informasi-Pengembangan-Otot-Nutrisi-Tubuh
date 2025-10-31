@extends('layouts.app')

@section('title', 'Data Nutrisi')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Data Nutrisi
    </h2>
@endsection

@section('content')
    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <h3 class="text-lg font-semibold mb-3 text-green-700">Atur Nutrisi & Rencana Makan</h3>
        <p class="text-gray-600 mb-4">
            Buat dan kelola rencana nutrisi peserta berdasarkan kebutuhan kalori dan makronutrien mereka.
        </p>

        <div class="border-t pt-4">
            <p class="text-sm text-gray-500 italic">💡 Tambahkan form input nutrisi atau daftar menu di sini.</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('trainer.dashboard') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
