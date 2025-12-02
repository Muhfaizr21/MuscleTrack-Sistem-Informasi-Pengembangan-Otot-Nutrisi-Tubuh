<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Models\PostComment;
use App\Models\PostLike;
use App\Models\CommentLike;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TrainerCommunityController extends Controller
{
    public function index()
    {
        $trainer = auth()->user();

        $communities = Community::with(['creator', 'members'])
            ->where(function ($query) use ($trainer) {
                // Public communities OR communities user is member of
                $query->where('is_public', true)
                    ->orWhereHas('members', function ($q) use ($trainer) {
                        $q->where('user_id', $trainer->id);
                    });
            })
            ->withCount(['members', 'posts'])
            ->orderBy('member_count', 'desc')
            ->paginate(12);

        $joinedCommunities = $trainer->communities()->pluck('communities.id');

        return view('trainer.communities.index', compact('communities', 'joinedCommunities'));
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
        $community->load(['creator', 'members.user', 'posts.user', 'posts.comments.user', 'posts.likes']);

        $isMember = $community->isMember(auth()->id());
        $userRole = $community->getMemberRole(auth()->id());

        $posts = $community->posts()
            ->with(['user', 'comments.user', 'likes'])
            ->withCount(['comments', 'likes'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('trainer.communities.show', compact('community', 'posts', 'isMember', 'userRole'));
    }

    public function edit(Community $community)
    {
        // Check if user is admin of the community
        if (!$this->isCommunityAdmin($community)) {
            // Check if user is at least a member
            if (!$community->isMember(auth()->id())) {
                abort(404, 'Community not found.');
            }

            // User is member but not admin
            return redirect()->route('trainer.communities.show', $community->slug)
                ->with('error', 'You do not have permission to edit this community. Only admins can edit community settings.');
        }

        return view('trainer.communities.edit', compact('community'));
    }

    public function update(Request $request, Community $community)
    {
        // Check if user is admin of the community
        if (!$this->isCommunityAdmin($community)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $community->id,
            'description' => 'required|string|max:1000',
            'is_public' => 'boolean',
            'image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        $updateData = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_public' => $request->is_public ?? true,
        ];

        // Handle remove image
        if ($request->has('remove_image') && $request->remove_image) {
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            $updateData['image'] = null;
        }

        // Handle remove cover image
        if ($request->has('remove_cover_image') && $request->remove_cover_image) {
            if ($community->cover_image) {
                Storage::disk('public')->delete($community->cover_image);
            }
            $updateData['cover_image'] = null;
        }

        $community->update($updateData);

        // Handle new image upload (overrides remove if both are present)
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            $imagePath = $request->file('image')->store('communities', 'public');
            $community->update(['image' => $imagePath]);
        }

        if ($request->hasFile('cover_image')) {
            // Delete old cover image if exists
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
        // Check if user is admin of the community
        if (!$this->isCommunityAdmin($community)) {
            abort(403, 'Unauthorized action.');
        }

        // Delete all community images
        if ($community->image) {
            Storage::disk('public')->delete($community->image);
        }
        if ($community->cover_image) {
            Storage::disk('public')->delete($community->cover_image);
        }

        // Delete all posts images (if any)
        foreach ($community->posts as $post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
        }

        $community->delete();

        return redirect()->route('trainer.communities.index')
            ->with('success', 'Community deleted successfully!');
    }

    public function join(Community $community)
    {
        // Check if already a member
        if (!$community->isMember(auth()->id())) {
            CommunityMember::create([
                'community_id' => $community->id,
                'user_id' => auth()->id(),
                'role' => 'member',
            ]);

            $community->incrementMemberCount();
            return back()->with('success', 'Successfully joined the community!');
        }

        return back()->with('info', 'You are already a member of this community.');
    }

    public function leave(Community $community)
    {
        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($membership) {
            // Prevent admin from leaving if they are the only admin
            if ($membership->role === 'admin') {
                $adminCount = CommunityMember::where('community_id', $community->id)
                    ->where('role', 'admin')
                    ->count();

                if ($adminCount <= 1) {
                    return back()->with('error', 'You cannot leave the community as you are the only admin. Please assign another admin first.');
                }
            }

            $membership->delete();
            $community->decrementMemberCount();

            return back()->with('success', 'Successfully left the community!');
        }

        return back()->with('error', 'You are not a member of this community.');
    }

    public function members(Community $community)
    {
        // Check if user is admin or moderator
        if (!$this->isCommunityAdminOrModerator($community)) {
            abort(403, 'Unauthorized action.');
        }

        $members = $community->members()
            ->with('user')
            ->orderByRaw("FIELD(role, 'admin', 'moderator', 'member')")
            ->orderBy('created_at', 'desc')
            ->get();

        $pendingMembers = $community->members()
            ->where('status', 'pending')
            ->with('user')
            ->get();

        return view('trainer.communities.members', compact('community', 'members', 'pendingMembers'));
    }

    public function updateMemberRole(Request $request, Community $community, User $user)
    {
        // Only admin can change roles
        if (!$this->isCommunityAdmin($community)) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'role' => 'required|in:admin,moderator,member'
        ]);

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership) {
            $membership->update(['role' => $request->role]);
            return back()->with('success', 'Member role updated successfully!');
        }

        return back()->with('error', 'Unable to update member role.');
    }

    public function removeMember(Community $community, User $user)
    {
        // Admin or moderator can remove members
        if (!$this->isCommunityAdminOrModerator($community)) {
            abort(403, 'Unauthorized action.');
        }

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        // Prevent removing yourself or other admins
        if ($membership) {
            if ($membership->role === 'admin') {
                return back()->with('error', 'Cannot remove admin members.');
            }

            // Moderators can only remove members, not other moderators
            if ($this->getUserRole($community) === 'moderator' && $membership->role === 'moderator') {
                return back()->with('error', 'Moderators cannot remove other moderators.');
            }

            $membership->delete();
            $community->decrementMemberCount();
            return back()->with('success', 'Member removed successfully!');
        }

        return back()->with('error', 'Member not found.');
    }

    public function storePost(Request $request, Community $community)
    {
        $request->validate([
            'content' => 'required|string|max:2000',
            'type' => 'required|in:discussion,achievement,question,workout_log,progress,tips,resources',
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

    public function updatePost(Request $request, CommunityPost $post)
    {
        // Check if user can update the post
        if (!$this->canManagePost($post)) {
            return back()->with('error', 'You are not authorized to update this post.');
        }

        $request->validate([
            'content' => 'required|string|max:2000',
            'type' => 'required|in:discussion,achievement,question,workout_log,progress,tips,resources',
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

    public function destroyPost(CommunityPost $post)
    {
        // Check if user can delete the post
        if (!$this->canManagePost($post)) {
            abort(403, 'Unauthorized action.');
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

    public function storeComment(Request $request, CommunityPost $post)
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

    public function updateComment(Request $request, PostComment $comment)
    {
        // Check if user can update the comment
        if (!$this->canManageComment($comment)) {
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

    public function destroyComment(PostComment $comment)
    {
        // Check if user can delete the comment
        if (!$this->canManageComment($comment)) {
            abort(403, 'Unauthorized action.');
        }

        $post = $comment->post;
        $comment->delete();

        $post->decrementCommentCount();

        return back()->with('success', 'Comment deleted successfully!');
    }

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

    // HELPER METHODS
    private function isCommunityAdmin(Community $community): bool
    {
        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', auth()->id())
            ->first();

        return $membership && $membership->role === 'admin';
    }

    private function isCommunityAdminOrModerator(Community $community): bool
    {
        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', auth()->id())
            ->first();

        return $membership && in_array($membership->role, ['admin', 'moderator']);
    }

    private function getUserRole(Community $community): ?string
    {
        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', auth()->id())
            ->first();

        return $membership ? $membership->role : null;
    }

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

    private function canManageComment(PostComment $comment): bool
    {
        $user = auth()->user();

        // User owns the comment
        if ($comment->user_id === $user->id) {
            return true;
        }

        // User is admin/moderator of the community
        $membership = $comment->post->community->members()
            ->where('user_id', $user->id)
            ->where('status', 'approved')
            ->first();

        return $membership && in_array($membership->role, ['admin', 'moderator']);
    }
}
