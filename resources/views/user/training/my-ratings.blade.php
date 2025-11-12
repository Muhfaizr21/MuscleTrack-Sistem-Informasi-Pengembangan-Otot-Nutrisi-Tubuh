@extends('layouts.user')
@section('title', 'My Ratings')

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="glass-dark rounded-3xl p-8 border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 mb-8">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-6">
                <div>
                    <h1 class="text-3xl font-black text-white mb-2">Rating & Ulasan Saya</h1>
                    <p class="text-emerald-400/80 text-lg">Semua penilaian yang telah Anda berikan kepada trainer</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('user.training.my-trainer') }}" 
                       class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow">
                        Kembali ke Trainer Saya
                    </a>
                    <a href="{{ route('user.training.index') }}" 
                       class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-2xl border border-gray-600 transition-all duration-300">
                        Cari Trainer
                    </a>
                </div>
            </div>
        </div>

        <!-- Ratings List -->
        <div class="space-y-6">
            @if($feedbacks->count() > 0)
                @foreach($feedbacks as $feedback)
                    @php
                        $createdAt = \Carbon\Carbon::parse($feedback->created_at);
                    @endphp
                    <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6">
                        <div class="flex flex-col lg:flex-row lg:items-start gap-6">
                            <!-- Trainer Info -->
                            <div class="flex items-start gap-4 flex-1">
                                @if($feedback->trainer->avatar)
                                    <img src="{{ asset('storage/' . $feedback->trainer->avatar) }}" 
                                         alt="{{ $feedback->trainer->name }}"
                                         class="w-16 h-16 rounded-2xl object-cover border-2 border-emerald-400/20">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center text-xl font-bold text-white border-2 border-emerald-400/20">
                                        {{ strtoupper(substr($feedback->trainer->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 mb-2">
                                        <h3 class="text-xl font-bold text-white">{{ $feedback->trainer->name }}</h3>
                                        <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-full text-sm font-medium border border-blue-500/30">
                                            {{ $feedback->trainer->trainerProfile->specialization ?? 'Personal Trainer' }}
                                        </span>
                                    </div>
                                    
                                    <!-- Rating Stars -->
                                    <div class="flex items-center gap-2 mb-3">
                                        <div class="flex">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-5 h-5 {{ $i <= $feedback->rating ? 'text-yellow-400' : 'text-gray-600' }}" 
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                        <span class="text-emerald-400 font-semibold text-sm">{{ $feedback->rating }}/5</span>
                                        <span class="text-gray-400 text-sm">•</span>
                                        <span class="text-emerald-400/70 text-sm">{{ $createdAt->format('d M Y') }}</span>
                                    </div>

                                    <!-- Comment -->
                                    @if($feedback->comment)
                                        <div class="bg-gray-800/50 border border-gray-700/50 rounded-2xl p-4">
                                            <p class="text-white leading-relaxed">{{ $feedback->comment }}</p>
                                        </div>
                                    @else
                                        <p class="text-emerald-400/60 text-sm">Tidak ada komentar tambahan</p>
                                    @endif
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex flex-col sm:flex-row lg:flex-col gap-2 lg:items-end">
                                <div class="flex items-center gap-2 text-sm text-emerald-400/70 mb-2">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                    </svg>
                                    Diberikan {{ $createdAt->diffForHumans() }}
                                </div>
                                <button onclick="editRating({{ $feedback->id }})" 
                                        class="bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded-xl transition-all duration-300 text-sm">
                                    Edit Rating
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $feedbacks->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-12 text-center">
                    <div class="max-w-md mx-auto">
                        <div class="w-24 h-24 bg-emerald-500/20 rounded-3xl flex items-center justify-center mx-auto mb-6 border border-emerald-500/30">
                            <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                      d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-black text-white mb-3">Belum Ada Rating</h3>
                        <p class="text-emerald-400/80 mb-6 leading-relaxed">
                            Anda belum memberikan rating kepada trainer manapun. 
                            Berikan penilaian Anda untuk membantu trainer meningkatkan kualitas layanan.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('user.training.my-trainer') }}" 
                               class="bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow">
                                Lihat Trainer Saya
                            </a>
                            <a href="{{ route('user.training.history') }}" 
                               class="bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-2xl border border-gray-600 transition-all duration-300">
                                Lihat Riwayat Trainer
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Edit Rating Modal -->
<div id="editRatingModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
    <div class="glass-dark rounded-3xl border border-emerald-500/20 shadow-2xl shadow-emerald-500/10 p-6 mx-4 max-w-md w-full">
        <h3 class="text-xl font-black text-white mb-4">Edit Rating</h3>
        <form id="editRatingForm" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Rating Stars -->
            <div class="mb-6">
                <label class="block text-emerald-400/80 text-sm font-semibold mb-3">Rating</label>
                <div class="flex items-center gap-2" id="edit-rating-stars">
                    @for($i = 1; $i <= 5; $i++)
                        <button type="button" class="text-2xl text-gray-400 hover:text-yellow-400 focus:outline-none transition-colors duration-200"
                                data-rating="{{ $i }}" onclick="setEditRating({{ $i }})">
                            ★
                        </button>
                    @endfor
                </div>
                <input type="hidden" name="rating" id="edit-rating-input" value="0" required>
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <label for="edit-comment" class="block text-emerald-400/80 text-sm font-semibold mb-3">Komentar</label>
                <textarea name="comment" id="edit-comment" rows="4" 
                          class="w-full bg-gray-900/50 border border-emerald-500/30 rounded-2xl px-4 py-3 text-white focus:border-emerald-500 focus:ring-0 transition-all duration-300"
                          placeholder="Bagikan pengalaman Anda..."></textarea>
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <button type="submit" 
                        class="flex-1 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 px-6 rounded-2xl transition-all duration-300 hover-glow">
                    Update Rating
                </button>
                <button type="button" onclick="closeEditModal()"
                        class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-semibold py-3 px-6 rounded-2xl border border-gray-600 transition-all duration-300">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function editRating(feedbackId) {
        // For now, just show a message since we don't have the actual data loaded
        // In a real implementation, you would fetch the rating data via AJAX
        alert('Fitur edit rating akan segera tersedia!');
        
        // Example of how it would work with AJAX:
        /*
        fetch(`/user/training/rating/${feedbackId}/edit`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('edit-rating-input').value = data.rating;
                document.getElementById('edit-comment').value = data.comment || '';
                setEditRating(data.rating);
                document.getElementById('editRatingForm').action = `/user/training/rating/${feedbackId}`;
                document.getElementById('editRatingModal').classList.remove('hidden');
            });
        */
    }

    function setEditRating(rating) {
        document.getElementById('edit-rating-input').value = rating;
        const stars = document.querySelectorAll('#edit-rating-stars button');
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

    function closeEditModal() {
        document.getElementById('editRatingModal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('editRatingModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });
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

    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        gap: 0.5rem;
    }

    .pagination .page-item .page-link {
        background: rgba(16, 185, 129, 0.1);
        border: 1px solid rgba(16, 185, 129, 0.2);
        color: #10b981;
        padding: 0.5rem 1rem;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .pagination .page-item.active .page-link {
        background: #10b981;
        border-color: #10b981;
        color: white;
    }

    .pagination .page-item .page-link:hover {
        background: rgba(16, 185, 129, 0.2);
        transform: translateY(-1px);
    }
</style>
@endsection