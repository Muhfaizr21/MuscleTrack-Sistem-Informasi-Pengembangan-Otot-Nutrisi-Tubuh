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
    public function likePost(CommunityPost $post)
    {
        // Check if user is member of the community
        if (!$post->community->isMember(auth()->id())) {
            return response()->json(['error' => 'You must be a member to like posts.'], 403);
        }

        $like = PostLike::firstOrCreate([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
        ]);

        if ($like->wasRecentlyCreated) {
            $post->incrementLikeCount();
        }

        return response()->json([
            'likes_count' => $post->fresh()->like_count,
            'liked' => true,
        ]);
    }

    public function unlikePost(CommunityPost $post)
    {
        $like = PostLike::where('post_id', $post->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
            $post->decrementLikeCount();
        }

        return response()->json([
            'likes_count' => $post->fresh()->like_count,
            'liked' => false,
        ]);
    }

    public function likeComment(PostComment $comment)
    {
        // Check if user is member of the community
        if (!$comment->post->community->isMember(auth()->id())) {
            return response()->json(['error' => 'You must be a member to like comments.'], 403);
        }

        $like = CommentLike::firstOrCreate([
            'comment_id' => $comment->id,
            'user_id' => auth()->id(),
        ]);

        if ($like->wasRecentlyCreated) {
            $comment->incrementLikeCount();
        }

        return response()->json([
            'likes_count' => $comment->fresh()->like_count,
            'liked' => true,
        ]);
    }

    public function unlikeComment(PostComment $comment)
    {
        $like = CommentLike::where('comment_id', $comment->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($like) {
            $like->delete();
            $comment->decrementLikeCount();
        }

        return response()->json([
            'likes_count' => $comment->fresh()->like_count,
            'liked' => false,
        ]);
    }
}