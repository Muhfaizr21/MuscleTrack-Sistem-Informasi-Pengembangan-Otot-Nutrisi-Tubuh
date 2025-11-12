@extends('layouts.user')
@section('title', 'Beri Rating Trainer')

@section('content')
    <div class="min-h-screen py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10">
                <h2 class="text-2xl font-black text-white mb-2">Beri Rating untuk {{ $trainer->name }}</h2>
                <p class="text-emerald-400/80 mb-6">Bagaimana pengalaman Anda dengan trainer ini?</p>

                @if($existingFeedback)
                    <div class="bg-blue-500/20 border border-blue-500/30 rounded-2xl p-4 mb-6">
                        <p class="text-blue-400">Anda sudah memberikan rating untuk trainer ini.</p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('user.training.my-trainer') }}"
                            class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow flex-1 text-center">
                            Kembali ke Profil Trainer
                        </a>
                        <a href="{{ route('user.training.my-ratings') }}"
                            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow flex-1 text-center">
                            Lihat Rating Saya
                        </a>
                    </div>
                @else
                    <form action="{{ route('user.training.rate.store', $trainer->id) }}" method="POST">
                        @csrf

                        <!-- Rating Stars -->
                        <div class="mb-6">
                            <label class="block text-emerald-400/80 text-sm font-semibold mb-3">Rating</label>
                            <div class="flex items-center gap-2" id="rating-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button"
                                        class="text-3xl text-gray-400 hover:text-yellow-400 focus:outline-none transition-colors duration-200"
                                        data-rating="{{ $i }}" onclick="setRating({{ $i }})">
                                        ★
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="0" required>
                            @error('rating')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Comment -->
                        <div class="mb-6">
                            <label for="comment" class="block text-emerald-400/80 text-sm font-semibold mb-3">Komentar
                                (opsional)</label>
                            <textarea name="comment" id="comment" rows="4"
                                class="w-full bg-gray-900/50 border border-emerald-500/30 rounded-2xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-0 transition-all duration-300"
                                placeholder="Bagikan pengalaman Anda...">{{ old('comment') }}</textarea>
                            @error('comment')
                                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <button type="submit" id="submit-btn"
                                class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow flex-1 disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                                Kirim Rating
                            </button>
                            <a href="{{ route('user.training.my-trainer') }}"
                                class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-2xl border border-gray-600 transition-all duration-300 text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        function setRating(rating) {
            // Update hidden input
            document.getElementById('rating-input').value = rating;

            // Enable submit button
            document.getElementById('submit-btn').disabled = false;

            // Update stars display
            const stars = document.querySelectorAll('#rating-stars button');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-gray-400');
                    star.classList.add('text-yellow-400');
                } else {
                    star.classList.remove('text-yellow-400');
                    star.classList.add('text-gray-400');
                }
            });
        }

        // Initialize with 0 stars
        setRating(0);
    </script>

    <style>
        .glass-dark {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .hover-glow:hover {
            box-shadow: 0 0 25px rgba(16, 185, 129, 0.3);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
    </style>
@endsection