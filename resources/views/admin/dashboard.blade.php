@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Selamat datang, Admin {{ Auth::user()->name }}!</h1>

    <div class="card p-4 shadow-sm">
        <h3>Menu Admin</h3>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li><a href="#">Kelola Pengguna</a></li>
            <li><a href="#">Laporan Aktivitas</a></li>
            <li><a href="#">Pengaturan Sistem</a></li>
        </ul>
    </div>
</div>
@endsection
