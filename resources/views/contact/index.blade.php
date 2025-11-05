<x-layouts.landing>

    {{--
      ==================================
      ===== CSS "KACA SUSU" (WAJIB!) =====
      ==================================
      (100% "Suntikkan" Energi Maestro yang sudah di-FIX)
    --}}
    @section('styles')
    <style>
        /* (Animasi "Fade In" 100% kita pertahankan) */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            opacity: 0; /* Mulai 100% transparan */
            animation: fadeInUp 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            animation-fill-mode: forwards;
        }

        /* ==================================
          ===== INI PERBAIKAN "JENIUS" =====
          ==== (Edisi "KACA SUSU" "CIAMIK") ====
          ==================================
        */
        .input-glass {
             background-color: rgba(255, 255, 255, 0.9); /* (FIX: 100% "PUTIH BEKU") */
             backdrop-filter: blur(8px);
             border: 1px solid rgba(255, 255, 255, 0.3);

             /* ==================================
               ===== "PALU CIAMIK" (WAJIB!) =====
               ==================================
             */
             color: black !important; /* (FIX: 100% "TEKS ITEM" "CIAMIK") */
        }

        /* (FIX: 100% Paksa Placeholder agar "Gelap") */
        .input-glass::placeholder {
            color: #6B7280; /* (Warna abu-abu-500) */
            opacity: 1;
        }

        .input-glass:focus {
             background-color: rgba(255, 255, 255, 1); /* (FIX: 100% Putih Solid saat Fokus) */
             border-color: rgba(251, 191, 36, 0.7); /* (Border Amber "Ciamik") */
             box-shadow: 0 0 0 3px rgba(251, 191, 36, 0.2); /* (Glow Amber "Ciamik") */
        }

    </style>
    @endsection


    {{--
      ==================================
      ===== HERO "JENIUS" (STATIC) =====
      ==================================
    --}}
    <main class="relative min-h-screen overflow-hidden flex items-center">

        {{-- (Latar Belakang 100% "DIAM") --}}
        <div class="absolute inset-0 z-0"
             style="background-image: url('https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=2669&auto:format&fit=crop'); background-size: cover; background-position: center;">
        </div>

        {{-- (Overlay "Kaca Ciamik" 100% Full) --}}
        <div class="absolute inset-0 z-10 w-full bg-black/80 backdrop-blur-lg"></div>

        {{--
          ==================================
          ===== KONTEN "PELEBURAN STATIC" =====
          ==================================
        --}}
        <div class="relative z-20 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">

                {{-- Teks "DIAM" (Kiri) --}}
                <div class="lg:col-span-5 text-center lg:text-left">

                    <h1 class="font-serif text-5xl sm:text-7xl font-bold text-white animate-fade-in-up"
                        style="animation-delay: 0.2s;">
                        Hubungi <span class="text-amber-400">Kami</span>
                    </h1>
                    <p class="mt-4 text-lg text-gray-400 max-w-2xl mx-auto lg:mx-0 animate-fade-in-up"
                       style="animation-delay: 0.4s;">
                        Punya pertanyaan, feedback, atau ingin bermitra? Kirimkan pesan kepada kami. Kami akan segera merespon Anda.
                    </p>
                </div>

                {{-- FORM "DIAM" (Kanan) --}}
                <div class="lg:col-span-7">

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6 animate-fade-in-up"
                          style="animation-delay: 0.6s;">
                        @csrf

                        @if(session('success'))
                            <div class="mb-6 bg-amber-400/20 text-amber-300 border border-amber-500/50 p-4 rounded-md">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if ($errors->any())
                             <div class="mb-6 bg-red-900/50 text-red-300 border border-red-700 p-4 rounded-md">
                                <p>Ups! Ada beberapa kesalahan:</p>
                                <ul class="list-disc list-inside mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- "ALERT LOGIN" (Sudah "ciamik") --}}
                        @guest
                        <div class="mb-6 bg-blue-900/50 text-blue-300 border border-blue-700/50 p-4 rounded-md">
                            <p class="font-bold">⚠️ Anda Belum Login</p>
                            <p class="text-sm mt-1">
                                <a href="{{ route('login') }}" class="font-bold text-amber-400 hover:underline">Login</a> atau
                                <a href="{{ route('register') }}" class="font-bold text-amber-400 hover:underline">Register</a>
                                untuk mengisi data Anda secara otomatis.
                            </p>
                        </div>
                        @endguest

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-300">Nama Lengkap</label>
                                <input type="text" name="name" id="name" required
                                       value="{{ old('name', auth()->user()->name ?? '') }}"
                                       class="mt-1 block w-full input-glass rounded-md shadow-sm
                                              text-gray-900 {{-- (FIX: Paksa Teks Item) --}}
                                              placeholder-gray-500 {{-- (FIX: Placeholder Gelap) --}}
                                              focus:ring-0 focus:outline-none
                                              @auth bg-gray-300 text-gray-500 cursor-not-allowed @endauth" {{-- (FIX: Style 'readonly' "Ciamik") --}}
                                       placeholder="Nama Anda..."
                                       @auth readonly @endauth>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-300">Email</label>
                                <input type="email" name="email" id="email" required
                                       value="{{ old('email', auth()->user()->email ?? '') }}"
                                       class="mt-1 block w-full input-glass rounded-md shadow-sm
                                              text-gray-900 {{-- (FIX: Paksa Teks Item) --}}
                                              placeholder-gray-500 {{-- (FIX: Placeholder Gelap) --}}
                                              focus:ring-0 focus:outline-none
                                              @auth bg-gray-300 text-gray-500 cursor-not-allowed @endauth" {{-- (FIX: Style 'readonly' "Ciamik") --}}
                                       placeholder="email@anda.com"
                                       @auth readonly @endauth>
                            </div>
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-300">Subjek (Opsional)</label>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                                   class="mt-1 block w-full input-glass rounded-md shadow-sm
                                          text-gray-900 {{-- (FIX: Paksa Teks Item) --}}
                                          placeholder-gray-500 {{-- (FIX: Placeholder Gelap) --}}
                                          focus:ring-0 focus:outline-none"
                                   placeholder="Subjek pesan Anda...">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-medium text-gray-300">Pesan Anda</label>
                            <textarea name="message" id="message" rows="5" required
                                      class="mt-1 block w-full input-glass rounded-md shadow-sm
                                             text-gray-900 {{-- (FIX: Paksa Teks Item) --}}
                                             placeholder-gray-500 {{-- (FIX: Placeholder Gelap) --}}
                                             focus:ring-0 focus:outline-none"
                                      placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-8 py-3 rounded-md text-base font-bold text-black bg-amber-400
                                           hover:bg-amber-300 transition-all duration-300 shadow-lg shadow-amber-500/20
                                           transform hover:scale-105">
                                Kirim Pesan
                            </button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </main>

</x-layouts.landing>
