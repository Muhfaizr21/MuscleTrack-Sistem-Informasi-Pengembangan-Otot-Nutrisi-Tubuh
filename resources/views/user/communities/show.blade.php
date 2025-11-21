@extends('layouts.user')

@section('title', $community->name . ' - MuscleXpert')

@section('styles')
<style>
    .post-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(16, 185, 129, 0.1);
    }
    
    .post-card:hover {
        border-color: rgba(16, 185, 129, 0.3);
        transform: translateY(-2px);
    }
    
    .like-btn.liked {
        color: rgb(239, 68, 68);
    }

    .comment-like-btn.liked {
        color: rgb(239, 68, 68);
    }
    
    .comment-box {
        transition: all 0.3s ease;
    }
    
    .comment-box:focus-within {
        border-color: rgba(16, 185, 129, 0.5);
    }

    .type-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
    }
    
    .type-discussion { background: rgba(59, 130, 246, 0.1); color: rgb(59, 130, 246); }
    .type-achievement { background: rgba(16, 185, 129, 0.1); color: rgb(16, 185, 129); }
    .type-question { background: rgba(245, 158, 11, 0.1); color: rgb(245, 158, 11); }
    .type-workout_log { background: rgba(239, 68, 68, 0.1); color: rgb(239, 68, 68); }
    .type-progress { background: rgba(139, 92, 246, 0.1); color: rgb(139, 92, 246); }

    .dropdown-content {
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.2s ease;
        pointer-events: none;
    }
    
    .dropdown-content.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: all;
    }

    .fade-in {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection

@section('content')
<div class="min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Community Header -->
        <div class="glass rounded-2xl p-8 mb-8 border border-emerald-500/20 relative overflow-hidden fade-in">
            <!-- Cover Image -->
            @if($community->cover_image)
            <div class="absolute inset-0 z-0">
                <img src="{{ Storage::url($community->cover_image) }}" alt="{{ $community->name }}" class="w-full h-full object-cover opacity-20">
                <div class="absolute inset-0 bg-gradient-to-t from-dark-900 to-transparent"></div>
            </div>
            @endif
            
            <div class="relative z-10">
                <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
                    <!-- Community Image -->
                    <div class="flex-shrink-0">
                        @if($community->image)
                        <img src="{{ Storage::url($community->image) }}" alt="{{ $community->name }}" 
                             class="w-20 h-20 rounded-2xl object-cover border-4 border-emerald-500/30">
                        @else
                        <div class="w-20 h-20 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center border-4 border-emerald-500/30">
                            <span class="text-white font-bold text-2xl">{{ substr($community->name, 0, 2) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Community Info -->
                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                            <div>
                                <h1 class="text-3xl font-bold text-white mb-2">{{ $community->name }}</h1>
                                <p class="text-gray-300 mb-4">{{ $community->description }}</p>
                                
                                <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span>{{ $memberCount }} members</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                        </svg>
                                        <span>{{ $community->post_count }} posts</span>
                                    </div>
                                    @if(!$community->is_public)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                        </svg>
                                        <span>Private Community</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex gap-3">
                                @if($isMember)
                                    @if($isAdmin)
                                    <a href="{{ route('user.communities.edit', $community) }}" 
                                       class="bg-blue-500/20 text-blue-400 hover:bg-blue-500/30 px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </a>
                                    @endif
                                    
                                    <form action="{{ route('user.communities.leave', $community) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure you want to leave this community?')"
                                                class="bg-red-500/20 text-red-400 hover:bg-red-500/30 px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                            Leave
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('user.communities.join', $community) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="bg-emerald-500/20 text-emerald-400 hover:bg-emerald-500/30 px-4 py-2 rounded-xl text-sm font-semibold transition-all flex items-center gap-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Join Community
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($isMember)
        <!-- Create Post Form -->
        <div class="glass rounded-2xl p-6 mb-8 border border-emerald-500/20 fade-in">
            <form action="{{ route('user.communities.posts.store', $community) }}" method="POST" enctype="multipart/form-data" id="create-post-form">
                @csrf
                <div class="flex gap-4">
                    <!-- User Avatar -->
                    <div class="flex-shrink-0">
                        @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-12 h-12 rounded-xl object-cover">
                        @else
                        <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-sm">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Post Content -->
                    <div class="flex-1">
                        <textarea 
                            name="content" 
                            rows="3"
                            class="w-full px-4 py-3 bg-dark-800 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition-all comment-box"
                            placeholder="Share your fitness journey, ask questions, or post your achievements..."
                            required></textarea>
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-4">
                            <!-- Post Type & Image -->
                            <div class="flex items-center gap-4">
                                <select name="type" class="bg-dark-800 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500">
                                    <option value="discussion">💬 Discussion</option>
                                    <option value="achievement">🏆 Achievement</option>
                                    <option value="question">❓ Question</option>
                                    <option value="workout_log">💪 Workout Log</option>
                                    <option value="progress">📈 Progress</option>
                                </select>
                                
                                <!-- Image Upload -->
                                <div class="relative">
                                    <label class="cursor-pointer text-gray-400 hover:text-emerald-400 transition-colors flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <span class="text-sm">Add Image</span>
                                        <input type="file" name="image" accept="image/*" class="hidden" id="post-image">
                                    </label>
                                    <div id="image-preview" class="hidden mt-2">
                                        <img id="preview-img" class="max-h-32 rounded-lg">
                                        <button type="button" onclick="removeImage()" class="text-red-400 text-sm mt-1">Remove</button>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" 
                                    class="bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white px-6 py-2 rounded-xl font-semibold transition-all duration-300 hover-glow flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                                </svg>
                                Post
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @endif

        <!-- Posts Feed -->
        <div class="space-y-6" id="posts-container">
            @forelse($posts as $post)
            <div class="post-card glass rounded-2xl p-6 fade-in" id="post-{{ $post->id }}">
                <!-- Post Header -->
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-3">
                        @if($post->user->avatar)
                        <img src="{{ $post->user->avatar }}" alt="{{ $post->user->name }}" class="w-10 h-10 rounded-xl object-cover">
                        @else
                        <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-xl flex items-center justify-center">
                            <span class="text-white font-bold text-xs">{{ strtoupper(substr($post->user->name, 0, 1)) }}</span>
                        </div>
                        @endif
                        <div>
                            <h4 class="font-semibold text-white">{{ $post->user->name }}</h4>
                            <div class="flex items-center gap-2 text-sm text-gray-400">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                <span class="type-badge type-{{ $post->type }}">{{ ucfirst(str_replace('_', ' ', $post->type)) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Post Actions -->
                    @if($post->user_id === auth()->id() || $isAdmin)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" 
                                class="text-gray-400 hover:text-white p-1 rounded-lg transition-colors"
                                @click.away="open = false">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"></path>
                            </svg>
                        </button>
                        <div x-show="open" 
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-48 bg-dark-800 border border-gray-600 rounded-xl shadow-lg py-1 z-10">
                            @if($post->user_id === auth()->id())
                            <button class="w-full text-left px-4 py-2 text-sm text-white hover:bg-gray-700 transition-colors"
                                    onclick="editPost({{ $post->id }})">
                                Edit Post
                            </button>
                            @endif
                            <form action="{{ route('user.communities.posts.destroy', $post) }}" method="POST" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full text-left px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 transition-colors"
                                        onclick="return confirm('Are you sure you want to delete this post?')">
                                    Delete Post
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
                
                <!-- Post Content -->
                <div class="mb-4">
                    <p class="text-gray-300 whitespace-pre-line">{{ $post->content }}</p>
                    
                    @if($post->image)
                    <div class="mt-4 rounded-xl overflow-hidden">
                        <img src="{{ Storage::url($post->image) }}" alt="Post image" class="w-full max-w-md object-cover rounded-xl">
                    </div>
                    @endif
                </div>
                
                <!-- Post Stats & Actions -->
                <div class="flex items-center justify-between pt-4 border-t border-gray-700">
                    <div class="flex items-center gap-6 text-sm text-gray-400">
                        <!-- Like Button -->
                        <button class="like-btn flex items-center gap-2 transition-colors {{ $post->isLikedBy(auth()->id()) ? 'liked text-red-400' : 'text-gray-400 hover:text-red-400' }}"
                                data-post-id="{{ $post->id }}"
                                data-liked="{{ $post->isLikedBy(auth()->id()) ? 'true' : 'false' }}">
                            <svg class="w-5 h-5" fill="{{ $post->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            <span class="likes-count">{{ $post->like_count }}</span>
                        </button>
                        
                        <!-- Comment Button -->
                        <button class="flex items-center gap-2 text-gray-400 hover:text-emerald-400 transition-colors comment-toggle"
                                data-post-id="{{ $post->id }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <span class="comment-count">{{ $post->comment_count }}</span>
                        </button>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section mt-4 space-y-4 hidden" id="comments-{{ $post->id }}">
                    @foreach($post->comments as $comment)
                    <div class="flex gap-3 fade-in">
                        @if($comment->user->avatar)
                        <img src="{{ $comment->user->avatar }}" alt="{{ $comment->user->name }}" class="w-8 h-8 rounded-lg object-cover flex-shrink-0">
                        @else
                        <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg flex items-center justify-center flex-shrink-0">
                            <span class="text-white font-bold text-xs">{{ strtoupper(substr($comment->user->name, 0, 1)) }}</span>
                        </div>
                        @endif
                        <div class="flex-1">
                            <div class="bg-dark-700 rounded-xl p-3">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-white text-sm">{{ $comment->user->name }}</span>
                                    <span class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-gray-300 text-sm">{{ $comment->content }}</p>
                                
                                <!-- Comment Actions -->
                                <div class="flex items-center gap-4 mt-2">
                                    <!-- Like Comment Button -->
                                    <button class="comment-like-btn flex items-center gap-1 text-xs transition-colors {{ $comment->isLikedBy(auth()->id()) ? 'text-red-400' : 'text-gray-400 hover:text-red-400' }}"
                                            data-comment-id="{{ $comment->id }}"
                                            data-liked="{{ $comment->isLikedBy(auth()->id()) ? 'true' : 'false' }}">
                                        <svg class="w-4 h-4" fill="{{ $comment->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                        <span class="comment-likes-count">{{ $comment->like_count }}</span>
                                    </button>
                                    
                                    @if($comment->user_id === auth()->id() || $isAdmin)
                                    <form action="{{ route('user.communities.posts.comments.destroy', $comment) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="text-red-400 hover:text-red-300 text-xs transition-colors"
                                                onclick="return confirm('Are you sure you want to delete this comment?')">
                                            Delete
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <!-- Add Comment Form -->
                    @if($isMember)
                    <form action="{{ route('user.communities.posts.comments.store', $post) }}" method="POST" class="flex gap-3 mt-4 comment-form">
                        @csrf
                        <div class="flex-shrink-0">
                            @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-lg object-cover">
                            @else
                            <div class="w-8 h-8 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-lg flex items-center justify-center">
                                <span class="text-white font-bold text-xs">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1 flex gap-2">
                            <input type="text" 
                                   name="content" 
                                   placeholder="Write a comment..."
                                   class="flex-1 px-3 py-2 bg-dark-700 border border-gray-600 rounded-xl text-white text-sm placeholder-gray-400 focus:outline-none focus:border-emerald-500 transition-all comment-input"
                                   required>
                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-all">
                                Post
                            </button>
                        </div>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <!-- Empty Posts State -->
            <div class="glass rounded-2xl p-12 text-center border border-emerald-500/20 fade-in">
                <div class="w-20 h-20 bg-emerald-500/10 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-10 h-10 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">No Posts Yet</h3>
                <p class="text-gray-400 mb-4">Be the first to share something in this community!</p>
                @if($isMember)
                <p class="text-emerald-400 text-sm">Use the form above to create the first post</p>
                @else
                <p class="text-amber-400 text-sm">Join the community to start posting</p>
                @endif
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($posts->hasPages())
        <div class="mt-8 glass rounded-2xl p-6 border border-emerald-500/20 fade-in">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Edit Post Modal -->
<div id="edit-post-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-dark-800 rounded-2xl p-6 w-full max-w-2xl mx-4">
        <h3 class="text-xl font-bold text-white mb-4">Edit Post</h3>
        <form id="edit-post-form" method="POST">
            @csrf
            @method('PUT')
            <textarea name="content" rows="4" class="w-full px-4 py-3 bg-dark-700 border border-gray-600 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:border-emerald-500 mb-4"></textarea>
            <select name="type" class="bg-dark-700 border border-gray-600 rounded-lg px-3 py-2 text-white text-sm focus:outline-none focus:border-emerald-500 mb-4">
                <option value="discussion">💬 Discussion</option>
                <option value="achievement">🏆 Achievement</option>
                <option value="question">❓ Question</option>
                <option value="workout_log">💪 Workout Log</option>
                <option value="progress">📈 Progress</option>
            </select>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-400 hover:text-white transition-colors">Cancel</button>
                <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-xl font-semibold transition-all">Update Post</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    // Image preview functionality
    document.getElementById('post-image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('image-preview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    function removeImage() {
        document.getElementById('post-image').value = '';
        document.getElementById('image-preview').classList.add('hidden');
    }

    // Like functionality for posts
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const isLiked = this.dataset.liked === 'true';
            const likesCount = this.querySelector('.likes-count');
            
            // Toggle UI immediately for better UX
            if (isLiked) {
                this.classList.remove('liked', 'text-red-400');
                this.classList.add('text-gray-400');
                this.dataset.liked = 'false';
                this.querySelector('svg').setAttribute('fill', 'none');
                likesCount.textContent = parseInt(likesCount.textContent) - 1;
            } else {
                this.classList.add('liked', 'text-red-400');
                this.classList.remove('text-gray-400');
                this.dataset.liked = 'true';
                this.querySelector('svg').setAttribute('fill', 'currentColor');
                likesCount.textContent = parseInt(likesCount.textContent) + 1;
            }
            
            // Send AJAX request
            fetch(`/user/communities/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update count from server response
                if (data.likes_count !== undefined) {
                    likesCount.textContent = data.likes_count;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert UI on error
                if (isLiked) {
                    this.classList.add('liked', 'text-red-400');
                    this.classList.remove('text-gray-400');
                    this.dataset.liked = 'true';
                    this.querySelector('svg').setAttribute('fill', 'currentColor');
                    likesCount.textContent = parseInt(likesCount.textContent) + 1;
                } else {
                    this.classList.remove('liked', 'text-red-400');
                    this.classList.add('text-gray-400');
                    this.dataset.liked = 'false';
                    this.querySelector('svg').setAttribute('fill', 'none');
                    likesCount.textContent = parseInt(likesCount.textContent) - 1;
                }
            });
        });
    });

    // Like functionality for comments
    document.querySelectorAll('.comment-like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const isLiked = this.dataset.liked === 'true';
            const likesCount = this.querySelector('.comment-likes-count');
            
            // Toggle UI immediately for better UX
            if (isLiked) {
                this.classList.remove('liked', 'text-red-400');
                this.classList.add('text-gray-400');
                this.dataset.liked = 'false';
                this.querySelector('svg').setAttribute('fill', 'none');
                likesCount.textContent = parseInt(likesCount.textContent) - 1;
            } else {
                this.classList.add('liked', 'text-red-400');
                this.classList.remove('text-gray-400');
                this.dataset.liked = 'true';
                this.querySelector('svg').setAttribute('fill', 'currentColor');
                likesCount.textContent = parseInt(likesCount.textContent) + 1;
            }
            
            // Send AJAX request
            fetch(`/user/communities/comments/${commentId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({})
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Update count from server response
                if (data.likes_count !== undefined) {
                    likesCount.textContent = data.likes_count;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                // Revert UI on error
                if (isLiked) {
                    this.classList.add('liked', 'text-red-400');
                    this.classList.remove('text-gray-400');
                    this.dataset.liked = 'true';
                    this.querySelector('svg').setAttribute('fill', 'currentColor');
                    likesCount.textContent = parseInt(likesCount.textContent) + 1;
                } else {
                    this.classList.remove('liked', 'text-red-400');
                    this.classList.add('text-gray-400');
                    this.dataset.liked = 'false';
                    this.querySelector('svg').setAttribute('fill', 'none');
                    likesCount.textContent = parseInt(likesCount.textContent) - 1;
                }
            });
        });
    });
    
    // Toggle comments
    document.querySelectorAll('.comment-toggle').forEach(button => {
        button.addEventListener('click', function() {
            const postId = this.dataset.postId;
            const commentsSection = document.getElementById(`comments-${postId}`);
            commentsSection.classList.toggle('hidden');
        });
    });

    // Edit post functionality
    function editPost(postId) {
        const postElement = document.getElementById(`post-${postId}`);
        const content = postElement.querySelector('p').textContent;
        const type = postElement.querySelector('.type-badge').textContent.toLowerCase().replace(' ', '_');
        
        document.querySelector('#edit-post-form textarea').value = content;
        document.querySelector('#edit-post-form select').value = type;
        document.querySelector('#edit-post-form').action = `/user/communities/posts/${postId}`;
        
        document.getElementById('edit-post-modal').classList.remove('hidden');
    }

    function closeEditModal() {
        document.getElementById('edit-post-modal').classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('edit-post-modal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeEditModal();
        }
    });

    // Form submission handling
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const input = this.querySelector('.comment-input');
            if (!input.value.trim()) {
                e.preventDefault();
                input.focus();
            }
        });
    });

    // Auto-focus comment input when comments section is opened
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('comment-toggle')) {
            const postId = e.target.dataset.postId;
            const commentsSection = document.getElementById(`comments-${postId}`);
            const commentInput = commentsSection.querySelector('.comment-input');
            if (commentInput && !commentsSection.classList.contains('hidden')) {
                setTimeout(() => commentInput.focus(), 100);
            }
        }
    });

    // Add smooth scrolling to new posts
    function scrollToPost(postId) {
        const postElement = document.getElementById(`post-${postId}`);
        if (postElement) {
            postElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
            postElement.style.animation = 'pulse 2s';
        }
    }
</script>
@endpush