@extends('layouts.user')

@section('content')
<div class="bg-white shadow-md rounded-2xl p-6 text-center">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4">🍗 Protein Tracker</h2>
    @if($proteinNeed)
        <p>Kebutuhan protein harianmu adalah 
            <span class="text-indigo-600 font-bold">{{ $proteinNeed }} gram</span>.
        </p>
    @else
        <p class="text-gray-500">Lengkapi data berat badan di profil untuk menghitung kebutuhan protein.</p>
    @endif
</div>
@endsection
