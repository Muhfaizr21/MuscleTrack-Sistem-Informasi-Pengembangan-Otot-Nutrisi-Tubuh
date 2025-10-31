@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold text-indigo-700">📊 My Progress</h2>
        <a href="{{ route('user.progress.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-lg">+ Tambah Progress</a>
    </div>

    <table class="w-full border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2">Tanggal</th>
                <th class="p-2">Berat (kg)</th>
                <th class="p-2">Massa Otot (kg)</th>
                <th class="p-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($progress as $p)
                <tr class="border-t">
                    <td class="p-2">{{ $p->recorded_at }}</td>
                    <td class="p-2">{{ $p->weight }}</td>
                    <td class="p-2">{{ $p->muscle_mass }}</td>
                    <td class="p-2">
                        <a href="{{ route('user.progress.edit', $p->id) }}" class="text-indigo-600 hover:underline">Edit</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="text-center text-gray-500 p-3">Belum ada progress.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
