<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UserCommunityController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $communities = Community::with(['members' => function ($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
            ->where(function ($query) use ($user) {
                $query->where('is_public', true)
                    ->orWhereHas('members', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    });
            })
            ->withCount(['members', 'posts'])
            ->orderBy('member_count', 'desc')
            ->paginate(12);

        // Get joined community IDs
        $joinedCommunities = $user->communityMemberships()->pluck('community_id')->toArray();

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
            'description' => 'required|string',
            'is_public' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $community = Community::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_public' => $request->is_public,
            'created_by' => auth()->id(),
            'image' => $request->file('image') ? $request->file('image')->store('communities', 'public') : null,
            'cover_image' => $request->file('cover_image') ? $request->file('cover_image')->store('communities/cover', 'public') : null,
        ]);

        // Create admin membership
        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'role' => 'admin',
            'joined_at' => now()
        ]);

        return redirect()->route('user.communities.show', $community)->with('success', 'Community created successfully!');
    }

    public function show(Community $community)
    {
        $user = auth()->user();
        $isMember = $community->members()->where('user_id', $user->id)->exists();

        if (!$community->is_public && !$isMember) {
            abort(403, 'This community is private. You need to join to view its content.');
        }

        $posts = $community->posts()
            ->with(['user', 'comments.user', 'likes'])
            ->withCount(['likes', 'comments'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $memberCount = $community->members()->count();
        $isAdmin = $community->members()
            ->where('user_id', $user->id)
            ->where('role', 'admin')
            ->exists();

        return view('user.communities.show', compact('community', 'posts', 'isMember', 'memberCount', 'isAdmin'));
    }

    public function edit(Community $community)
    {
        $isAdmin = $community->members()->where('user_id', auth()->id())->where('role', 'admin')->exists();

        if (!$isAdmin) {
            abort(403, 'Only community admins can edit this community.');
        }

        return view('user.communities.edit', compact('community'));
    }

    public function update(Request $request, Community $community)
    {
        $isAdmin = $community->members()->where('user_id', auth()->id())->where('role', 'admin')->exists();

        if (!$isAdmin) {
            abort(403, 'Only community admins can edit this community.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:communities,name,' . $community->id,
            'description' => 'required|string',
            'is_public' => 'required|boolean',
            'image' => 'nullable|image|max:2048',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_public' => $request->is_public,
        ];

        if ($request->hasFile('image')) {
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            $data['image'] = $request->file('image')->store('communities', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($community->cover_image) {
                Storage::disk('public')->delete($community->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('communities/cover', 'public');
        }

        $community->update($data);

        return redirect()->route('user.communities.show', $community)->with('success', 'Community updated successfully!');
    }

    public function destroy(Community $community)
    {
        $isAdmin = $community->members()->where('user_id', auth()->id())->where('role', 'admin')->exists();

        if (!$isAdmin) {
            abort(403, 'Only community admins can delete this community.');
        }

        if ($community->image) {
            Storage::disk('public')->delete($community->image);
        }
        if ($community->cover_image) {
            Storage::disk('public')->delete($community->cover_image);
        }

        $community->delete();

        return redirect()->route('user.communities.index')->with('success', 'Community deleted successfully!');
    }

    public function join(Community $community)
    {
        $user = auth()->user();

        if ($community->members()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'You are already a member of this community.');
        }

        CommunityMember::create([
            'community_id' => $community->id,
            'user_id' => $user->id,
            'role' => 'member',
            'joined_at' => now()
        ]);

        // Update member count
        $community->update([
            'member_count' => $community->members()->count()
        ]);

        return redirect()->back()->with('success', 'Successfully joined the community!');
    }

    public function leave(Community $community)
    {
        $user = auth()->user();
        $membership = $community->members()->where('user_id', $user->id)->first();

        if (!$membership) {
            return redirect()->back()->with('error', 'You are not a member of this community.');
        }

        // Prevent admin from leaving if they're the only admin
        if ($membership->role === 'admin') {
            $adminCount = $community->members()->where('role', 'admin')->count();
            if ($adminCount === 1) {
                return redirect()->back()->with('error', 'You are the only admin. Please assign another admin before leaving.');
            }
        }

        $membership->delete();

        // Update member count
        $community->update([
            'member_count' => $community->members()->count()
        ]);

        return redirect()->back()->with('success', 'Successfully left the community.');
    }
}
