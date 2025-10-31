@extends('layouts.app')

@section('title', 'Data Latihan')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Data Latihan
    </h2>
@endsection

@section('content')
    <div class="bg-white shadow-sm sm:rounded-lg p-6 text-gray-900">
        <h3 class="text-lg font-semibold mb-3 text-blue-700">Kelola Jadwal Latihan</h3>
        <p class="text-gray-600 mb-4">
            Di sini kamu bisa melihat, menambah, atau mengedit jadwal latihan dan progres peserta.
        </p>

        <div class="border-t pt-4">
            <p class="text-sm text-gray-500 italic">💡 Fitur CRUD latihan bisa kamu tambahkan di sini.</p>
        </div>

        <div class="mt-6">
            <a href="{{ route('trainer.dashboard') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
@endsection
