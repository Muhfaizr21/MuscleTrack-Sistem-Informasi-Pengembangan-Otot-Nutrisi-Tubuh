<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserCommunityPostController extends Controller
{
    public function store(Request $request, Community $community)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'type' => 'required|in:discussion,achievement,question,workout_log,progress',
            'image' => 'nullable|image|max:2048',
        ]);

        // Check if user is member of the community
        if (!$community->isMember(auth()->id())) {
            return back()->with('error', 'You must be a member to post in this community.');
        }

        $post = CommunityPost::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'content' => $request->content,
            'type' => $request->type,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('community/posts', 'public');
            $post->update(['image' => $imagePath]);
        }

        $community->incrementPostCount();

        return back()->with('success', 'Post created successfully!');
    }

    public function update(Request $request, CommunityPost $post)
    {
        // Check if user can update the post
        if (!$this->canManagePost($post)) {
            return back()->with('error', 'You are not authorized to update this post.');
        }

        $request->validate([
            'content' => 'required|string|max:2000',
            'type' => 'required|in:discussion,achievement,question,workout_log,progress',
            'image' => 'nullable|image|max:2048',
        ]);

        $post->update([
            'content' => $request->content,
            'type' => $request->type,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $imagePath = $request->file('image')->store('community/posts', 'public');
            $post->update(['image' => $imagePath]);
        }

        // Handle image removal
        if ($request->has('remove_image') && $request->remove_image) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
                $post->update(['image' => null]);
            }
        }

        return back()->with('success', 'Post updated successfully!');
    }

    public function destroy(CommunityPost $post)
    {
        // Check if user can delete the post
        if (!$this->canManagePost($post)) {
            return back()->with('error', 'You are not authorized to delete this post.');
        }

        $community = $post->community;

        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        $community->decrementPostCount();

        return back()->with('success', 'Post deleted successfully!');
    }

    // HELPER METHODS
    private function canManagePost(CommunityPost $post): bool
    {
        $user = auth()->user();

        // User owns the post
        if ($post->user_id === $user->id) {
            return true;
        }

        // User is admin/moderator of the community
        $membership = $post->community->members()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();

        return $membership && in_array($membership->role, ['admin', 'moderator']);
    }
}
