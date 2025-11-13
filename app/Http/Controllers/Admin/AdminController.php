<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BodyMetric;
use App\Models\ContactMessage;
use App\Models\NewsArticle;
use App\Models\Payment;
use App\Models\User;
use App\Models\TrainerMembership;
use App\Models\TrainerProfile;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Stats Data - User & General
        $totalUsers = User::where('role', 'user')->count();
        $totalArticles = NewsArticle::count();
        $unreadMessages = ContactMessage::where('created_at', '>=', now()->subDays(7))->count();
        $premiumTransactions = Payment::where('status', 'paid')->count();

        // Trainer Stats - NEW
        $totalTrainers = User::where('role', 'trainer')->count();
        $verifiedTrainers = User::where('role', 'trainer')->where('verification_status', 'approved')->count();
        $pendingTrainers = User::where('role', 'trainer')->where('verification_status', 'pending')->count();
        $activeTrainerMemberships = TrainerMembership::count();

        // Trainer Performance Data - NEW
        $topTrainers = $this->getTopTrainers();
        $trainerPerformance = $this->getTrainerPerformanceData();

        // User Growth Data (30 hari terakhir)
        $userGrowthData = $this->getUserGrowthData();

        // Trainer Growth Data - NEW
        $trainerGrowthData = $this->getTrainerGrowthData();

        // User Progress Data
        $userProgressData = $this->getUserProgressData();

        // Recent Activities
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalArticles',
            'unreadMessages',
            'premiumTransactions',
            'totalTrainers',
            'verifiedTrainers',
            'pendingTrainers',
            'activeTrainerMemberships',
            'topTrainers',
            'trainerPerformance',
            'userGrowthData',
            'trainerGrowthData',
            'userProgressData',
            'recentActivities'
        ));
    }

    private function getUserGrowthData()
    {
        $labels = [];
        $data = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M j');

            $userCount = User::where('role', 'user')
                ->whereDate('created_at', '<=', $date)
                ->count();

            $data[] = $userCount;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getTrainerGrowthData()
    {
        $labels = [];
        $data = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $labels[] = $date->format('M j');

            $trainerCount = User::where('role', 'trainer')
                ->whereDate('created_at', '<=', $date)
                ->count();

            $data[] = $trainerCount;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    private function getUserProgressData()
    {
        $goals = ['Bulking', 'Cutting', 'Maintenance'];
        $progressData = [];

        foreach ($goals as $goal) {
            $avgMuscleMass = BodyMetric::join('users', 'body_metrics.user_id', '=', 'users.id')
                ->where('users.goal_id', function ($query) use ($goal) {
                    $query->select('id')
                        ->from('goals')
                        ->where('name', $goal);
                })
                ->avg('body_metrics.muscle_mass');

            $progressData[] = $avgMuscleMass ? round($avgMuscleMass, 1) : rand(60, 70);
        }

        return [
            'labels' => $goals,
            'data' => $progressData,
        ];
    }

    private function getTopTrainers()
    {
        return User::where('role', 'trainer')
            ->where('verification_status', 'approved')
            ->withCount(['trainerMembershipsAsTrainer as member_count'])
            ->with(['trainerProfile'])
            ->orderBy('member_count', 'desc')
            ->take(5)
            ->get()
            ->map(function ($trainer) {
                return [
                    'id' => $trainer->id,
                    'name' => $trainer->name,
                    'email' => $trainer->email,
                    'member_count' => $trainer->member_count,
                    'rating' => $trainer->trainerProfile->rating ?? 0,
                    'specialization' => $trainer->trainerProfile->specialization ?? 'General',
                    'avatar' => $trainer->avatar
                ];
            });
    }

    private function getTrainerPerformanceData()
    {
        $performance = DB::table('users')
            ->where('users.role', 'trainer')
            ->where('users.verification_status', 'approved')
            ->leftJoin('trainer_profiles', 'users.id', '=', 'trainer_profiles.user_id')
            ->leftJoin('trainer_memberships', 'users.id', '=', 'trainer_memberships.trainer_id')
            ->leftJoin('feedbacks', 'users.id', '=', 'feedbacks.trainer_id')
            ->select(
                'users.id',
                'users.name',
                DB::raw('COUNT(DISTINCT trainer_memberships.id) as total_members'),
                DB::raw('COALESCE(AVG(feedbacks.rating), 0) as avg_rating'),
                DB::raw('COUNT(DISTINCT feedbacks.id) as total_feedbacks')
            )
            ->groupBy('users.id', 'users.name')
            ->orderBy('total_members', 'desc')
            ->take(6)
            ->get();

        return [
            'labels' => $performance->pluck('name')->toArray(),
            'members' => $performance->pluck('total_members')->toArray(),
            'ratings' => $performance->pluck('avg_rating')->map(function ($rating) {
                return round($rating, 1);
            })->toArray()
        ];
    }

    private function getRecentActivities()
    {
        $activities = [];

        // Recent user registrations
        $recentUsers = User::where('role', 'user')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentUsers as $user) {
            $activities[] = [
                'type' => 'user_registered',
                'title' => 'User Baru Mendaftar',
                'description' => $user->email,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'user',
                'color' => 'green',
            ];
        }

        // Recent trainer registrations - NEW
        $recentTrainers = User::where('role', 'trainer')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentTrainers as $trainer) {
            $activities[] = [
                'type' => 'trainer_registered',
                'title' => 'Trainer Baru Mendaftar',
                'description' => $trainer->email,
                'time' => $trainer->created_at->diffForHumans(),
                'icon' => 'trainer',
                'color' => 'orange',
            ];
        }

        // Recent premium payments
        $recentPayments = Payment::with('user')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentPayments as $payment) {
            $activities[] = [
                'type' => 'premium_payment',
                'title' => 'Pembayaran Premium',
                'description' => 'Dari: '.($payment->user->name ?? 'Unknown User'),
                'time' => $payment->created_at->diffForHumans(),
                'icon' => 'payment',
                'color' => 'emerald',
            ];
        }

        // Recent trainer memberships - NEW
        $recentMemberships = TrainerMembership::with(['user', 'trainer'])
            ->orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentMemberships as $membership) {
            $activities[] = [
                'type' => 'trainer_assigned',
                'title' => 'Member Ditugaskan ke Trainer',
                'description' => $membership->user->name . ' → ' . $membership->trainer->name,
                'time' => $membership->created_at->diffForHumans(),
                'icon' => 'assignment',
                'color' => 'blue',
            ];
        }

        // Recent articles
        $recentArticles = NewsArticle::orderBy('created_at', 'desc')
            ->take(2)
            ->get();

        foreach ($recentArticles as $article) {
            $activities[] = [
                'type' => 'article_published',
                'title' => 'Artikel Baru Diposting',
                'description' => '"'.$article->title.'"',
                'time' => $article->created_at->diffForHumans(),
                'icon' => 'article',
                'color' => 'purple',
            ];
        }

        // Sort by time and take latest 8
        usort($activities, function ($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });

        return array_slice($activities, 0, 8);
    }
}
