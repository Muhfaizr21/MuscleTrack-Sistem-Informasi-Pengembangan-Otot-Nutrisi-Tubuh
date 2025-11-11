@extends('layouts.user')
@section('title', 'Pembayaran Trainer')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-gray-900/80 border border-gray-800 rounded-2xl shadow-xl p-6 text-gray-100">
        <h1 class="text-2xl font-bold mb-4">💳 Pembayaran Trainer</h1>

        <div class="mb-6">
            <p>Trainer: <span class="text-amber-400 font-semibold">{{ $payment->trainer->name }}</span></p>
            <p>Jumlah: <span
                    class="text-green-400 font-semibold">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span></p>
            <p>Metode: {{ ucfirst($payment->method) }}</p>
            <p>Status: <span class="uppercase {{ $payment->status === 'paid' ? 'text-green-400' : 'text-red-400' }}">
                    {{ $payment->status }}</span></p>
            <p>ID Transaksi: {{ $payment->transaction_id }}</p>
        </div>

        @if($payment->status === 'pending')
            <form method="POST" action="{{ route('user.training.confirm', $payment->id) }}">
                @csrf
                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-400 text-black font-semibold py-3 rounded-full transition">
                    Konfirmasi Pembayaran
                </button>
            </form>
        @else
            <a href="{{ route('user.chat.index') }}"
                class="block w-full text-center bg-amber-400 hover:bg-amber-300 text-black py-3 rounded-full font-semibold transition mt-4">
                Lanjut ke Chat Trainer 💬
            </a>
        @endif
    </div>
@endsection