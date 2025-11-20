@extends('layouts.user')
@section('title', 'Invoice Pembayaran')

@section('content')
<div class="max-w-4xl mx-auto mt-6 bg-gray-900/80 border border-gray-800 rounded-2xl shadow-xl p-6 text-gray-100">

    {{-- Tambahkan di bagian atas invoice --}}
<div class="text-center mb-4">
    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-purple-500/20 text-purple-400 border border-purple-500/30">
        🧪 SANDBOX MODE - TESTING
    </span>
</div>
    <!-- Header Invoice -->
    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-amber-400">INVOICE PEMBAYARAN</h1>
        <p class="text-gray-400 mt-2">Detail informasi pembayaran Anda</p>
    </div>

    <!-- Status Badge -->
    <div class="text-center mb-8">
        @switch($payment->status)
            @case('paid')
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-green-500/20 text-green-400 border border-green-500/30">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                    PEMBAYARAN BERHASIL
                </span>
                @break
            @case('pending')
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-yellow-500/20 text-yellow-400 border border-yellow-500/30">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    MENUNGGU PEMBAYARAN
                </span>
                @break
            @case('failed')
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-red-500/20 text-red-400 border border-red-500/30">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    PEMBAYARAN GAGAL
                </span>
                @break
            @default
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium bg-gray-500/20 text-gray-400 border border-gray-500/30">
                    STATUS TIDAK DIKETAHUI
                </span>
        @endswitch
    </div>

    <!-- Informasi Pembayaran -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Detail Pesanan -->
        <div class="bg-gray-800/50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-amber-400 mb-4">📦 Detail Pesanan</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">Trainer:</span>
                    <span class="font-medium">{{ $payment->trainer->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Spesialisasi:</span>
                    <span class="font-medium">{{ $payment->trainer->trainerProfile->specialization ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">ID Pesanan:</span>
                    <span class="font-mono text-sm">{{ $payment->order_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Tanggal Pesan:</span>
                    <span class="font-medium">{{ $payment->created_at->format('d M Y H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Detail Pembayaran -->
        <div class="bg-gray-800/50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-amber-400 mb-4">💰 Detail Pembayaran</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-400">Metode:</span>
                    <span class="font-medium uppercase">{{ $payment->method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Jumlah:</span>
                    <span class="font-medium text-green-400">Rp{{ number_format($payment->amount, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Status:</span>
                    <span class="font-medium uppercase {{ $payment->status === 'paid' ? 'text-green-400' : ($payment->status === 'pending' ? 'text-yellow-400' : 'text-red-400') }}">
                        {{ $payment->status }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Durasi Akses:</span>
                    <span class="font-medium">30 Hari</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Informasi Status -->
    <div class="bg-gray-800/50 rounded-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-amber-400 mb-4">ℹ️ Informasi Status</h3>
        
        @switch($payment->status)
            @case('paid')
                <div class="bg-green-500/10 border border-green-500/30 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-green-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-medium text-green-400">Pembayaran Berhasil!</h4>
                            <p class="text-green-300 text-sm mt-1">
                                Pembayaran Anda telah berhasil diproses. Anda sekarang memiliki akses penuh ke trainer 
                                <strong>{{ $payment->trainer->name }}</strong> selama 30 hari.
                            </p>
                        </div>
                    </div>
                </div>
                @break
            
            @case('pending')
                <div class="bg-yellow-500/10 border border-yellow-500/30 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-yellow-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-medium text-yellow-400">Menunggu Pembayaran</h4>
                            <p class="text-yellow-300 text-sm mt-1">
                                Pesanan Anda sedang menunggu pembayaran. Silakan selesaikan pembayaran Anda untuk mengaktifkan akses trainer.
                            </p>
                        </div>
                    </div>
                </div>
                @break
            
            @case('failed')
                <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h4 class="font-medium text-red-400">Pembayaran Gagal</h4>
                            <p class="text-red-300 text-sm mt-1">
                                Pembayaran Anda gagal diproses. Silakan coba lagi atau hubungi customer service jika masalah berlanjut.
                            </p>
                        </div>
                    </div>
                </div>
                @break
        @endswitch
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
        @if($payment->status === 'paid')
            <a href="{{ route('user.dashboard') }}" 
               class="bg-green-500 hover:bg-green-400 text-white font-semibold py-3 px-6 rounded-full transition text-center">
                🏠 Ke Dashboard
            </a>
            <a href="{{ route('user.chat.index') }}" 
               class="bg-amber-500 hover:bg-amber-400 text-white font-semibold py-3 px-6 rounded-full transition text-center">
                💬 Chat Trainer
            </a>
        @elseif($payment->status === 'pending')
            <button onclick="refreshStatus()" 
                    class="bg-blue-500 hover:bg-blue-400 text-white font-semibold py-3 px-6 rounded-full transition text-center">
                🔄 Cek Status
            </button>
            <a href="{{ route('user.training.payment', $payment->id) }}" 
               class="bg-amber-500 hover:bg-amber-400 text-white font-semibold py-3 px-6 rounded-full transition text-center">
                💳 Bayar Sekarang
            </a>
        @else
            <a href="{{ route('user.training.payment', $payment->id) }}" 
               class="bg-amber-500 hover:bg-amber-400 text-white font-semibold py-3 px-6 rounded-full transition text-center">
                🔄 Coba Lagi
            </a>
        @endif
        
        <a href="{{ route('user.training.index') }}" 
           class="bg-gray-600 hover:bg-gray-500 text-white font-semibold py-3 px-6 rounded-full transition text-center">
            📋 Lihat Trainer Lain
        </a>
    </div>

    <!-- Informasi Tambahan -->
    <div class="mt-8 text-center text-sm text-gray-400">
        <p>Butuh bantuan? Hubungi customer service kami di <strong>support@muscletrack.com</strong></p>
        <p class="mt-2">Invoice ID: <strong>{{ $payment->id }}</strong> | Dibuat: {{ $payment->created_at->format('d M Y H:i') }}</p>
    </div>
</div>

<script>
function refreshStatus() {
    fetch("{{ route('user.training.refresh-status', $payment->id) }}")
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload halaman untuk update status
                window.location.reload();
            } else {
                alert('Gagal memuat status terbaru');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memuat status');
        });
}

// Auto-refresh setiap 30 detik untuk status pending
@if($payment->status === 'pending')
setTimeout(() => {
    refreshStatus();
}, 30000);
@endif
</script>
@endsection