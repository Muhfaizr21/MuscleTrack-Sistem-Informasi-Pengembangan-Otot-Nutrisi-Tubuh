<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\PostComment;
use Illuminate\Http\Request;

class UserCommunityCommentController extends Controller
{
    public function store(Request $request, CommunityPost $post)
    {
        $isMember = $post->community->members()->where('user_id', auth()->id())->exists();

        if (!$post->community->is_public && !$isMember) {
            abort(403, 'You need to join this community to comment.');
        }

        $request->validate([
            'content' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:post_comments,id'
        ]);

        PostComment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->input('parent_id'),
            'content' => $request->input('content'),
        ]);

        // Update comment count
        $post->update([
            'comment_count' => $post->comments()->count()
        ]);

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, PostComment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403, 'You can only edit your own comments.');
        }

        $request->validate([
            'content' => 'required|string|max:500'
        ]);

        $comment->update([
            'content' => $request->input('content')
        ]);

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(PostComment $comment)
    {
        $isAdmin = $comment->post->community->members()
            ->where('user_id', auth()->id())
            ->where('role', 'admin')
            ->exists();

        if ($comment->user_id !== auth()->id() && !$isAdmin) {
            abort(403, 'You can only delete your own comments.');
        }

        $post = $comment->post;
        $comment->delete();

        // Update comment count
        $post->update([
            'comment_count' => $post->comments()->count()
        ]);

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }
}
