<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Models\PostComment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TrainerCommunityController extends Controller
{
    public function index()
    {
        $communities = Community::with(['creator', 'members'])
            ->where('created_by', auth()->id())
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', auth()->id())
                    ->whereIn('role', ['admin', 'moderator']);
            })
            ->withCount(['members', 'posts'])
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('trainer.communities.index', compact('communities'));
    }

    public function create()
    {
        return view('trainer.communities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:communities',
            'description' => 'required|string|max:1000',
            'is_public' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $community = Community::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_public' => $request->is_public ?? true,
            'created_by' => auth()->id(),
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('communities', 'public');
            $community->update(['image' => $imagePath]);
        }

        if ($request->hasFile('cover_image')) {
            $coverPath = $request->file('cover_image')->store('communities/covers', 'public');
            $community->update(['cover_image' => $coverPath]);
        }

        // Add creator as admin
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'role' => 'admin',
        ]);

        $community->incrementMemberCount();

        return redirect()->route('trainer.communities.show', $community->slug)
            ->with('success', 'Community created successfully!');
    }

    public function show(Community $community)
    {
        $this->authorize('view', $community);

        $community->load(['creator', 'members.user', 'posts.user', 'posts.comments.user', 'posts.likes']);

        $posts = $community->posts()
            ->with(['user', 'comments.user', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $userRole = $community->getMemberRole(auth()->id());

        return view('trainer.communities.show', compact('community', 'posts', 'userRole'));
    }

    public function edit(Community $community)
    {
        $this->authorize('update', $community);

        return view('trainer.communities.edit', compact('community'));
    }

    public function update(Request $request, Community $community)
    {
        $this->authorize('update', $community);

        $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $community->id,
            'description' => 'required|string|max:1000',
            'is_public' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $community->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_public' => $request->is_public ?? true,
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            $imagePath = $request->file('image')->store('communities', 'public');
            $community->update(['image' => $imagePath]);
        }

        if ($request->hasFile('cover_image')) {
            if ($community->cover_image) {
                Storage::disk('public')->delete($community->cover_image);
            }
            $coverPath = $request->file('cover_image')->store('communities/covers', 'public');
            $community->update(['cover_image' => $coverPath]);
        }

        return redirect()->route('trainer.communities.show', $community->slug)
            ->with('success', 'Community updated successfully!');
    }

    public function destroy(Community $community)
    {
        $this->authorize('delete', $community);

        // Delete images
        if ($community->image) {
            Storage::disk('public')->delete($community->image);
        }
        if ($community->cover_image) {
            Storage::disk('public')->delete($community->cover_image);
        }

        $community->delete();

        return redirect()->route('trainer.communities.index')
            ->with('success', 'Community deleted successfully!');
    }

    public function members(Community $community)
    {
        $this->authorize('manage', $community);

        $members = $community->members()
            ->with('user')
            ->orderBy('role')
            ->orderBy('joined_at')
            ->paginate(20);

        return view('trainer.communities.members', compact('community', 'members'));
    }

    public function updateMemberRole(Request $request, Community $community, User $user)
    {
        $this->authorize('manage', $community);

        $request->validate([
            'role' => 'required|in:admin,moderator,member',
        ]);

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $membership->update(['role' => $request->role]);

        return back()->with('success', 'Member role updated successfully!');
    }

    public function removeMember(Community $community, User $user)
    {
        $this->authorize('manage', $community);

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        // Prevent removing the creator
        if ($community->created_by === $user->id) {
            return back()->with('error', 'Cannot remove the community creator.');
        }

        $membership->delete();
        $community->decrementMemberCount();

        return back()->with('success', 'Member removed successfully!');
    }

    public function destroyPost(CommunityPost $post)
    {
        $this->authorize('manage', $post->community);

        $community = $post->community;

        // Delete image if exists
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        $community->decrementPostCount();

        return back()->with('success', 'Post deleted successfully!');
    }

    public function destroyComment(PostComment $comment)
    {
        $this->authorize('manage', $comment->post->community);

        $post = $comment->post;
        $comment->delete();

        $post->decrementCommentCount();

        return back()->with('success', 'Comment deleted successfully!');
    }
}
