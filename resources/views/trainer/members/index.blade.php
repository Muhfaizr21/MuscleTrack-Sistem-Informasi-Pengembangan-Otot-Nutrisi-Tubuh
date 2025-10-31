@extends('layouts.trainer')

@section('title', 'Daftar Member')

@section('content')
<h1 class="text-2xl font-bold mb-4">👥 Daftar Member</h1>

@if($members->isEmpty())
    <p class="text-gray-600">Belum ada member di bawah bimbinganmu.</p>
@else
    <table class="w-full bg-white shadow rounded-lg">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Jumlah Log</th>
                <th class="p-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($members as $member)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-3">{{ $member->name }}</td>
                <td class="p-3">{{ $member->email }}</td>
                <td class="p-3">{{ $member->progress_logs_count }} log</td>
                <td class="p-3">
                    <a href="{{ route('trainer.members.show', $member->id) }}" 
                       class="text-blue-600 hover:underline">Lihat Detail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endif
@endsection
