@extends('layouts.user')
@section('title', 'Pembayaran Trainer')

@section('content')
    <div class="max-w-3xl mx-auto mt-10 bg-gray-900/80 border border-gray-800 rounded-2xl shadow-xl p-6 text-gray-100">

        <h1 class="text-2xl font-bold mb-4">💳 Pembayaran Trainer</h1>

        <div class="mb-6">
            <p>Trainer: <span class="text-amber-400 font-semibold">{{ $payment->trainer->name }}</span></p>
            <p>Jumlah:
                <span class="text-green-400 font-semibold">
                    Rp{{ number_format($payment->amount, 0, ',', '.') }}
                </span>
            </p>
            <p>Metode: {{ strtoupper($payment->method) }}</p>
            <p>Status:
                <span class="uppercase {{ $payment->status === 'paid' ? 'text-green-400' : 'text-red-400' }}">
                    {{ $payment->status }}
                </span>
            </p>
            <p>ID Order: <strong>{{ $payment->order_id }}</strong></p>
        </div>

        {{-- Jika sudah dibayar --}}
        @if($payment->status === 'paid')
            <a href="{{ route('user.chat.index') }}"
                class="block w-full text-center bg-amber-400 hover:bg-amber-300 text-black py-3 rounded-full font-semibold transition mt-4">
                Lanjut ke Chat Trainer 💬
            </a>

            {{-- Jika belum dibayar --}}
        @else
            <button id="pay-button"
                class="w-full bg-green-500 hover:bg-green-400 text-black font-semibold py-3 rounded-full transition">
                Bayar Sekarang 💰
            </button>

            {{-- Loading indicator --}}
            <div id="loading" class="hidden text-center mt-4">
                <div class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Memproses pembayaran...
                </div>
            </div>

            {{-- Error message --}}
            <div id="error-message" class="hidden mt-4 p-3 bg-red-500 text-white rounded-lg"></div>
        @endif
    </div>

    {{-- MIDTRANS JS --}}
    <!-- Tetap pakai Sandbox JS -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('pay-button').addEventListener('click', function () {
            console.log('🚀 Starting payment on HOSTING - SANDBOX MODE');

            fetch("{{ route('payment.create') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    payment_id: "{{ $payment->id }}"
                })
            })
                .then(response => response.json())
                .then(data => {
                    console.log('📦 Response from HOSTING:', data);

                    if (!data.success) {
                        alert("Gagal membuat pembayaran: " + data.message);
                        return;
                    }

                    // Launch Midtrans Sandbox
                    window.snap.pay(data.snap_token, {
                        onSuccess: function (result) {
                            console.log('💰 Payment SUCCESS on HOSTING:', result);
                            window.location.href = "https://musclexpert.my.id/user/training/invoice/{{ $payment->id }}";
                        },
                        onPending: function (result) {
                            console.log('⏳ Payment PENDING on HOSTING:', result);
                            window.location.href = "https://musclexpert.my.id/user/training/invoice/{{ $payment->id }}";
                        },
                        onError: function (result) {
                            console.error('❌ Payment ERROR on HOSTING:', result);
                            window.location.href = "https://musclexpert.my.id/user/training/invoice/{{ $payment->id }}";
                        },
                        onClose: function () {
                            console.log('🔒 Payment popup closed on HOSTING');
                            window.location.href = "https://musclexpert.my.id/user/training/invoice/{{ $payment->id }}";
                        }
                    });
                })
                .catch(error => {
                    console.error('❌ Fetch error on HOSTING:', error);
                    alert("Terjadi kesalahan server di hosting.");
                });
        });
    </script>
@endsection