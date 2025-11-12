<x-layouts.landing>
    @section('styles')
    <style>
        /* === NeoFit AI Contact — Enhanced Dark Theme === */

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-slow {
            0%, 100% {
                opacity: 0.1;
            }
            50% {
                opacity: 0.2;
            }
        }

        .animate-fade-in-up {
            opacity: 0;
            animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
        }

        .animate-pulse-slow {
            animation: pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Background dengan efek yang lebih dalam */
        .hero-bg {
            background: linear-gradient(135deg, #020617 0%, #0f172a 50%, #1e293b 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-glow {
            background-image:
                radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.08) 0%, transparent 50%),
                url('https://images.unsplash.com/photo-1534438327276-14e5300c3a48?q=80&w=2670&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            opacity: 0.4;
        }

        /* Glass panel yang lebih modern */
        .glass-panel {
            background: rgba(15, 23, 42, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(71, 85, 105, 0.3);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.6);
        }

        /* Input fields yang lebih konsisten */
        .input-glass {
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(71, 85, 105, 0.4);
            color: #f1f5f9;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-glass::placeholder {
            color: #64748b;
        }

        .input-glass:focus {
            background: rgba(30, 41, 59, 0.8);
            border-color: #22c55e;
            box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
            outline: none;
        }

        /* Button dengan gradient NeoFit AI */
        .btn-ai {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            color: white;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(34, 197, 94, 0.3);
        }

        .btn-ai:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(34, 197, 94, 0.4);
        }

        /* Success & Error Messages */
        .message-success {
            background: rgba(34, 197, 94, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
        }

        .message-error {
            background: rgba(239, 68, 68, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #ef4444;
        }

        .message-warning {
            background: rgba(59, 130, 246, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #3b82f6;
        }

        /* Typography improvements */
        .font-serif {
            font-family: 'Inter', sans-serif;
            font-weight: 800;
        }

        .text-gradient {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
    @endsection

    <main class="relative min-h-screen flex items-center hero-bg overflow-hidden">
        <!-- Background Glow -->
        <div class="absolute inset-0 hero-glow z-0"></div>

        <!-- Floating Elements -->
        <div class="absolute top-1/4 right-1/4 w-72 h-72 bg-green-500/10 rounded-full blur-3xl animate-pulse-slow z-0"></div>
        <div class="absolute bottom-1/3 left-1/4 w-96 h-96 bg-blue-500/10 rounded-full blur-3xl animate-pulse-slow z-0" style="animation-delay: 2s;"></div>

        <div class="relative z-10 w-full max-w-7xl mx-auto px-6 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

                {{-- Left: Hero --}}
                <div class="lg:col-span-5 text-center lg:text-left animate-fade-in-up" style="animation-delay:0.15s;">
                    <h1 class="font-bold text-4xl sm:text-5xl lg:text-6xl text-white mb-4">
                        Hubungi <span class="text-gradient">Kami</span>
                    </h1>
                    <p class="text-slate-300 text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                        Punya pertanyaan, ide, atau ingin berkolaborasi?
                        Kirim pesan — tim NeoFit AI siap merespon cepat.
                    </p>
                </div>

                {{-- Right: Form --}}
                <div class="lg:col-span-7 animate-fade-in-up" style="animation-delay:0.3s;">
                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6 glass-panel rounded-2xl p-8">
                        @csrf

                        {{-- Success & error messages --}}
                        @if(session('success'))
                            <div class="message-success p-4 rounded-xl">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            <div class="message-error p-4 rounded-xl">
                                <strong>Perhatian!</strong> Ada kesalahan:
                                <ul class="list-disc list-inside mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Login warning --}}
                        @guest
                            <div class="message-warning p-4 rounded-xl">
                                <strong>Belum Login</strong>
                                <div class="mt-2 text-sm">
                                    <a href="{{ route('login') }}" class="text-green-400 hover:text-green-300 font-semibold">Login</a>
                                    atau
                                    <a href="{{ route('register') }}" class="text-green-400 hover:text-green-300 font-semibold">Register</a>
                                    untuk isi otomatis.
                                </div>
                            </div>
                        @endguest

                        {{-- Fields --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-300">Nama Lengkap</label>
                                <input type="text" id="name" name="name" required
                                       value="{{ old('name', auth()->user()->name ?? '') }}"
                                       class="mt-1 w-full rounded-xl py-3 px-4 input-glass @auth bg-slate-800/60 text-slate-400 cursor-not-allowed @endauth"
                                       placeholder="Nama Anda..." @auth readonly @endauth>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-300">Email</label>
                                <input type="email" id="email" name="email" required
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       class="mt-1 w-full rounded-xl py-3 px-4 input-glass @auth bg-slate-800/60 text-slate-400 cursor-not-allowed @endauth"
                                       placeholder="email@anda.com" @auth readonly @endauth>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300">Subjek (Opsional)</label>
                            <input type="text" id="subject" name="subject"
                                   value="{{ old('subject') }}"
                                   class="mt-1 w-full rounded-xl py-3 px-4 input-glass"
                                   placeholder="Subjek pesan Anda...">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-300">Pesan Anda</label>
                            <textarea id="message" name="message" rows="6" required
                                      class="mt-1 w-full rounded-xl py-3 px-4 input-glass"
                                      placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="btn-ai px-8 py-3 rounded-xl">
                                Kirim Pesan
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>
</x-layouts.landing>
