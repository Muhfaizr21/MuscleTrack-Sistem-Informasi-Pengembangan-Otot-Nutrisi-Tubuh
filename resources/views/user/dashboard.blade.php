@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Halo, {{ Auth::user()->name }}!</h1>

    <div class="card p-4 shadow-sm">
        <h3>Menu User</h3>
        <ul>
            <li><a href="{{ route('user.dashboard') }}">Dashboard</a></li>
            <li><a href="#">Lihat Latihan</a></li>
            <li><a href="#">Pantau Progress</a></li>
            <li><a href="#">Cek Nutrisi & Diet</a></li>
        </ul>
    </div>
</div>
@endsection
