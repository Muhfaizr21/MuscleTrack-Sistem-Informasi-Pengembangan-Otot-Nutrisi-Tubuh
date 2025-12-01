@extends('layouts.user')

@section('title', $community->name)

@section('styles')
<style>
    /* Base Styles */
    .community-header {
        background: rgba(17, 25, 21, 0.8);
        backdrop-filter: blur(15px) saturate(180%);
        border: 1px solid rgba(0, 255, 170, 0.25);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .community-cover {
        height: 200px;
        background: linear-gradient(135deg, #00ff9d, #00ffcc);
        position: relative;
    }

    .community-info {
        padding: 2rem;
        position: relative;
    }

    .community-avatar {
        width: 80px;
        height: 80px;
        border: 6px solid rgba(17, 25, 21, 0.95);
        background: rgba(17, 25, 21, 0.95);
        border-radius: 20px;
        position: absolute;
        top: -40px;
        left: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        font-weight: bold;
        color: #00ffcc;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
    }

    .post-card {
        background: rgba(17, 25, 21, 0.8);
        backdrop-filter: blur(15px) saturate(180%);
        border: 1px solid rgba(0, 255, 170, 0.25);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .post-card:hover {
        border-color: rgba(0, 255, 170, 0.4);
        box-shadow: 0 8px 32px rgba(0, 255, 170, 0.1);
    }

    .post-type-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: capitalize;
    }

    .post-type-discussion { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    .post-type-achievement { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
    .post-type-question { background: rgba(234, 179, 8, 0.2); color: #eab308; }
    .post-type-workout_log { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .post-type-progress { background: rgba(168, 85, 247, 0.2); color: #a855f7; }

    .action-btn {
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .like-btn {
        background: rgba(255, 255, 255, 0.05);
        color: #9CA3AF;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .like-btn:hover, .like-btn.liked {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border-color: rgba(239, 68, 68, 0.4);
    }

    .comment-btn {
        background: rgba(255, 255, 255, 0.05);
        color: #9CA3AF;
        border-color: rgba(255, 255, 255, 0.1);
    }

    .comment-btn:hover {
        background: rgba(59, 130, 246, 0.2);
        color: #3b82f6;
        border-color: rgba(59, 130, 246, 0.4);
    }

    .comment-section {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 1rem;
        margin-top: 1rem;
    }

    .comment-card {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .comment-card:hover {
        background: rgba(255, 255, 255, 0.08);
    }

    .create-post-card {
        background: rgba(17, 25, 21, 0.8);
        backdrop-filter: blur(15px) saturate(180%);
        border: 1px solid rgba(0, 255, 170, 0.25);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .hidden {
        display: none !important;
    }

    .like-comment-btn.liked {
        color: #ef4444;
    }

    .replies-section {
        margin-left: 1rem;
        margin-top: 0.75rem;
        padding-left: 1rem;
        border-left: 2px solid rgba(0, 255, 170, 0.2);
    }

    /* Avatar Styles */
    .user-avatar {
        border-radius: 12px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .user-avatar-initial {
        background: linear-gradient(135deg, #10b981, #059669);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
    }

    /* Form Styles */
    .form-input {
        background: rgba(10, 15, 13, 0.8);
        border: 1px solid rgba(0, 255, 170, 0.3);
        border-radius: 12px;
        padding: 12px 16px;
        color: white;
        width: 100%;
        transition: all 0.3s ease;
        font-family: inherit;
    }

    .form-input::placeholder {
        color: #9CA3AF;
    }

    .form-input:focus {
        background: rgba(10, 15, 13, 0.9);
        border-color: rgba(0, 255, 170, 0.6);
        box-shadow: 0 0 0 3px rgba(0, 255, 170, 0.1);
        outline: none;
        color: white;
    }

    .form-select {
        background: rgba(10, 15, 13, 0.8);
        border: 1px solid rgba(0, 255, 170, 0.3);
        border-radius: 12px;
        padding: 10px 12px;
        color: white;
        transition: all 0.3s ease;
    }

    .form-select:focus {
        background: rgba(10, 15, 13, 0.9);
        border-color: rgba(0, 255, 170, 0.6);
        box-shadow: 0 0 0 3px rgba(0, 255, 170, 0.1);
        outline: none;
    }

    .image-upload-btn {
        background: rgba(10, 15, 13, 0.8);
        border: 1px solid rgba(0, 255, 170, 0.3);
        border-radius: 12px;
        padding: 10px 16px;
        color: #9CA3AF;
        transition: all 0.3s ease;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .image-upload-btn:hover {
        background: rgba(10, 15, 13, 0.9);
        border-color: rgba(0, 255, 170, 0.5);
        color: #00ffcc;
    }

    .image-preview-container {
        border: 2px solid rgba(0, 255, 170, 0.3);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1rem;
        background: rgba(10, 15, 13, 0.5);
    }

    .image-preview {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        object-fit: cover;
    }

    .remove-image-btn {
        background: rgba(239, 68, 68, 0.2);
        color: #ef4444;
        border: 1px solid rgba(239, 68, 68, 0.4);
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s ease;
    }

    .remove-image-btn:hover {
        background: rgba(239, 68, 68, 0.3);
        border-color: rgba(239, 68, 68, 0.6);
    }

    /* Admin Controls */
    .admin-controls {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-admin {
        background: rgba(139, 92, 246, 0.2);
        color: #8b5cf6;
        border: 1px solid rgba(139, 92, 246, 0.4);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-admin:hover {
        background: rgba(139, 92, 246, 0.3);
        border-color: rgba(139, 92, 246, 0.6);
        transform: translateY(-1px);
    }

    .btn-back {
        background: rgba(107, 114, 128, 0.2);
        color: #9CA3AF;
        border: 1px solid rgba(107, 114, 128, 0.4);
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back:hover {
        background: rgba(107, 114, 128, 0.3);
        border-color: rgba(107, 114, 128, 0.6);
    }

    /* Role Badges */
    .role-badge {
        padding: 4px 8px;
        border-radius: 8px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-admin { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
    .role-moderator { background: rgba(59, 130, 246, 0.2); color: #3b82f6; }
    .role-member { background: rgba(34, 197, 94, 0.2); color: #22c55e; }

    /* Mobile Responsive Styles */
    @media (max-width: 640px) {
        .community-header {
            border-radius: 16px;
            margin-bottom: 1.5rem;
        }
        
        .community-cover {
            height: 150px;
        }
        
        .community-info {
            padding: 1.5rem 1rem;
        }
        
        .community-avatar {
            width: 60px;
            height: 60px;
            top: -30px;
            left: 1rem;
            font-size: 24px;
            border-width: 4px;
        }
        
        .post-card {
            padding: 1rem;
            border-radius: 12px;
        }
        
        .create-post-card {
            padding: 1rem;
            border-radius: 12px;
        }
        
        .btn-admin, .btn-back {
            padding: 6px 12px;
            font-size: 11px;
        }
        
        .admin-controls {
            gap: 8px;
        }
        
        .replies-section {
            margin-left: 0.5rem;
            padding-left: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .community-cover {
            height: 120px;
        }
        
        .community-info {
            padding: 1.25rem 0.75rem;
        }
        
        .community-avatar {
            width: 50px;
            height: 50px;
            top: -25px;
            left: 0.75rem;
            font-size: 20px;
        }
        
        .post-card {
            padding: 0.75rem;
        }
        
        .create-post-card {
            padding: 0.75rem;
        }
        
        .action-btn {
            padding: 6px 12px;
            font-size: 11px;
        }
        
        .form-input, .form-select {
            padding: 10px 12px;
            font-size: 14px;
        }
        
        .image-upload-btn {
            padding: 8px 12px;
            font-size: 12px;
        }
    }
</style>
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button and Admin Controls -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <!-- Back Button -->
        <a href="{{ route('user.communities.index') }}" class="btn-back self-start">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="hidden sm:inline">Back to Communities</span>
            <span class="sm:hidden">Back</span>
        </a>

        <!-- Admin Controls -->
        @if($isMember && ($userRole === 'admin' || $userRole === 'moderator'))
        <div class="admin-controls">
            <a href="{{ route('user.communities.edit', $community->slug) }}" class="btn-admin">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="hidden sm:inline">Edit Community</span>
                <span class="sm:hidden">Edit</span>
            </a>
            <a href="{{ route('user.communities.members', $community->slug) }}" class="btn-admin">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <span class="hidden sm:inline">Manage Members</span>
                <span class="sm:hidden">Members</span>
            </a>
        </div>
        @endif
    </div>

    <!-- Community Header -->
    <div class="community-header">
        <div class="community-cover">
            @if($community->cover_image)
            <img src="{{ $community->cover_image_url }}" alt="{{ $community->name }}" 
                 class="w-full h-full object-cover">
            @endif
        </div>
        
        <div class="community-info">
            <div class="community-avatar">
                @if($community->image)
                <img src="{{ $community->image_url }}" alt="{{ $community->name }}" 
                     class="w-full h-full object-cover rounded-xl">
                @else
                {{ strtoupper(substr($community->name, 0, 1)) }}
                @endif
            </div>

            <div class="ml-0 sm:ml-32">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                    <div class="flex-1">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3 mb-2">
                            <h1 class="text-2xl sm:text-3xl font-bold text-white">{{ $community->name }}</h1>
                            @if($isMember && $userRole)
                            <span class="role-badge role-{{ $userRole }} self-start sm:self-auto">
                                {{ $userRole }}
                            </span>
                            @endif
                        </div>
                        <p class="text-gray-400 text-sm sm:text-base">{{ $community->description }}</p>
                    </div>
                    
                    <div class="flex items-center justify-end sm:justify-start">
                        @if($isMember)
                        <form action="{{ route('user.communities.leave', $community->slug) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="action-btn bg-red-500/20 text-red-400 border-red-500/40 hover:bg-red-500/30 text-xs sm:text-sm"
                                    onclick="return confirm('Are you sure you want to leave this community?')">
                                Leave
                            </button>
                        </form>
                        @else
                        <form action="{{ route('user.communities.join', $community->slug) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-premium px-4 py-2 text-xs sm:text-sm">
                                Join Community
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-4 text-sm">
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $community->member_count }} members
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        {{ $community->post_count }} posts
                    </div>
                    <div class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Created {{ $community->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($isMember)
    <!-- Create Post Form with Image Preview -->
    <div class="create-post-card">
        <h3 class="text-lg font-bold text-white mb-4">Create a Post</h3>
        <form action="{{ route('user.communities.posts.store', $community->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <!-- Content Textarea -->
            <div class="mb-4">
                <textarea name="content" rows="3" 
                          class="form-input"
                          placeholder="Share your thoughts, progress, or questions..."
                          required>{{ old('content') }}</textarea>
                @error('content')
                <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Post Type and Image Upload -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-4">
                <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                    <!-- Post Type Select -->
                    <select name="type" class="form-select">
                        <option value="discussion">💬 Discussion</option>
                        <option value="achievement">🏆 Achievement</option>
                        <option value="question">❓ Question</option>
                        <option value="workout_log">💪 Workout Log</option>
                        <option value="progress">📈 Progress</option>
                    </select>
                    
                    <!-- Image Upload Button -->
                    <input type="file" name="image" id="post-image" accept="image/*" class="hidden" onchange="previewPostImage(this)">
                    <label for="post-image" class="image-upload-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Add Image</span>
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-premium px-6 py-2 text-sm font-semibold self-start sm:self-auto">
                    Post
                </button>
            </div>

            <!-- Image Preview Area -->
            <div id="post-image-preview" class="hidden">
                <div class="image-preview-container">
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-sm font-medium text-gray-300">Image Preview</span>
                        <button type="button" onclick="removePostImage()" class="remove-image-btn text-xs">
                            Remove Image
                        </button>
                    </div>
                    <img id="post-image-preview-img" class="image-preview">
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Posts Feed -->
    <div class="space-y-4">
        @if($posts->count() > 0)
            @foreach($posts as $post)
            <div class="post-card">
                <!-- Post Header -->
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-3">
                    <div class="flex items-center gap-3">
                        <!-- User Avatar -->
                        <div class="w-10 h-10 rounded-xl overflow-hidden flex-shrink-0">
                            @if($post->user->avatar)
                                <img src="{{ asset('storage/' . $post->user->avatar) }}" 
                                     alt="{{ $post->user->name }}"
                                     class="w-full h-full object-cover user-avatar">
                            @else
                                <div class="w-full h-full user-avatar-initial user-avatar">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h4 class="font-semibold text-white">{{ $post->user->name }}</h4>
                            <p class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <span class="post-type-badge post-type-{{ $post->type }} self-start sm:self-auto">
                        {{ $post->type }}
                    </span>
                </div>

                <!-- Post Content -->
                <div class="mb-4">
                    <p class="text-gray-200 whitespace-pre-line">{{ $post->content }}</p>
                    
                    @if($post->image)
                    <div class="mt-3">
                        <img src="{{ $post->image_url }}" alt="Post image" 
                             class="rounded-xl w-full max-w-md max-h-96 object-cover border border-emerald-500/20">
                    </div>
                    @endif
                </div>

                <!-- Post Actions -->
                <div class="flex items-center gap-4">
                    <button class="like-btn action-btn flex items-center gap-2 {{ $post->isLikedBy(auth()->id()) ? 'liked' : '' }}"
                            data-post-id="{{ $post->id }}"
                            data-liked="{{ $post->isLikedBy(auth()->id()) ? 'true' : 'false' }}">
                        <svg class="w-4 h-4" fill="{{ $post->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}" 
                             stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        <span class="like-count">{{ $post->like_count }}</span>
                    </button>

                    <button class="comment-btn action-btn flex items-center gap-2" 
                            onclick="toggleCommentSection({{ $post->id }})">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                        </svg>
                        <span>{{ $post->comments_count }}</span>
                    </button>

                    <!-- Admin Post Controls -->
                    @if($isMember && ($userRole === 'admin' || $userRole === 'moderator'))
                    <form action="{{ route('user.communities.posts.destroy', $post->id) }}" method="POST" class="ml-auto">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="action-btn bg-red-500/20 text-red-400 border-red-500/40 hover:bg-red-500/30 text-xs"
                                onclick="return confirm('Are you sure you want to delete this post?')">
                            Delete
                        </button>
                    </form>
                    @endif
                </div>

                <!-- Comments Section -->
                <div id="comments-{{ $post->id }}" class="comment-section hidden">
                    <!-- Add Comment Form -->
                    <form action="{{ route('user.communities.comments.store', $post->id) }}" method="POST" class="mb-4">
                        @csrf
                        <div class="flex gap-3">
                            <!-- Current User Avatar -->
                            <div class="w-8 h-8 rounded-full overflow-hidden flex-shrink-0">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                         alt="{{ auth()->user()->name }}"
                                         class="w-full h-full object-cover user-avatar">
                                @else
                                    <div class="w-full h-full user-avatar-initial user-avatar">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <textarea name="content" rows="2" 
                                          class="form-input text-sm"
                                          placeholder="Write a comment..." required></textarea>
                                <button type="submit" class="btn-premium px-4 py-1 text-xs mt-2">
                                    Comment
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Comments List -->
                    <div class="space-y-3">
                        @foreach($post->comments->where('parent_id', null) as $comment)
                        @include('user.communities.partials.comment', [
                            'comment' => $comment, 
                            'userRole' => $userRole ?? null
                        ])
                        @endforeach
                    </div>
                </div>
            </div>
            @endforeach
        @else
            <!-- Empty State for Posts -->
            <div class="text-center py-12">
                <div class="w-16 h-16 bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-400 mb-2">No Posts Yet</h3>
                <p class="text-gray-500 mb-4">Be the first to share something in this community!</p>
                @if($isMember)
                <button onclick="document.querySelector('textarea').focus()" class="btn-premium px-6 py-2 text-sm">
                    Create First Post
                </button>
                @endif
            </div>
        @endif
    </div>

    <!-- Pagination -->
    @if($posts->hasPages())
    <div class="mt-8">
        {{ $posts->links() }}
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function toggleCommentSection(postId) {
        const section = document.getElementById(`comments-${postId}`);
        section.classList.toggle('hidden');
    }

    // Preview image for post
    function previewPostImage(input) {
        const previewContainer = document.getElementById('post-image-preview');
        const previewImg = document.getElementById('post-image-preview-img');
        const file = input.files[0];
        
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            
            reader.readAsDataURL(file);
        }
    }

    // Remove image preview
    function removePostImage() {
        const input = document.getElementById('post-image');
        const previewContainer = document.getElementById('post-image-preview');
        
        input.value = '';
        previewContainer.classList.add('hidden');
    }

    // Like post functionality
    document.addEventListener('click', async (e) => {
        if (e.target.closest('.like-btn')) {
            const button = e.target.closest('.like-btn');
            const postId = button.dataset.postId;
            const isLiked = button.dataset.liked === 'true';
            
            try {
                const url = isLiked ? 
                    `/user/communities/posts/${postId}/unlike` : 
                    `/user/communities/posts/${postId}/like`;
                
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                });
                
                const data = await response.json();
                
                if (response.ok) {
                    button.querySelector('.like-count').textContent = data.likes_count;
                    button.dataset.liked = data.liked;
                    
                    if (data.liked) {
                        button.classList.add('liked');
                    } else {
                        button.classList.remove('liked');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    });

    // Like comment functionality
    async function likeComment(commentId) {
        const button = document.querySelector(`.like-comment-btn[data-comment-id="${commentId}"]`);
        const isLiked = button.dataset.liked === 'true';
        
        try {
            const url = isLiked ? 
                `/user/communities/comments/${commentId}/unlike` : 
                `/user/communities/comments/${commentId}/like`;
            
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
            });
            
            const data = await response.json();
            
            if (response.ok) {
                // Update like count
                button.querySelector('.comment-like-count').textContent = data.likes_count;
                button.dataset.liked = data.liked;
                
                // Update button style
                if (data.liked) {
                    button.classList.add('liked');
                    button.querySelector('svg').setAttribute('fill', 'currentColor');
                } else {
                    button.classList.remove('liked');
                    button.querySelector('svg').setAttribute('fill', 'none');
                }
            } else {
                console.error('Error:', data);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    }

    // Edit comment functionality
    function setupEditComment() {
        document.addEventListener('click', function(e) {
            // Edit button click
            if (e.target.classList.contains('edit-comment-btn')) {
                const commentId = e.target.dataset.commentId;
                const contentDisplay = document.getElementById(`comment-content-${commentId}`);
                const editForm = document.getElementById(`edit-comment-form-${commentId}`);
                
                contentDisplay.classList.add('hidden');
                editForm.classList.remove('hidden');
            }
            
            // Cancel edit button click
            if (e.target.classList.contains('cancel-edit-btn')) {
                const commentId = e.target.dataset.commentId;
                const contentDisplay = document.getElementById(`comment-content-${commentId}`);
                const editForm = document.getElementById(`edit-comment-form-${commentId}`);
                
                contentDisplay.classList.remove('hidden');
                editForm.classList.add('hidden');
            }
        });
    }

    // Reply functionality
    function setupReply() {
        document.addEventListener('click', function(e) {
            // Reply button click
            if (e.target.classList.contains('reply-btn')) {
                const commentId = e.target.dataset.commentId;
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                
                replyForm.classList.toggle('hidden');
            }
            
            // Cancel reply button click
            if (e.target.classList.contains('cancel-reply-btn')) {
                const commentId = e.target.dataset.commentId;
                const replyForm = document.getElementById(`reply-form-${commentId}`);
                
                replyForm.classList.add('hidden');
            }
        });
    }

    // Like comment event listener
    document.addEventListener('click', function(e) {
        if (e.target.closest('.like-comment-btn')) {
            const button = e.target.closest('.like-comment-btn');
            const commentId = button.dataset.commentId;
            likeComment(commentId);
        }
    });

    // Initialize functionality when page loads
    document.addEventListener('DOMContentLoaded', function() {
        setupEditComment();
        setupReply();
    });
</script>
@endsection