<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\CommentLike;
use Illuminate\Http\Request;

class UserCommunityLikeController extends Controller
{
    public function store(Request $request, CommunityPost $post)
    {
        $isMember = $post->community->members()->where('user_id', auth()->id())->exists();

        if (!$post->community->is_public && !$isMember) {
            return response()->json(['error' => 'You need to join this community to like posts.'], 403);
        }

        $existingLike = PostLike::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            PostLike::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
            ]);
            $liked = true;
        }

        // Update like count
        $post->update([
            'like_count' => $post->likes()->count()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $post->fresh()->like_count
            ]);
        }

        return redirect()->back();
    }

    public function commentLike(Request $request, PostComment $comment)
    {
        $isMember = $comment->post->community->members()->where('user_id', auth()->id())->exists();

        if (!$comment->post->community->is_public && !$isMember) {
            return response()->json(['error' => 'You need to join this community to like comments.'], 403);
        }

        $existingLike = CommentLike::where('comment_id', $comment->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($existingLike) {
            $existingLike->delete();
            $liked = false;
        } else {
            CommentLike::create([
                'comment_id' => $comment->id,
                'user_id' => auth()->id(),
            ]);
            $liked = true;
        }

        // Update like count
        $comment->update([
            'like_count' => $comment->likes()->count()
        ]);

        if ($request->ajax()) {
            return response()->json([
                'liked' => $liked,
                'likes_count' => $comment->fresh()->like_count
            ]);
        }

        return redirect()->back();
    }
}
