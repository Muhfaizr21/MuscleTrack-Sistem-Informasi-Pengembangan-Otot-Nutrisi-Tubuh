<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Community;
use App\Models\CommunityMember;
use App\Models\CommunityPost;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
     * ⚠️ Reports & Moderation
     */
    public function reports()
    {
        // Posts dengan reports (jika ada kolom reports)
        $reportedPosts = CommunityPost::with(['user', 'community'])
            ->orderBy('created_at', 'desc')
            ->take(20)
            ->get();

        // Communities dengan masalah
        $problematicCommunities = Community::withCount('members')
            ->having('members_count', '<', 5) // Kurang dari 5 member
            ->orderBy('members_count')
            ->take(10)
            ->get();

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
        // Aktivitas terbaru
        $recentPosts = CommunityPost::with(['user', 'community'])
            ->latest()
            ->take(20)
            ->get();

        $recentMembers = CommunityMember::with(['user', 'community'])
            ->latest()
            ->take(20)
            ->get();

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
            $post->delete();

            return redirect()->back()
                ->with('success', 'Post berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus post: ' . $e->getMessage());
        }
    }

    /**
     * ⏸️ Suspend Community
     */
    public function suspend(Community $community)
    {
        try {
            $community->update(['is_suspended' => true]);

            return redirect()->back()
                ->with('warning', 'Community telah di-suspend!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mensuspend community: ' . $e->getMessage());
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
                ->with('success', 'Community telah diaktifkan kembali!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengaktifkan community: ' . $e->getMessage());
        }
    }
}
