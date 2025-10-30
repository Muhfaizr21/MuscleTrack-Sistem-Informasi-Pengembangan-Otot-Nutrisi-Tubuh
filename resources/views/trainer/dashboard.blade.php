@extends('layouts.app')

@section('title', 'Trainer Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Selamat datang, Trainer {{ Auth::user()->name }}!</h1>

    <div class="card p-4 shadow-sm">
        <h3>Menu Trainer</h3>
        <ul>
            <li><a href="{{ route('trainer.dashboard') }}">Dashboard</a></li>
            <li><a href="#">Kelola Latihan</a></li>
            <li><a href="#">Pantau Progress User</a></li>
            <li><a href="#">Buat Panduan Nutrisi</a></li>
        </ul>
    </div>
</div>
@endsection
