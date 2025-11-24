<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AdminCommunityController extends Controller
{
    /**
     * 📊 Dashboard Communities
     */
    public function dashboard()
    {
        $totalCommunities = Community::count();
        $totalMembers = CommunityMember::count();
        $totalPosts = CommunityPost::count();

        // Communities dengan member terbanyak
        $topCommunities = Community::withCount('members')
            ->orderBy('members_count', 'desc')
            ->take(5)
            ->get();

        // Aktivitas terbaru
        $recentPosts = CommunityPost::with(['user', 'community'])
            ->latest()
            ->take(5)
            ->get();

        // Statistik pertumbuhan 7 hari terakhir
        $communityGrowth = Community::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.communities.dashboard', compact(
            'totalCommunities',
            'totalMembers',
            'totalPosts',
            'topCommunities',
            'recentPosts',
            'communityGrowth'
        ));
    }

    /**
     * 📋 List semua communities
     */
    public function index(Request $request)
    {
        $query = Community::with(['creator', 'members'])
            ->withCount(['members', 'posts']);

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'public') {
                $query->where('is_public', true);
            } elseif ($request->status == 'private') {
                $query->where('is_public', false);
            }
        }

        $communities = $query->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        return view('admin.communities.index', compact('communities'));
    }

    /**
     * ⚠️ Reports & Moderation - FIXED VERSION
     */
    public function reports()
    {
        // Posts terbaru untuk moderation
        $reportedPosts = CommunityPost::with(['user', 'community'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take(20)
            ->get();

        // FIX: Communities dengan masalah (kurang dari 5 member)
        $problematicCommunities = Community::with(['creator'])
            ->withCount(['members', 'posts'])
            ->get()
            ->filter(function($community) {
                // Hanya filter berdasarkan jumlah member < 5
                return $community->members_count < 5;
            })
            ->sortBy('members_count')
            ->take(10);

        return view('admin.communities.reports', compact(
            'reportedPosts',
            'problematicCommunities'
        ));
    }

    /**
     * 📈 Activity & Analytics
     */
    public function activity()
    {
        // Aktivitas terbaru - posts
        $recentPosts = CommunityPost::with(['user', 'community'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->take(20)
            ->get();

        // Recent members - handle joined_at dengan aman
        $recentMembers = CommunityMember::with(['user', 'community'])
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($member) {
                // Pastikan joined_at adalah Carbon instance
                if (!$member->joined_at instanceof Carbon) {
                    $member->joined_at = Carbon::parse($member->joined_at);
                }
                return $member;
            });

        // Top communities by activity
        $activeCommunities = Community::withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.communities.activity', compact(
            'recentPosts',
            'recentMembers',
            'activeCommunities'
        ));
    }

    /**
     * 🔍 Show Community Detail
     */
    public function show(Community $community)
    {
        $community->load(['creator', 'members.user', 'posts.user']);
        $memberCount = $community->members()->count();
        $postCount = $community->posts()->count();

        return view('admin.communities.show', compact(
            'community',
            'memberCount',
            'postCount'
        ));
    }

    /**
     * 🗑️ Hapus Community
     */
    public function destroy(Community $community)
    {
        try {
            // Hapus gambar jika ada
            if ($community->image) {
                Storage::disk('public')->delete($community->image);
            }
            if ($community->cover_image) {
                Storage::disk('public')->delete($community->cover_image);
            }

            $community->delete();

            return redirect()->route('admin.communities.index')
                ->with('success', 'Community berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus community: ' . $e->getMessage());
        }
    }

    /**
     * 🗑️ Hapus Post
     */
    public function destroyPost(CommunityPost $post)
    {
        try {
            $postTitle = $post->title ?: 'Post';
            $post->delete();

            return redirect()->back()
                ->with('success', "Post '{$postTitle}' berhasil dihapus!");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus post: ' . $e->getMessage());
        }
    }

    /**
     * 📊 Community Statistics
     */
    public function statistics()
    {
        $totalCommunities = Community::count();
        $totalMembers = CommunityMember::count();
        $totalPosts = CommunityPost::count();

        $publicCommunities = Community::where('is_public', true)->count();
        $privateCommunities = Community::where('is_public', false)->count();

        // Communities dengan pertumbuhan tercepat (7 hari terakhir)
        $recentCommunities = Community::where('created_at', '>=', now()->subDays(7))
            ->count();

        // Top 10 communities dengan member terbanyak
        $topCommunities = Community::withCount('members')
            ->orderBy('members_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.communities.statistics', compact(
            'totalCommunities',
            'totalMembers',
            'totalPosts',
            'publicCommunities',
            'privateCommunities',
            'recentCommunities',
            'topCommunities'
        ));
    }

    /**
     * 🔧 Bulk Actions - DIPERBAIKI
     */
    public function bulkActions(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete', // Hanya delete yang tersedia
            'community_ids' => 'required|array',
            'community_ids.*' => 'exists:communities,id'
        ]);

        $action = $request->action;
        $communityIds = $request->community_ids;

        try {
            switch ($action) {
                case 'delete':
                    $communities = Community::whereIn('id', $communityIds)->get();
                    foreach ($communities as $community) {
                        // Hapus gambar jika ada
                        if ($community->image) {
                            Storage::disk('public')->delete($community->image);
                        }
                        if ($community->cover_image) {
                            Storage::disk('public')->delete($community->cover_image);
                        }
                        $community->delete();
                    }
                    $message = count($communityIds) . ' communities telah dihapus!';
                    break;

                default:
                    $message = 'Aksi tidak dikenali!';
                    break;
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal melakukan aksi bulk: ' . $e->getMessage());
        }
    }
    public function suspend(Community $community)
    {
        try {
            $community->update(['is_suspended' => true]);

            return redirect()->back()
                ->with('success', "Community {$community->name} has been suspended successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal men-suspend community: ' . $e->getMessage());
        }
    }

    /**
     * ▶️ Activate Community
     */
    public function activate(Community $community)
    {
        try {
            $community->update(['is_suspended' => false]);

            return redirect()->back()
                ->with('success', "Community {$community->name} has been activated successfully.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengaktifkan community: ' . $e->getMessage());
        }
    }
}
