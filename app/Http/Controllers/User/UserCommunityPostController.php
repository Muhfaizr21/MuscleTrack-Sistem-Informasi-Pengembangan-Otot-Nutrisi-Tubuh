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
        $isMember = $community->members()->where('user_id', auth()->id())->exists();

        if (!$community->is_public && !$isMember) {
            abort(403, 'You need to join this community to post.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
            'type' => 'required|in:discussion,achievement,question,workout_log,progress'
        ]);

        $post = CommunityPost::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
            'image' => $request->file('image') ? $request->file('image')->store('community/posts', 'public') : null,
            'type' => $request->input('type'),
        ]);

        // Update post count
        $community->update([
            'post_count' => $community->posts()->count()
        ]);

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function update(Request $request, CommunityPost $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403, 'You can only edit your own posts.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'image' => 'nullable|image|max:2048',
            'type' => 'required|in:discussion,achievement,question,workout_log,progress'
        ]);

        $data = [
            'content' => $request->input('content'),
            'type' => $request->input('type'),
        ];

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $data['image'] = $request->file('image')->store('community/posts', 'public');
        }

        $post->update($data);

        return redirect()->back()->with('success', 'Post updated successfully!');
    }

    public function destroy(CommunityPost $post)
    {
        $isAdmin = $post->community->members()
            ->where('user_id', auth()->id())
            ->where('role', 'admin')
            ->exists();

        if ($post->user_id !== auth()->id() && !$isAdmin) {
            abort(403, 'You can only delete your own posts.');
        }

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $community = $post->community;
        $post->delete();

        // Update post count
        $community->update([
            'post_count' => $community->posts()->count()
        ]);

        return redirect()->back()->with('success', 'Post deleted successfully!');
    }
}
