<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserCommunityController extends Controller
{
    public function index()
    {
        $communities = Community::with(['creator', 'members'])
            ->where('is_public', true)
            ->orWhereHas('members', function ($query) {
                $query->where('user_id', auth()->id());
            })
            ->withCount(['members', 'posts'])
            ->orderBy('member_count', 'desc')
            ->paginate(12);

        $joinedCommunities = auth()->user()->communities()->pluck('communities.id');

        return view('user.communities.index', compact('communities', 'joinedCommunities'));
    }

    public function create()
    {
        return view('user.communities.create');
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

        return redirect()->route('user.communities.show', $community->slug)
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

        return view('user.communities.show', compact('community', 'posts', 'isMember', 'userRole'));
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
            return redirect()->route('user.communities.show', $community->slug)
                ->with('error', 'You do not have permission to edit this community. Only admins can edit community settings.');
        }

        return view('user.communities.edit', compact('community'));
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

        return redirect()->route('user.communities.show', $community->slug)
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

        return redirect()->route('user.communities.index')
            ->with('success', 'Community deleted successfully!');
    }

    public function join(Community $community)
    {
        // Check if community is private and user needs approval
        if (!$community->is_public) {
            // For private communities, create a pending membership
            if (!$community->isMember(auth()->id())) {
                CommunityMember::create([
                    'community_id' => $community->id,
                    'user_id' => auth()->id(),
                    'role' => 'member',
                    'status' => 'pending', // Add status field for private communities
                ]);
                return back()->with('info', 'Join request sent. Waiting for approval.');
            }
        } else {
            // For public communities, join directly
            if (!$community->isMember(auth()->id())) {
                CommunityMember::create([
                    'community_id' => $community->id,
                    'user_id' => auth()->id(),
                    'role' => 'member',
                ]);

                $community->incrementMemberCount();
                return back()->with('success', 'Successfully joined the community!');
            }
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

    // MEMBERS MANAGEMENT METHODS
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

        return view('user.communities.members', compact('community', 'members', 'pendingMembers'));
    }

    public function promoteToModerator(Community $community, User $user)
    {
        // Only admin can promote to moderator
        if (!$this->isCommunityAdmin($community)) {
            abort(403, 'Unauthorized action.');
        }

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership && $membership->role === 'member') {
            $membership->update(['role' => 'moderator']);
            return back()->with('success', 'User promoted to moderator successfully!');
        }

        return back()->with('error', 'Unable to promote user.');
    }

    public function demoteToMember(Community $community, User $user)
    {
        // Only admin can demote moderators
        if (!$this->isCommunityAdmin($community)) {
            abort(403, 'Unauthorized action.');
        }

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership && $membership->role === 'moderator') {
            $membership->update(['role' => 'member']);
            return back()->with('success', 'User demoted to member successfully!');
        }

        return back()->with('error', 'Unable to demote user.');
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

    // MEMBERSHIP APPROVAL METHODS (for private communities)
    public function approveMember(Community $community, User $user)
    {
        if (!$this->isCommunityAdminOrModerator($community)) {
            abort(403, 'Unauthorized action.');
        }

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership && $membership->status === 'pending') {
            $membership->update([
                'status' => 'approved',
                'approved_at' => now(),
                'approved_by' => auth()->id()
            ]);

            $community->incrementMemberCount();
            return back()->with('success', 'Member approved successfully!');
        }

        return back()->with('error', 'Unable to approve member.');
    }

    public function rejectMember(Community $community, User $user)
    {
        if (!$this->isCommunityAdminOrModerator($community)) {
            abort(403, 'Unauthorized action.');
        }

        $membership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if ($membership && $membership->status === 'pending') {
            $membership->delete();
            return back()->with('success', 'Join request rejected successfully!');
        }

        return back()->with('error', 'Unable to reject member.');
    }

    // TRANSFER OWNERSHIP METHOD
    public function transferOwnership(Community $community, User $user)
    {
        // Only current admin can transfer ownership
        if (!$this->isCommunityAdmin($community)) {
            abort(403, 'Unauthorized action.');
        }

        $newAdminMembership = CommunityMember::where('community_id', $community->id)
            ->where('user_id', $user->id)
            ->first();

        if (!$newAdminMembership) {
            return back()->with('error', 'User is not a member of this community.');
        }

        // Start transaction to ensure data consistency
        \DB::transaction(function () use ($community, $user, $newAdminMembership) {
            // Update current admin to moderator
            CommunityMember::where('community_id', $community->id)
                ->where('user_id', auth()->id())
                ->update(['role' => 'moderator']);

            // Update new admin
            $newAdminMembership->update(['role' => 'admin']);

            // Update community creator
            $community->update(['created_by' => $user->id]);
        });

        return back()->with('success', 'Community ownership transferred successfully!');
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
}
