<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CommunityPost;
use App\Models\PostComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserCommunityCommentController extends Controller
{
    public function store(Request $request, CommunityPost $post)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:post_comments,id',
        ]);

        // Check if user is member of the community
        if (!$post->community->isMember(auth()->id())) {
            return back()->with('error', 'You must be a member to comment in this community.');
        }

        $comment = PostComment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content,
        ]);

        $post->incrementCommentCount();

        return back()->with('success', 'Comment added successfully!');
    }

    public function update(Request $request, PostComment $comment)
    {
        // Gunakan Gate untuk authorization
        if (!Gate::allows('update', $comment)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment updated successfully!');
    }

    public function destroy(PostComment $comment)
    {
        // Gunakan Gate untuk authorization
        if (!Gate::allows('delete', $comment)) {
            abort(403, 'Unauthorized action.');
        }

        $post = $comment->post;
        $comment->delete();

        $post->decrementCommentCount();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
