<div class="comment-card" id="comment-{{ $comment->id }}">
    <div class="flex items-start justify-between mb-2">
        <div class="flex items-center gap-3">
            <div
                class="w-8 h-8 bg-gradient-to-br from-emerald-neon to-emerald-deep rounded-full flex items-center justify-center text-white font-bold text-xs">
                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
            </div>
            <div>
                <h5 class="font-semibold text-white text-sm">{{ $comment->user->name }}</h5>
                <p class="text-gray-400 text-xs">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        </div>

        @if(isset($userRole) && ($comment->user_id === auth()->id() || $userRole === 'admin' || $userRole === 'moderator'))
            <div class="flex items-center gap-2">
                @if($comment->user_id === auth()->id())
                    <button class="text-gray-400 hover:text-emerald-400 text-xs edit-comment-btn"
                        data-comment-id="{{ $comment->id }}" data-content="{{ $comment->content }}">
                        Edit
                    </button>
                @endif
                <form action="{{ route('trainer.communities.comments.destroy', $comment->id) }}" method="POST"
                    class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-400 text-xs"
                        onclick="return confirm('Are you sure?')">
                        Delete
                    </button>
                </form>
            </div>
        @endif
    </div>

    <!-- Comment Content Display -->
    <div id="comment-content-{{ $comment->id }}">
        <p class="text-gray-200 text-sm whitespace-pre-line">{{ $comment->content }}</p>
    </div>

    <!-- Edit Comment Form (Hidden by Default) -->
    <div id="edit-comment-form-{{ $comment->id }}" class="hidden mt-3">
        <form action="{{ route('trainer.communities.comments.update', $comment->id) }}" method="POST">
            @csrf
            @method('PUT')
            <textarea name="content" rows="3"
                class="w-full bg-black/30 border border-emerald-500/30 rounded-xl px-3 py-2 text-white placeholder-gray-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm"
                required>{{ $comment->content }}</textarea>
            <div class="flex gap-2 mt-2">
                <button type="submit" class="btn-premium px-3 py-1 text-xs">
                    Update
                </button>
                <button type="button"
                    class="cancel-edit-btn px-3 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors"
                    data-comment-id="{{ $comment->id }}">
                    Cancel
                </button>
            </div>
        </form>
    </div>

    <!-- Comment Actions -->
    <div class="flex items-center gap-4 mt-3">
        <button
            class="like-comment-btn flex items-center gap-1 text-gray-400 hover:text-red-400 text-xs transition-colors {{ $comment->isLikedBy(auth()->id()) ? 'text-red-400' : '' }}"
            data-comment-id="{{ $comment->id }}"
            data-liked="{{ $comment->isLikedBy(auth()->id()) ? 'true' : 'false' }}">
            <svg class="w-3 h-3" fill="{{ $comment->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z">
                </path>
            </svg>
            <span class="comment-like-count">{{ $comment->like_count }}</span>
        </button>

        <button class="text-gray-400 hover:text-emerald-400 text-xs transition-colors reply-btn"
            data-comment-id="{{ $comment->id }}">
            Reply
        </button>
    </div>

    <!-- Reply Form (Hidden by Default) -->
    <div id="reply-form-{{ $comment->id }}" class="hidden mt-3">
        <form action="{{ route('trainer.communities.comments.store', $comment->post_id) }}" method="POST">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
            <div class="flex gap-2">
                <div
                    class="w-6 h-6 bg-gradient-to-br from-emerald-neon to-emerald-deep rounded-full flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="flex-1">
                    <textarea name="content" rows="2"
                        class="w-full bg-black/30 border border-emerald-500/30 rounded-xl px-3 py-2 text-white placeholder-gray-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 text-sm"
                        placeholder="Write a reply..." required></textarea>
                    <div class="flex gap-2 mt-2">
                        <button type="submit" class="btn-premium px-3 py-1 text-xs">
                            Reply
                        </button>
                        <button type="button"
                            class="cancel-reply-btn px-3 py-1 text-xs bg-gray-600 hover:bg-gray-700 text-white rounded-xl transition-colors"
                            data-comment-id="{{ $comment->id }}">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Replies -->
@if($comment->replies && $comment->replies->count() > 0)
    <div class="ml-6 mt-3 space-y-3 border-l-2 border-emerald-500/20 pl-4">
        @foreach($comment->replies as $reply)
            @include('trainer.communities.partials.comment', ['comment' => $reply, 'userRole' => $userRole ?? null])
        @endforeach
    </div>
@endif