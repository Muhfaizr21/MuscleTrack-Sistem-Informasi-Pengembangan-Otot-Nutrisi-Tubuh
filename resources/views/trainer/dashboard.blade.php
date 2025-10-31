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
            @include('trainer.partials.card-latihan')
            @include('trainer.partials.card-nutrisi')
            @include('trainer.partials.card-laporan')
        </div>
    </div>
@endsection
